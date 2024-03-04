<?php

namespace App\Http\Controllers\Admin\Config\Language;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\Localization\Language\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\Localization\Language\Model\Language;

class IndexLanguageController extends Controller
{
    use Breadcrumable;

    public function __invoke()
    {

        $languages = Language::orderBy('id')->get();

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        view()->share([
            'languages' => $languages,
        ]);

        return view('admin.config.language.index');
    }
}
