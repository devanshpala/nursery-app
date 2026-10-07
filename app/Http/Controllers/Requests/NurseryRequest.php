<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NurseryRequest extends FormRequest
{
    public function authorize()
    {
        return false;
    }

    public function storeRules()
    {
        return [
            'name'    => 'required|string|max:150',
            'address' => 'required|string|max:255',
            'tenant_id' => 'required|exists:tenants,id',
        ];
    }

    public function updateRules()
    {
        return [
            'name'    => 'sometimes|string|max:150',
            'address' => 'sometimes|string|max:255',
            'tenant_id' => 'sometimes|exists:tenants,id',
        ];
    }
}
