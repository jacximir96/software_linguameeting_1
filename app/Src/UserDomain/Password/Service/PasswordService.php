<?php

namespace App\Src\UserDomain\Password\Service;

class PasswordService
{
    const MIN_SIZE = 6;

    const SPECIAL_CHAR = '@#$%&+!=?';

    public function checkPassword(string $password, string $confirmPassword): PasswordResponse
    {
        $isValid = true;
        $messageSlug = 'is_valid';

        if (! $this->isEqual($password, $confirmPassword)) {
            $isValid = false;
            $messageSlug = 'not_match';
        } elseif (! $this->isPasswordStrong($password)) {
            $isValid = false;
            $messageSlug = 'more_stronger';
        }

        return new PasswordResponse($isValid, $this->obtainMessages($messageSlug));
    }

    public function generatePassword(int $passwordSize = self::MIN_SIZE): string
    {
        if ($passwordSize < self::MIN_SIZE) {
            $passwordSize = self::MIN_SIZE;
        }

        $chars = [];
        $chars[0] = str_shuffle('abcdefghijklmnopqrstuvwxyz');
        $chars[1] = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $chars[2] = str_shuffle('1234567890');
        $chars[3] = str_shuffle(self::SPECIAL_CHAR);

        $password = '';
        $positionChars = 0;

        do {
            $password = $password.$chars[$positionChars][0];                    //añadir el primer carácter del chars seleccionado
            $chars[$positionChars] = substr($chars[$positionChars], 1);  //eliminar ese primer caracter para que en el próximo turno se asigne el siguiente carácter

            $positionChars++;

            if ($positionChars > 3) {
                $positionChars = 0;
            }
        } while (strlen($password) < $passwordSize);

        return str_shuffle($password);
    }

    public function isEqual(string $passwordOne, string $passwordTwo): bool
    {
        return $passwordOne === $passwordTwo;
    }

    public function isPasswordStrong(string $password): bool
    {
        if (! $this->isLongEnought($password)) {
            return false;
        }

        if (! $this->hasAtLeastOneLowercase($password)) {
            return false;
        }

        if (! $this->hasAtLeastOneUppercase($password)) {
            return false;
        }

        if (! $this->hasAtLeastOneNumber($password)) {
            return false;
        }

        if (! $this->hasAtLeastOneSpecialChar($password)) {
            return false;
        }

        return true;
    }

    public function isLongEnought(string $password, int $minSize = self::MIN_SIZE): bool
    {
        if (strlen($password) < $minSize) {
            return false;
        }

        return true;
    }

    public function hasAtLeastOneLowercase(string $password): bool
    {
        $pattern = '/[a-z]/';

        return $this->checkPattern($pattern, $password);
    }

    public function hasAtLeastOneUppercase(string $password): bool
    {
        $pattern = '/[A-Z]/';

        return $this->checkPattern($pattern, $password);
    }

    public function hasAtLeastOneNumber(string $password): bool
    {
        $pattern = '/[0-9]/';

        return $this->checkPattern($pattern, $password);
    }

    public function hasAtLeastOneSpecialChar(string $password): bool
    {
        $pattern = '/['.self::SPECIAL_CHAR.']/';

        return $this->checkPattern($pattern, $password);
    }

    public function obtainMessages(string $slug)
    {
        if ($slug == 'not_match') {
            return trans('common_form.password.not_match');
        } elseif ($slug == 'more_stronger') {
            return trans('common_form.password.more_stronger');
        } elseif ($slug == 'is_valid') {
            return trans('common_form.password.valid');
        }

        return '';
    }

    private function checkPattern(string $pattern, string $password): bool
    {
        if (! preg_match($pattern, $password)) {
            return false;
        }

        return true;
    }
}
