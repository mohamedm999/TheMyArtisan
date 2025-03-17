<?php

namespace App\Repositories\Interfaces;

interface WorkExperienceRepositoryInterface extends RepositoryInterface
{
    public function findByArtisanId($artisanId);
    public function createForArtisan($artisanId, array $data);
}
