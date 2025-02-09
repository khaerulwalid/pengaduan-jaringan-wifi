<?php

namespace App\Repositories;

use App\Models\SLA;

class SLARepository
{
    public function getAll()
    {
        return SLA::all();
    }

    public function paginateSLAs($perPage = 10)
    {
        return SLA::paginate($perPage);
    }

    public function findById($id)
    {
        return SLA::find($id);
    }

    public function create(array $data)
    {
        return SLA::create($data);
    }

    public function update($id, array $data)
    {
        $sla = $this->findById($id);

        if ($sla) {
            $sla->update($data);
            return $sla;
        }

        return null;
    }

    public function existsByPriorityExcept($priority, $id)
    {
        return SLA::where('priority', $priority)
            ->where('id', '!=', $id)
            ->exists();
    }

    public function delete($id)
    {
        $sla = SLA::findOrFail($id);
        return $sla->delete();
    }
}
