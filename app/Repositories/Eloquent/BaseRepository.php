<?php

namespace App\Repositories\Eloquent;

abstract class BaseRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    protected function scopedQuery()
    {
        $nurseryIds = request()->get('nursery_ids', []);
        return $this->model->whereIn('nursery_id', $nurseryIds);
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
        // Ensure nursery_id belongs to tenant
        if (!in_array($data['nursery_id'], request()->get('nursery_ids', []))) {
            throw new \Exception("Unauthorized nursery_id");
        }
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }
}
