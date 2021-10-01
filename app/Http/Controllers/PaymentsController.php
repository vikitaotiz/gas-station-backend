<?php

namespace App\Http\Controllers;

use App\Http\Resources\Payments\PaymentResource;
use App\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::latest()->get();

        return PaymentResource::collection($payments);
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
            'title' => 'required'
        ]);

        $payment = Payment::create([
            'title' => $request->title,
            'user_id' => auth()->user()->id
        ]);

        return new PaymentResource($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $Payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        $this->validate($request, [
            'title' => 'required'
        ]);

        $payment->update([
            'title' => $request->title,
            'user_id' => auth()->user()->id
        ]);

        return new PaymentResource($payment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $Payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully!']);
    }
}
