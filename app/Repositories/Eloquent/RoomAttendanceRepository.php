<?php

namespace App\Repositories\Eloquent;

use App\Models\RoomAttendance;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\RoomAttendanceRepositoryInterface;

class RoomAttendanceRepository extends BaseRepository implements RoomAttendanceRepositoryInterface
{

    public function __construct(RoomAttendance $roomAttendance)
    {
        parent::__construct($roomAttendance);
    }
    protected function scopedQuery()
    {
        $tenantId = request()->header('X-Tenant-ID');

        return RoomAttendance::query()
            ->join('rooms', 'room_attendances.room_id', '=', 'rooms.id')
            ->join('nurseries', 'rooms.nursery_id', '=', 'nurseries.id')
            ->where('nurseries.tenant_id', $tenantId)
            ->select('room_attendances.*');
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
        return $this->model->create($data);
    }

    public function findByChildId($childId)
    {
        $tenantId = request()->header('X-Tenant-ID');

        return $this->model
            ->join('children', 'room_attendances.child_id', '=', 'children.id')
            ->join('nurseries', 'children.nursery_id', '=', 'nurseries.id')
            ->where('room_attendances.child_id', $childId)
            ->whereNull('room_attendances.check_out_time')
            ->where('nurseries.tenant_id', $tenantId)   
            ->select('room_attendances.*')
            ->first();
    }


    public function update($id, array $data)
    {
        $roomAttendance = RoomAttendance::findOrFail($id); 
        $roomAttendance->update($data);
        dd($roomAttendance);
        return $roomAttendance;
    }


    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
