<?php

namespace App\Http\Controllers;

use App\PaymentMethod;
use Illuminate\Http\Request;
use Validator;

class PaymentMethodController extends Controller
{
    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\PaymentMethod  $paymentMethod
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);
        return view('pages.settings.payment.edit', compact('paymentMethod'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\PaymentMethod  $paymentMethod
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'label' => 'required',
            'payment_url' => 'required',
            'public_key' => 'required',
            'secret_key' => 'required',
            'merchant_email' => 'required'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->update($data);
        session()->flash('success', 'Payment Method updated successfully!');
        return redirect()->route('payment-gateway.edit',$paymentMethod->id);
    }
}
