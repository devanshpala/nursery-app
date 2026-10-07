<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
{
    public function authorize()
    {
        return false;
    }

    public function storeRules()
    {
        return [
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'role'        => 'required|string|max:50',
            'nursery_id'  => 'required|exists:nurseries,id',
        ];
    }

    public function updateRules()
    {
        return [
            'first_name'  => 'sometimes|string|max:100',
            'last_name'   => 'sometimes|string|max:100',
            'role'        => 'sometimes|string|max:50',
            'nursery_id'  => 'sometimes|exists:nurseries,id',
        ];
    }
}
