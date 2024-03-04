<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Service;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\Localization\TimeZone\Model\TimeZone;

class HtmlFormatter
{
    private Session $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function backgroundcolorByStatus(TimeZone $timeZone): string
    {

        if ($this->session->isFuture()) {
            return 'bg-primary';
        } elseif ($this->session->isRunning()) {
            return 'bg-corporate-color';
        } elseif ($this->session->isPast()) {
            return 'bg-danger';
        }

        return '';
    }
}
