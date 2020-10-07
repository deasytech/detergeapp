<?php

namespace App\Http\Controllers;

use App\Prospect;
use Illuminate\Http\Request;
use Validator;
use Gate;
use yajra\Datatables\Datatables;
use App\Note;
use App\Customer;
use App\DataTables\ProspectDataTable;

class ProspectController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(ProspectDataTable $dataTable)
    {
        return $dataTable->render('pages.prospects.index');
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('pages.prospects.create');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'organisation' => 'required',
            'contact_email' => 'sometimes',
            'contact_phone_number' => 'sometimes',
            'nature_of_business' => 'sometimes',
            'physical_address' => 'sometimes',
            'feedback' => 'sometimes'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $prospect = Prospect::create($data);
        Note::create([
            'prospect_id' => $prospect->id,
            'details' => $data['feedback']
        ]);
        session()->flash('success', 'Prospect added successfully!');
        return redirect()->route('prospect.index');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function feedback(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'details' => 'required'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $prospect = Note::create($data);
        session()->flash('success', 'New Feedback posted successfully!');
        return redirect()->route('prospect.index');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Prospect  $prospect
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $prospect = Prospect::findOrFail($id);
        return view('pages.prospects.show')->with(compact('prospect'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Prospect  $prospect
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $prospect = Prospect::with('notes')->findOrFail($id);
        return view('pages.prospects.edit')->with(compact('prospect'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Prospect  $prospect
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $prospect = Prospect::findOrFail($id);
        $validator = Validator::make($data, [
            'organisation' => 'required',
            'contact_email' => 'sometimes',
            'contact_phone_number' => 'sometimes',
            'nature_of_business' => 'sometimes',
            'physical_address' => 'sometimes',
            'feedback' => 'sometimes'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (is_array($data['details'])) {
            $notes = $prospect->notes;
            foreach($data['details'] as $key => $note) {
                $notes[$key]->details = $note;
                $notes[$key]->save();
            };
        }
        $prospect->update($data);
        session()->flash('success', 'Prospect updated successfully!');
        return redirect()->route('prospect.index');
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Prospect  $prospect
    * @return \Illuminate\Http\Response
    */
    public function confirmed(Prospect $prospect)
    {
        Customer::create([
            'name' => $prospect->organisation,
            'email' => $prospect->contact_email,
            'telephone' => $prospect->contact_phone_number,
            'location' => 'NIL',
            'address' => $prospect->physical_address,
            'status' => 0,
            'customer_type_id' => 3
        ]);
        $prospect->delete();
        session()->flash('success', 'Prospect verified as Customer successfully!');
        return redirect()->route('prospect.index');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Prospect  $prospect
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        $prospect = Prospect::where('id', $id)->first();
        if (Gate::denies('prospect.delete', $prospect)) {
            session()->flash('warning', 'You do not have permission to delete this prospect');
            return redirect(route('prospect.index'));
        }
        $prospect->delete();
        session()->flash('success', 'Prospect Deleted');
        return redirect()->route('prospect.index');
    }
}
