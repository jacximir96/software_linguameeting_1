<?php

namespace App\Src\CourseDomain\Section\Service;

use App\Src\CourseDomain\Section\Repository\SectionRepository;

class SectionCodeGenerator
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function generateCode(int $lenght = 6): string
    {
        $codeIsDuplicated = false;

        do {
            $code = $this->generateCodeNumbers($lenght);

            $section = $this->sectionRepository->findByCode($code);

            if ($section) {
                $codeIsDuplicated = true;
            }
        } while ($codeIsDuplicated);

        return $code;
    }

    private function generateCodeNumbers(int $lenght)
    {
        $key = '';
        $pattern = '1234567890';
        $max = strlen($pattern) - 1;

        for ($i = 0; $i < $lenght; $i++) {
            $key .= $pattern[rand(0, $max)];
        }

        return $key;
    }
}
