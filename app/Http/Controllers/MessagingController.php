<?php

namespace App\Http\Controllers;

use App\Messaging;
use Illuminate\Http\Request;
use Validator;

class MessagingController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Messaging  $messaging
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $messaging = Messaging::findOrFail($id);
        return view('pages.settings.messaging.edit', compact('messaging'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Messaging  $messaging
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'from_name' => 'required|max:255',
            'from_email' => 'required|max:255',
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $messaging = Messaging::findOrFail($id);
        $messaging->update($data);
        session()->flash('success', 'Messaging Settings updated successfully!');
        return redirect()->route('payment-gateway.edit',$messaging->id);
    }
}
