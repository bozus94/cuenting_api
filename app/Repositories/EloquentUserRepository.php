<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        $data["password"] = Hash::make($data["password"]);
        return User::create($data);
    }

    public function FindByEmail(string $email): ?User
    {
        return User::where("email", $email)->first();
    }

    public function updateLoginAt(User $user): bool
    {
        $user->last_login_at = Carbon::now();
        return $user->save();
    }
}
