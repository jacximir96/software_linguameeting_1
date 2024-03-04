<?php

namespace App\Src\ConversationPackageDomain\Package\Presenter\Api;

use App\Src\ConversationPackageDomain\Package\Repository\ConversationPackageRepository;
use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\ConversationPackageDomain\SessionType\Repository\SessionTypeRepository;
use Illuminate\Support\Collection;

/**
 * Gets all combination available for session number and duration settings
 * Class AvailabilitySetupPresenter
 */
class AvailabilitySetupPresenter
{
    private ConversationPackageRepository $conversationPackageRepository;

    private SessionTypeRepository $sessionTypeRepository;

    public function __construct(ConversationPackageRepository $conversationPackageRepository, SessionTypeRepository $sessionTypeRepository)
    {
        $this->conversationPackageRepository = $conversationPackageRepository;
        $this->sessionTypeRepository = $sessionTypeRepository;
    }

    public function handle(): AvailabilitySetupResponse
    {
        $sessionsType = $this->obtainSessionsType();

        $setups = collect();

        foreach ($sessionsType as $sessionType) {
            $availabilityResponse = new AvailabilitySetupSessionType($sessionType);

            $conversationPackages = $this->obtatinConversationPackagesAvailable($sessionType);

            foreach ($conversationPackages as $conversationPackage) {
                $availabilityResponse->putDurationSessionEnabled($conversationPackage->duration_session, $conversationPackage->number_session);
            }

            $setups->push($availabilityResponse);
        }

        return new AvailabilitySetupResponse($setups);
    }

    private function obtainSessionsType(): Collection
    {
        $smallGroup = $this->sessionTypeRepository->obtainSmallGroup();
        $oneAndOne = $this->sessionTypeRepository->obtainOneAndOne();

        return collect([
            $smallGroup->code => $smallGroup,
            $oneAndOne->code => $oneAndOne,
        ]);
    }

    private function obtatinConversationPackagesAvailable(SessionType $sessionType): Collection
    {
        $withExperiences = false;

        return $this->conversationPackageRepository->obtainForAvailability($sessionType, $withExperiences);
    }
}
