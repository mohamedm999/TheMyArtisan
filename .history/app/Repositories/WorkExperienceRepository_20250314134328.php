<?php

namespace App\Repositories;

use App\Models\WorkExperience;
use App\Repositories\Interfaces\WorkExperienceRepositoryInterface;

class WorkExperienceRepository extends BaseRepository implements WorkExperienceRepositoryInterface
{
    public function __construct(WorkExperience $model)
    {
        parent::__construct($model);
    }

    public function findByArtisanId($artisanId)
    {
        return $this->model->where('artisan_id', $artisanId)->orderBy('is_current', 'desc')->orderBy('start_date', 'desc')->get();
    }

    public function createForArtisan($artisanId, array $data)
    {
        $data['artisan_id'] = $artisanId;
        return $this->create($data);
    }
}
