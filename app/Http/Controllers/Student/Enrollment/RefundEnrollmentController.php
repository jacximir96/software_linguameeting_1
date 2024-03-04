<?php
namespace App\Http\Controllers\Student\Enrollment;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ActivityLog\Service\Properties\PropertyBuilder;
use App\Src\CourseDomain\Course\Exception\CourseHasStarted;
use App\Src\CourseDomain\Course\Exception\CourseStartsSoon;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Exception\EnrollmentWithSessions;
use App\Src\PaymentDomain\Payment\Exception\PaymentNotFound;
use App\Src\PaymentDomain\PaymentDetail\Service\PaymentDetailFinder;
use App\Src\StudentDomain\Enrollment\Action\CreditCardRefundAction;
use App\Src\StudentDomain\Enrollment\Action\RefundAction;
use App\Src\StudentDomain\Enrollment\Exception\EnrollmentHasFutureSession;
use App\Src\StudentDomain\Enrollment\Exception\EnrollmentIsNotActive;
use App\Src\StudentDomain\Enrollment\Exception\RefundFail;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Enrollment\Repository\EnrollmentRepository;
use App\Src\PaymentDomain\Payment\Exception\PaymentHasBeenRefunded;
use App\Src\PaymentDomain\Payment\Exception\TransactionIdIsEmpty;
use App\Src\PaymentDomain\Payment\Exception\PaymentNotExists;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;



class RefundEnrollmentController extends Controller
{
    use Breadcrumable;

    private EnrollmentRepository $enrollmentRepository;

    private PaymentDetailFinder $paymentDetailFinder;

    public function __construct (EnrollmentRepository $enrollmentRepository, PaymentDetailFinder $paymentDetailFinder){

        $this->enrollmentRepository = $enrollmentRepository;
        $this->paymentDetailFinder = $paymentDetailFinder;
    }

    public function __invoke(Enrollment $enrollment)
    {

        try{

            DB::beginTransaction();

            $paymentDetail = $this->paymentDetailFinder->findPaymentDetailByEnrollment($enrollment);

            if (is_null($paymentDetail)){
                throw new PaymentNotFound();
            }

            if ($enrollment->course()->isFree()){
                flash(trans('payment.refund.free_course'))->info();
            }
            elseif ($paymentDetail->payment->methodPayment->isCode()){
                flash(trans('payment.refund.code_course'))->info();
            }
            elseif ($paymentDetail->payment->methodPayment->isCreditCard()){

                $action = app(CreditCardRefundAction::class);
                $action->handle($enrollment, $paymentDetail, user());
            }

            $this->registerActivity($enrollment);

            $action = app(RefundAction::class);
            $enrollment = $action->handle($enrollment);

            DB::commit();

            flash('Refund completed succesfully. Please wait some days to view your refund in your bank account.')->success();

            return redirect()->route('get.student.dashboard');

        }
        catch (EnrollmentIsNotActive $exception){

            DB::rollBack();

            flash('There is not an active course.')->error();

            return redirect()->route('get.student.dashboard');
        }
        catch (EnrollmentHasFutureSession $exception){

            DB::rollBack();

            flash('A refund cannot be made if you have pending sessions.')->error();

            return redirect()->route('get.student.dashboard');

        }
        catch (CourseHasStarted $exception){

            DB::rollBack();

            flash('You can not get a refund because you have sessions assigned.')->error();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());
        }
        catch (CourseStartsSoon $exception){

            DB::rollBack();

            flash('You can not get a refund because you have sessions assigned.')->error();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());
        }
        catch (PaymentNotExists $exception){

            DB::rollBack();

            flash('There is not a payment or your course is open access or you paid with a bookstore code.')->error();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());
        }
        catch (TransactionIdIsEmpty $exception){

            DB::rollBack();

            flash('There is not a payment or your course is open access or you paid with a bookstore code.')->error();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());

        }
        catch (PaymentHasBeenRefunded $exception){

            DB::rollBack();

            flash('Transaction has already been fully refunded.')->info();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());

        }
        catch (RefundFail $exception){

            DB::rollBack();

            flash('Refund requests cannot be processed until 24 hours after the original payment. Please try again once 24 hours have elapsed. For more information contact support@linguameeting.com.')->error();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());

        }
        catch (PaymentNotFound $exception){

            DB::rollBack();

            flash('Course payment not found.')->error();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());

        }
        catch (EnrollmentWithSessions $exception){

            DB::rollBack();

            flash('You have selected sessions.')->error();

            return redirect()->route('get.student.enrollment.show', $enrollment->hashId());

        }
        catch (\Throwable $exception){

            DB::rollBack();

            Log::error('There is an error when refunding course from student.', [
                'enrollment' => $enrollment,
                'exception' => $exception,
            ]);

            return redirect()->route('get.student.dashboard');
        }
    }

    private function registerActivity(Enrollment $enrollment): Activity
    {
        $properties =  array_merge(
            PropertyBuilder::buildIp(request()->ip())->buildProperty('ip'),
            PropertyBuilder::buildEnrollment($enrollment)->buildProperty('enrollment', 'Course'),
        );

        return  activity()
            ->causedBy(user())
            ->performedOn($enrollment)
            ->withProperties($properties)
            ->log(config('linguameeting_log.activity.keys.student.course.refund'));
    }
}
