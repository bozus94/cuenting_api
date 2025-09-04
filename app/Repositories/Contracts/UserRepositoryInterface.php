<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    public function FindByEmail(string $id): ?User;

    public function create(array $data): User;

    public function updateLoginAt(User $model): bool;
}
