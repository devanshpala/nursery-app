<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\RoomAttendanceRequest;
use App\Repositories\Interfaces\RoomAttendanceRepositoryInterface;

class RoomAttendanceController extends Controller
{

    protected $roomAttendanceRepository;
    public function __construct(RoomAttendanceRepositoryInterface $roomAttendanceRepository)
    {
        $this->roomAttendanceRepository = $roomAttendanceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roomAttendances = $this->roomAttendanceRepository->all();
        return response()->json($roomAttendances);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(RoomAttendanceRequest $request)
    // {
    //     $data = $request->validated();
    //     $data['check_in_time'] = now(); // Set check-in time to current time
    //     $roomAttendance = $this->roomAttendanceRepository->create($data);
    //     return response()->json(['message' => 'Room attendance created successfully'], 200);
    // }

    public function store(RoomAttendanceRequest $request)
    {
        $data = $request->validated();
        $childId = $data['child_id'];
        $roomId  = $data['room_id'];
        $staffId = $data['staff_id'];

        // Step 1: Check if child is already checked into ANY room
        $activeAttendance = $this->roomAttendanceRepository->findByChildId($childId);

        if ($activeAttendance) {
            // If it's the same room + staff, block duplicate check-in
            if ($activeAttendance->room_id == $roomId && $activeAttendance->staff_id == $staffId) {
                return response()->json([
                    'message' => 'Child is already checked into this room with this staff.'
                ], 422);
            }

            // ✅ Otherwise, force checkout from the old room
            $activeAttendance->update([
                'check_out_time' => now(),
            ]);
        }

        // Step 2: Proceed with new check-in
        $data['check_in_time'] = now();
        $roomAttendance = $this->roomAttendanceRepository->create($data);

        return response()->json([
            'message' => 'Room attendance created successfully',
            'attendance' => $roomAttendance
        ], 200);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roomAttendance = $this->roomAttendanceRepository->find($id);
        return response()->json($roomAttendance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomAttendanceRequest $request, $id)
    {
        $data = $request->validated();
        $roomAttendance = $this->roomAttendanceRepository->update($id, $data);
        return response()->json($roomAttendance);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roomAttendance = $this->roomAttendanceRepository->find($id);
        $this->roomAttendanceRepository->delete($id);
        return response()->json($roomAttendance, 200);
    }


    public function checkOut($child_id)
    {
        $attendance = $this->roomAttendanceRepository->findByChildId($child_id);
        if (!$attendance) {
            return response()->json(['message' => 'Attendance record not found for the given child ID.'], 404);
        }
      
        $result = $this->roomAttendanceRepository->update($attendance->id, [
            'check_out_time' => now(),
        ]);
        

        return response()->json(['message' => 'Child checked out successfully'], 200);
    }

    public function occupants($room_id)
    {
        $room = \App\Models\Room::findOrFail($room_id);

        $tenantId = request()->header('X-Tenant-ID');

        if ($room->nursery->tenant_id != $tenantId) {
            return response()->json(['message' => 'Unauthorized access to this room'], 403);
        }

        $children = $room->roomAttendances()
            ->whereNull('check_out_time')
            ->with('child')
            ->get()
            ->pluck('child');

        if ($children->isEmpty()) {
            return response()->json(['message' => 'No children currently available in this room', 'data' => []], 200);
        }

        return response()->json(['message' => 'Children currently checked in this room', 'data' => $children], 200);
    }

}
