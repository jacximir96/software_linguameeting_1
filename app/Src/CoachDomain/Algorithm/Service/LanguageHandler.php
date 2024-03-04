<?php

namespace App\Src\CoachDomain\Algorithm\Service;


/**
 * All Concrete Handlers either handle a request or pass it to the next handler
 * in the chain.
 */
class LanguageHandler extends AbstractHandler
{
    public function handle(AvailabilityRequest $request): ?string
    {


        if ($request === "Banana") {
            return "Monkey: I'll eat the " . $request . ".\n";
        } else {
            return parent::handle($request);
        }
    }
}


