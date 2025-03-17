<?php

namespace App\Repositories;

use App\Models\Certification;
use App\Repositories\Interfaces\CertificationRepositoryInterface;

class CertificationRepository extends BaseRepository implements CertificationRepositoryInterface
{
    public function __construct(Certification $model)
    {
        parent::__construct($model);
    }

    public function findByArtisanId($artisanId)
    {
        return $this->model->where('artisan_id', $artisanId)->orderBy('valid_until', 'desc')->get();
    }

    public function createForArtisan($artisanId, array $data)
    {
        $data['artisan_id'] = $artisanId;
        return $this->create($data);
    }
}
