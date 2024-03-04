<?php

namespace App\Http\Controllers\Admin\Config\ConversationGuide\Template;

use App\Http\Controllers\Admin\Breadcrumable;
use App\Http\Controllers\Controller;
use App\Src\ConversationGuideDomain\Template\Model\Template;
use App\Src\ConversationGuideDomain\Template\Presenter\Breadcrumb\IndexBreadcrumb;

class IndexTemplateController extends Controller
{
    use Breadcrumable;

    public function __invoke()
    {

        $templates = Template::with('file')->orderBy('description', 'asc')->get();

        $this->buildBreadcrumbAndSendToView(IndexBreadcrumb::SLUG);

        view()->share([
            'templates' => $templates,
        ]);

        return view('admin.config.conversation-guide.template.index');
    }
}
