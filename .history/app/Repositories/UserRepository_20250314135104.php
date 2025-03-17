<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function createUser(array $data)
    {
        if (isset($data['password']) && !Hash::needsRehash($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->create($data);
    }

    public function updatePassword($userId, $password)
    {
        return $this->update($userId, [
            'password' => Hash::make($password)
        ]);
    }
}
