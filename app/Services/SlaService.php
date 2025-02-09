<?php

namespace App\Services;

use App\Repositories\SLARepository;
use Illuminate\Support\Facades\Validator;

class SLAService
{
    protected $slaRepository;

    public function __construct(SLARepository $slaRepository)
    {
        $this->slaRepository = $slaRepository;
    }

    public function getAllSLAs($perPage = 10)
    {
        return $this->slaRepository->paginateSLAs($perPage);
    }

    public function getSLAById($id)
    {
        return $this->slaRepository->findById($id);
    }

    public function createSLA(array $data)
    {
        $validator = Validator::make($data, [
            'priority' => 'required|in:low,medium,high,critical',
            'response_time' => 'required|integer|min:1',
            'resolution_time' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        return ['sla' => $this->slaRepository->create($data)];
    }

    public function updateSLA($id, array $data)
    {
        $validator = Validator::make($data, [
            'priority' => 'required|in:low,medium,high,critical',
            'response_time' => 'required|integer|min:1',
            'resolution_time' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return ['error' => $validator->errors()];
        }

        $sla = $this->slaRepository->findById($id);

        if (!$sla) {
            return ['error' => 'SLA not found.'];
        }

        return $this->slaRepository->update($id, $data);
    }

    public function deleteSLA($id)
    {
        return $this->slaRepository->delete($id);
    }
}
