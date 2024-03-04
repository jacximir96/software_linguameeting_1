<?php

namespace App\Src\CoachDomain\Algorithm\Service;


/**
 * The default chaining behavior can be implemented inside a base handler class.
 */
abstract class AbstractHandler implements Handler
{
    /**
     * @var Handler
     */
    private $nextHandler;

    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;
        // Returning a handler from here will let us link handlers in a
        // convenient way like this:
        // $monkey->setNext($squirrel)->setNext($dog);
        return $handler;
    }

    public function handle(AvailabilityRequest $request): ?string
    {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }

        return null;
    }
}
