<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\NurseryRequest;
use App\Repositories\Interfaces\NurseryRepositoryInterface;

class NurseryController extends Controller
{

    protected $nurseryRepository;
     public function __construct(NurseryRepositoryInterface $nurseryRepository)
    {
        $this->nurseryRepository = $nurseryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nurseries = $this->nurseryRepository->all();
        return response()->json($nurseries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NurseryRequest $request)
    {
        $data = $request->validated();
        $nursery = $this->nurseryRepository->create($data);
        return response()->json($nursery, 201);
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
