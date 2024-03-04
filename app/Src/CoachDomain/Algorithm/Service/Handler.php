<?php
namespace App\Src\CoachDomain\Algorithm\Service;



interface Handler
{
    public function setNext(Handler $handler): Handler;

    public function handle(AvailabilityRequest $request): ?string;
}
