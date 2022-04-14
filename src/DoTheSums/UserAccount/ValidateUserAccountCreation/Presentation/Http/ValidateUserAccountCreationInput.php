<?php

declare(strict_types=1);

namespace App\DoTheSums\UserAccount\ValidateUserAccountCreation\Presentation\Http;

final class ValidateUserAccountCreationInput
{
    private string $otp;

    public function __construct(string $otp)
    {
        $this->otp = $otp;
    }

    public function getOtp(): string
    {
        return $this->otp;
    }
}
