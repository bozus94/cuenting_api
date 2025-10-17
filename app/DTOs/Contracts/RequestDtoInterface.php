<?php

namespace App\DTOs\Contracts;

interface RequestDtoInterface
{
  public static function fromArray(array $data);
  public function toArray(): array;
}
