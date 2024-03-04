<?php

namespace App\Http\Controllers\Admin\Config\ConversationPackage;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ConversationPackageDomain\Package\Presenter\Breadcrumb\IndexBreadcrumb;
use App\Src\ConversationPackageDomain\Package\Repository\ConversationPackageRepository;

class IndexController extends Controller
{
    use Breadcrumable;

    private ConversationPackageRepository $conversationPackageRepository;

    public function __construct(ConversationPackageRepository $conversationPackageRepository){

        $this->conversationPackageRepository = $conversationPackageRepository;
    }

    public function __invoke()
    {
        $breadcrumb = new IndexBreadcrumb();
        $this->buildBreadcrumbInstanceAndSendToView($breadcrumb);

        $packages = $this->conversationPackageRepository->obtainAllForConfig();

        view()->share([
            'packages' => $packages,
        ]);

        return view('admin.config.conversation-package.index');
    }
}
