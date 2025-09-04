<?php

namespace App\Exceptions\Cuenting;

use App\Exceptions\ExceptionDomain;
use App\Enums\AuthErrors as Error;

class AuthException extends ExceptionDomain
{

    public function mapMessages(): string
    {
        return match ($this->codeDomain) {
            Error::AUTH_INVALID_CREDENTIALS->name => Error::AUTH_INVALID_CREDENTIALS->value,
            Error::AUTH_TOKEN_EXPIRED->name       => Error::AUTH_TOKEN_EXPIRED->value,
            Error::AUTH_TOKEN_INVALID->name       => Error::AUTH_TOKEN_INVALID->value,
            Error::AUTH_TOKEN_NOT_FOUND->name       => Error::AUTH_TOKEN_NOT_FOUND->value,
            Error::AUTH_EMAIL_TAKEN->name         => Error::AUTH_EMAIL_TAKEN->value,
            Error::UNAUTHENTICATED->name          => Error::UNAUTHENTICATED->value,
            default                         => "An error has occurred"
        };
    }
}
