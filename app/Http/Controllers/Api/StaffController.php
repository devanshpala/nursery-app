<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\StaffRequest;
use App\Repositories\Interfaces\StaffRepositoryInterface;

class StaffController extends Controller
{
    protected $staffRepository;
    public function __construct(StaffRepositoryInterface $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffs = $this->staffRepository->all();
        return response()->json($staffs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StaffRequest $request)
    {
        $data = $request->validated();
        $staff = $this->staffRepository->create($data);
        return response()->json($staff, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $staff = $this->staffRepository->find($id);
        return response()->json($staff);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StaffRequest $request, $id)
    {
        $data = $request->validated();
        $staff = $this->staffRepository->update($id, $data);
        return response()->json($staff);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $staff = $this->staffRepository->find($id);
        $this->staffRepository->delete($id);
        return response()->json($staff, 204);
    }
}
