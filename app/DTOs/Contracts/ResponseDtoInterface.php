<?php

namespace App\DTOs\Contracts;

interface ResponseDtoInterface
{
  public function fromModel(): self;
  public function toArray(): array;
}
