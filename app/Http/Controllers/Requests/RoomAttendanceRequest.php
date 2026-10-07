<?php

namespace App\Http\Controllers\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomAttendanceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'child_id' => 'required|exists:children,id',
            'room_id'  => 'required|exists:rooms,id',
            'staff_id' => 'required|exists:staff,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $tenantId = $this->header('X-Tenant-ID');

            $childNurseryId = \App\Models\Child::find($this->child_id)?->nursery_id;
            $roomNurseryId  = \App\Models\Room::find($this->room_id)?->nursery_id;
            $staffNurseryId = \App\Models\Staff::find($this->staff_id)?->nursery_id;

            // Check if all nursery IDs match
            if (!($childNurseryId && $roomNurseryId && $staffNurseryId)) {
                $validator->errors()->add('ids', 'Invalid child, room, or staff reference.');
            } elseif ($childNurseryId !== $roomNurseryId || $childNurseryId !== $staffNurseryId) {
                $validator->errors()->add('ids', 'Child, room, and staff must belong to the same nursery.');
            }

            // Optional: also check tenant ownership
            $nurseryTenantId = \App\Models\Nursery::find($childNurseryId)?->tenant_id;
            if ($nurseryTenantId != $tenantId) {
                $validator->errors()->add('tenant', 'This nursery does not belong to your tenant.');
            }
        });
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException(
            $validator,
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }


}
