<?php
namespace App\Http\Controllers\Admin\Config\AccommodationType;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\StudentDomain\AccommodationType\Model\AccommodationType;
use App\Src\StudentDomain\AccommodationType\Presenter\Breadcrumb\IndexBreadcrumb;


class IndexController extends Controller
{
    use Breadcrumable;

    public function __invoke()
    {

        $types = AccommodationType::orderBy('description')->get();

        $breadcrumb = new IndexBreadcrumb();

        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'types' => $types,
        ]);

        return view('admin.config.accommodation-type.index');
    }
}
