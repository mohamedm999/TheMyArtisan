<?php

namespace App\Repositories\Interfaces;

interface CertificationRepositoryInterface extends RepositoryInterface
{
    public function findByArtisanId($artisanId);
    public function createForArtisan($artisanId, array $data);
}
