<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChildRequest extends FormRequest
{
    public function authorize()
    {
        // Disable authorization for now
        return false;
    }

    /**
     * Validation rules for storing a new child
     */
    public function storeRules()
    {
        return [
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'dob'              => 'required|date',
            'guardian_contact' => 'required|string|max:15',
            'nursery_id'       => 'required|exists:nurseries,id',
        ];
    }

    /**
     * Validation rules for updating an existing child
     */
    public function updateRules()
    {
        return [
            'first_name'       => 'sometimes|string|max:100',
            'last_name'        => 'sometimes|string|max:100',
            'dob'              => 'sometimes|date',
            'guardian_contact' => 'sometimes|string|max:15',
            'nursery_id'       => 'sometimes|exists:nurseries,id',
        ];
    }
}
