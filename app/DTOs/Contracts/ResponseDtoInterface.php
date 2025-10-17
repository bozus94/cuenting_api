<?php

namespace App\DTOs\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ResponseDtoInterface
{
  public static function fromModel(Model $model): self;
  public function toArray(): array;
}
