<?php

namespace App\Repositories;

use App\Models\ArtisanProfile;
use App\Repositories\Interfaces\ArtisanProfileRepositoryInterface;

class ArtisanProfileRepository extends BaseRepository implements ArtisanProfileRepositoryInterface
{
    public function __construct(ArtisanProfile $model)
    {
        parent::__construct($model);
    }

    public function findByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->first();
    }

    public function updateOrCreate($userId, array $data)
    {
        return $this->model->updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }

    public function updateContactInfo($userId, array $data)
    {
        $profile = $this->findByUserId($userId);

        if (!$profile) {
            $data['user_id'] = $userId;
            return $this->create($data);
        }

        return $this->update($profile->id, $data);
    }

    public function updateBusinessInfo($userId, array $data)
    {
        $profile = $this->findByUserId($userId);

        if (!$profile) {
            $data['user_id'] = $userId;
            return $this->create($data);
        }

        return $this->update($profile->id, $data);
    }

    public function updateProfessionalInfo($userId, array $data)
    {
        $profile = $this->findByUserId($userId);

        if (!$profile) {
            $data['user_id'] = $userId;
            return $this->create($data);
        }

        // Handle skills as array
        if (isset($data['skills']) && is_string($data['skills'])) {
            $skills = array_map('trim', explode(',', $data['skills']));
            $data['skills'] = array_filter($skills);
        }

        return $this->update($profile->id, $data);
    }
}
