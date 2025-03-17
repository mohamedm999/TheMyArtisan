<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function findByEmail($email);
    public function createUser(array $data);
    public function updatePassword($userId, $password);
}
