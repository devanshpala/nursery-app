<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function authorize()
    {
        return false;
    }

    public function storeRules()
    {
        return [
            'name'        => 'required|string|max:100',
            'capacity'    => 'nullable|integer|min:1',
            'nursery_id'  => 'required|exists:nurseries,id',
        ];
    }

    public function updateRules()
    {
        return [
            'name'        => 'sometimes|string|max:100',
            'capacity'    => 'sometimes|integer|min:1',
            'nursery_id'  => 'sometimes|exists:nurseries,id',
        ];
    }
}
