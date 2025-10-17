<?php

namespace App\DTOs\Contracts;

interface RequestDtoInterface
{
  public function fromArray(): self;
  public function toArray(): array;
}
