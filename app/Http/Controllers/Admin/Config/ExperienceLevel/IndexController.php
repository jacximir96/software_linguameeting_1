<?php
namespace App\Http\Controllers\Admin\Config\ExperienceLevel;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ExperienceDomain\Level\Model\Level;
use App\Src\ExperienceDomain\Level\Presenter\Breadcrumb\IndexBreadcrumb;


class IndexController extends Controller
{
    use Breadcrumable;

    public function __invoke()
    {

        $levels = Level::orderBy('name')->get();

        $breadcrumb = new IndexBreadcrumb();

        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        view()->share([
            'levels' => $levels,
        ]);

        return view('admin.config.experience-levels.index');
    }
}
