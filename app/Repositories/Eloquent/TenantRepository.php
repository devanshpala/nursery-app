<?php

namespace App\Repositories\Eloquent;

use App\Models\Tenant;
use App\Repositories\Interfaces\TenantRepositoryInterface;

class TenantRepository implements TenantRepositoryInterface
{
    public function all()
    {
        return Tenant::all();
    }

    public function find($id)
    {
        return Tenant::findOrFail($id);
    }

    public function create(array $data)
    {
        return Tenant::create($data);
    }

    public function update($id, array $data)
    {
        $tenant = Tenant::findOrFail($id);
        $tenant->update($data);
        return $tenant;
    }

    public function delete($id)
    {
        return Tenant::destroy($id);
    }
}
