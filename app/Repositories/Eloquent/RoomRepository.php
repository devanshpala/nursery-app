<?php

namespace App\Repositories\Eloquent;

use App\Models\Room;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\RoomRepositoryInterface;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{

    public function __construct(Room $room)
    {
        parent::__construct($room);
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
        $room = $this->find($id);
        $room->update($data);
        return $room;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
