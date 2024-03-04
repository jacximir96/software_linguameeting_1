<?php

namespace App\Src\ConversationGuideDomain\Template\Repository;

use App\Src\ConversationGuideDomain\Template\Model\Template;
use Illuminate\Support\Collection;

class TemplateRepository
{
    public function all(): Collection
    {
        return Template::with('file')->orderBy('description', 'asc')->get();
    }
}
