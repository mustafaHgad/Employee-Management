<?php

namespace App\Services;

use App\Repositories\Contracts\AuthRepoInterface;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthService
{
    public function __construct(protected AuthRepoInterface $repo){}

    public function register(array $data): array
    {
        $user = $this->repo->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user'  => $user->only(['id', 'name', 'email']),
            'token' => $token,
        ];
    }

    public function login(array $credentials): ?array
    {
        $user = $this->repo->findByEmail($credentials['email']);

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user'  => $user->only(['id', 'name', 'email']),
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
