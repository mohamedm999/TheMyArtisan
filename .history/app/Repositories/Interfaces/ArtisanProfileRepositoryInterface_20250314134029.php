<?php

namespace App\Repositories\Interfaces;

interface ArtisanProfileRepositoryInterface extends RepositoryInterface
{
    public function findByUserId($userId);
    public function updateOrCreate($userId, array $data);
    public function updateContactInfo($userId, array $data);
    public function updateBusinessInfo($userId, array $data);
    public function updateProfessionalInfo($userId, array $data);
}
