<?php

namespace App\Repositories\Eloquent;

use App\Models\Child;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\ChildRepositoryInterface;

class ChildRepository extends BaseRepository implements ChildRepositoryInterface
{
    public function __construct(Child $child)
    {
        parent::__construct($child);
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
        $child = $this->find($id);
        $child->update($data);
        return $child;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
