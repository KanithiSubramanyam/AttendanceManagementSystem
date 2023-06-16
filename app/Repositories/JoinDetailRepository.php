<?php

namespace App\Repositories;

use App\Models\JoinDetail;
use App\Repositories\BaseRepository;

class JoinDetailRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'employee_id',
        'join_date'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return JoinDetail::class;
    }
}
