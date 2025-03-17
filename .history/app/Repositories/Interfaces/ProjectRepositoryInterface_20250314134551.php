<?php

namespace App\Repositories\Interfaces;

interface ProjectRepositoryInterface extends RepositoryInterface
{
    public function findByUserId($userId);
    public function findByArtisanId($artisanId);
}
