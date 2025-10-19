<?php

namespace App\Exceptions\Cuenting;

use App\Exceptions\BaseException;
use App\Enums\DomainErrors as Error;

class DomainException extends BaseException
{
    public function mapMessages(): string
    {
        return match ($this->codeDomain) {
            Error::ENTITY_ALREADY_EXIST->name => Error::ENTITY_ALREADY_EXIST->value,
            Error::REGISTER_PROCESSING_OPERATION->name => Error::REGISTER_PROCESSING_OPERATION->value,
            default => "Has occurred error domain"
        };
    }
}
