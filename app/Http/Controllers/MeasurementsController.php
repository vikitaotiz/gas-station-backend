<?php

namespace App\Http\Controllers;

use App\Http\Resources\Measurements\MeasurementResource;
use App\Measurement;
use Illuminate\Http\Request;

class MeasurementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $measurements = Measurement::latest()->get();

        return MeasurementResource::collection($measurements);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $measurement = Measurement::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id
        ]);

        return new MeasurementResource($measurement);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Measurement  $Measurement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $measurement = Measurement::find($id);

        return $measurement;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Measurement  $Measurement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $measurement = Measurement::find($id);

        $this->validate($request, [
            'name' => 'required'
        ]);

        $measurement->update([
            'name' => $request->name,
            'user_id' => auth()->user()->id
        ]);

        return new MeasurementResource($measurement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Measurement  $Measurement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $measurement = Measurement::find($id);

        $measurement->delete();

        return response()->json(['message' => 'Measurement deleted successfully!']);
    }
}
