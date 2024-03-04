<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Presenter;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;

//sesions que el alumno ya ha seleccionado
class NextSessionExisting
{
    private Session $session;

    public function __construct (Session $session){

        $this->session = $session;

    }

    public function session(): Session
    {
        return $this->session;
    }
}
