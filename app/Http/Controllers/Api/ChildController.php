<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\ChildRequest;
use App\Repositories\Interfaces\ChildRepositoryInterface;

class ChildController extends Controller
{

    protected $childRepository;
     public function __construct(ChildRepositoryInterface $childRepository)
    {
        $this->childRepository = $childRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $children = $this->childRepository->all();
        return response()->json($children);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChildRequest $request)
    {
        $data = $request->validated();
        $child = $this->childRepository->create($data);
        return response()->json($child, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $child = $this->childRepository->find($id);
        return response()->json($child);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChildRequest $request, $id)
    {
        $data = $request->validated();
        $child = $this->childRepository->update($id, $data);
        return response()->json($child);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->childRepository->delete($id);
        return response()->json(null, 204);
    }
}
