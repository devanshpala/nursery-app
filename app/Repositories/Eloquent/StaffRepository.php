<?php

namespace App\Repositories\Eloquent;

use App\Models\Staff;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\StaffRepositoryInterface;

class StaffRepository extends BaseRepository implements StaffRepositoryInterface
{

    public function __construct(Staff $staff)
    {
        parent::__construct($staff);
    }

    protected function scopedQuery()
    {
        $tenantId = request()->header('X-Tenant-ID');

        return Staff::query()
            ->join('nurseries', 'staff.nursery_id', '=', 'nurseries.id')
            ->where('nurseries.tenant_id', $tenantId)
            ->select('staff.*');
    }
    public function all()
    {
        return $this->scopedQuery()->get();
    }

    public function find($id)
    {
        return $this->scopedQuery()->findOrFail($id);
    }

    public function create(array $data)
    {
        $data['nursery_id'] = request()->get('nursery_ids')[0] ?? null;
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $staff = $this->find($id);
        $staff->update($data);
        return $staff;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
