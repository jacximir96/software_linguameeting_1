<?php

namespace App\Src\Shared\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;

class ItemLink implements Item
{
    private HtmlLink $htmlLink;

    public function __construct(HtmlLink $htmlLink)
    {
        $this->htmlLink = $htmlLink;
    }

    public function link(): HtmlLink
    {
        return $this->htmlLink;
    }

    public function isLink(): bool
    {
        return true;
    }
}
