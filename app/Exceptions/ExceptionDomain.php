<?php

namespace App\Exceptions;

use App\Traits\CuentingResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

abstract class ExceptionDomain extends Exception
{
    use CuentingResponse;

    public function __construct(public readonly string $codeDomain, public readonly int $httpStatus = 400, public readonly array $errors = [], string $message = '')
    {
        parent::__construct($message ?: $codeDomain, $httpStatus);
    }

    public function render(Request $request): JsonResponse
    {
        return $this->failure($this->codeDomain, $this->mapMessages(), $this->errors, $this->httpStatus);
    }

    abstract function mapMessages(): string;
}
