<?php

namespace App\Src\InstructorDomain\Instructor\Repository;

use App\Src\Shared\Repository\BuilderRepository;
use App\Src\Shared\Repository\SearchRepository;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\Shared\Service\OrderListing;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UniversityDomain\Instructor\Model\UniversityInstructor;
use App\Src\UserDomain\User\Model\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class InstructorRepository implements SearchRepository
{
    private BuilderRepository $builderRepository;

    public function __construct(BuilderRepository $builderRepository)
    {

        $this->builderRepository = $builderRepository;
    }

    public function obtainInstructorsForIndex()
    {
        return User::query()
            ->role(config('linguameeting.user.roles.instructor'))
            ->orderBy('created_at', 'DESC')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function obtainByUniversityAndRole(University $university, Role $role)
    {

        return User::query()
            ->role($role)
            ->whereHas('university', function ($query) use ($university) {
                $query->where('university.id', $university->id);
            })
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function obtainUniversityByUser(User $user):?UniversityInstructor
    {
        return UniversityInstructor::query()
        ->where('instructor_id', $user->id)
        ->first();
    }

    public function obtainInstructorByUniversityForIndex(UniversityInstructor $university,User $user,array $ids)
    {
        return User::query()
            ->select(DB::raw("user.*,university_instructor.university_id as id_uni_rel,university_instructor.instructor_id as id_rel_inst,university.country_id,model_has_roles.role_id"))
            ->role(config('linguameeting.user.roles.instructor'))
            ->leftJoin('model_has_roles','user.id','=','model_has_roles.model_id')
            ->leftJoin('university_instructor','user.id','=','university_instructor.instructor_id')
            ->leftJoin('university','university_instructor.university_id','=','university.id')
            ->whereNull('user.deleted_at')
            ->where('user.id', '!=' , $user->id)
            ->whereIn('model_has_roles.role_id',$ids)
            ->whereHas('university', function ($query) use ($university) {
                $query->where('university.id', $university->university_id);
            })
            ->orderBy('user.created_at', 'DESC')
            ->get();
    }

    public function search(CriteriaSearch $criteria, OrderListing $orderListing = null, array $relationshipsToAdd = [])
    {
        $query = User::query()
            ->with($this->relations($relationshipsToAdd));

        $query = $this->builderRepository->buildSimpleWhereLike($query, $criteria, 'name', 'lastname', 'email');

        $query = $this->builderRepository->buildWhereByUserLanguage($query, $criteria);

        $query = $this->builderRepository->buildWhereByUserStatus($query, $criteria);

        $query = $this->builderRepository->buildWhereByRol($query, $criteria, config('linguameeting.user.roles.instructor'));

        if ($criteria->searchByMultiple('course_id')) {

            $query->where(function ($query) use ($criteria) {

                $query->whereHas('sectionInstructor', function ($query) use ($criteria) {
                    $query->whereIn('course_id', $criteria->getMultiple('course_id'));
                });
            })->orWhere(function ($query) use ($criteria) {

                $query->whereHas('sectionAssistant', function ($query) use ($criteria) {
                    $query->whereHas('section', function ($query) use ($criteria) {
                        $query->whereIn('course_id', $criteria->getMultiple('course_id'));
                    });

                });
            });
        } elseif ($criteria->searchBy('university_id')) {
            $query->whereHas('university', function ($query) use ($criteria) {
                $query->whereIn('university.id', collect($criteria->get('university_id')));
            });
        }

        if ($orderListing) {
            $query = $query->orderBy($orderListing->field(), $orderListing->direction());
        } else {
            $query->orderBy('lastname')->orderBy('name');
        }

        if ($criteria->hasPaginate()) {
            return $query->paginate(config('linguameeting.items_per_page'));
        }

        return $query->get();
    }

    public function courseRelationship(): array
    {

        return [
            'courseCoordinator',
            'courseCoordinator.course',
            'denyAccess',
            'denyAccess.course',
            'sectionInstructor',
            'sectionInstructor.course',
            'sectionAssistant',
            'sectionAssistant.section.course',
        ];
    }

    public function relations(array $relatioshipsToAdd = []): array
    {
        $rel = [
            'country',
            'instructorOf',
            'instructedBy',
            'timezone',
            'language',
            'university',
            'university.course',
            'roles',
        ];

        if ($relatioshipsToAdd) {
            return array_merge($rel, $relatioshipsToAdd);
        }

        return $rel;
    }
}
