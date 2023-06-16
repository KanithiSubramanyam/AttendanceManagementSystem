<?php

namespace App\Repositories;

use App\Models\JoinDate;
use App\Repositories\BaseRepository;

class JoinDateRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'dob',
        'join_date'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return JoinDate::class;
    }
}
