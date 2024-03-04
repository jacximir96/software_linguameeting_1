<?php

namespace App\Src\RegisterCodeDomain\RegisterCode\Service;

use App\Src\RegisterCodeDomain\RegisterCode\Model\KeyCode;
use App\Src\RegisterCodeDomain\RegisterCode\Repository\CodeRepository;

class CodeGenerator
{
    private CodeRepository $codeRepository;

    private CodeRepository $registerCodeRepository;

    public function __construct(CodeRepository $codeRepository, CodeRepository $registerCodeRepository)
    {
        $this->codeRepository = $codeRepository;
        $this->registerCodeRepository = $registerCodeRepository;
    }

    public function buildBookstoreCode(): KeyCode
    {
        do {
            $code = $this->generateCode();

            $codeExists = $this->codeRepository->checkCodeExists($code);
        } while ($codeExists);

        return $code;
    }

    public function buildRegisterCode(): KeyCode
    {

        do {
            $first = $this->generateCodeRegister(6);
            $second = $this->generateCodeRegister(4);
            $keyCode = new KeyCode($first.'-'.$second);

            $codeExists = $this->registerCodeRepository->checkCodeExists($keyCode);
        } while ($codeExists);

        return $keyCode;
    }

    private function generateCode(): KeyCode
    {
        $code[0] = $this->generarCodeLetters(1).$this->generateCodeNumbers(3);
        $code[1] = $this->generateCodeNumbers(5);
        $code[2] = $this->generateCodeNumbers(4);
        $code[3] = $this->generateCodeNumbers(3);

        return new KeyCode('LM-'.$code[0].'-'.$code[1].'-'.$code[2].'-'.$code[3]);
    }

    private function generarCodeLetters($lenght)
    {
        $key = '';
        $pattern = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($pattern) - 1;

        for ($i = 0; $i < $lenght; $i++) {
            $key .= $pattern[mt_rand(0, $max)];
        }

        return $key;
    }

    private function generateCodeNumbers($lenght)
    {
        $key = '';
        $pattern = '1234567890';
        $max = strlen($pattern) - 1;

        for ($i = 0; $i < $lenght; $i++) {
            $key .= $pattern[mt_rand(0, $max)];
        }

        return $key;
    }

    private function generateCodeRegister($lenght)
    {

        $key = '';
        $pattern = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $max = strlen($pattern) - 1;

        for ($i = 0; $i < $lenght; $i++) {
            $key .= $pattern[mt_rand(0, $max)];
        }

        return $key;
    }
}
