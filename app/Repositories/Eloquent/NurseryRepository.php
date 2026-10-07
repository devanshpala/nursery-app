<?php

namespace App\Repositories\Eloquent;

use App\Models\Nursery;
use App\Repositories\Interfaces\NurseryRepositoryInterface;

class NurseryRepository extends BaseRepository implements NurseryRepositoryInterface
{
    public function __construct(Nursery $nursery)
    {
        parent::__construct($nursery);
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
        $data['tenant_id'] = request()->get('tenant_id');
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $nursery = $this->find($id);
        $nursery->update($data);
        return $nursery;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
