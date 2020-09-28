<?php

namespace App\Http\Controllers;

use App\Prospect;
use Illuminate\Http\Request;
use Validator;
use Gate;
use yajra\Datatables\Datatables;
use App\Note;
use App\Customer;

class ProspectController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('pages.prospects.index');
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

    public function ajaxLoad()
    {
        $prospect = Prospect::with('notes')->orderBy('created_at','desc');
        return Datatables::of($prospect)
        ->addColumn('action', function ($prospect) {
            return '<a href="#" class="btn btn-primary btn-xs" data-id="'.$prospect->id.'" data-toggle="modal" data-target="#feedback" title="Update Feedback"><i class="mdi mdi-comment-alert"></i></a>
            <a href="'.route('prospect.show',$prospect->id).'" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="top" title="View"><i class="mdi mdi-eye"></i></a>
            <a href="'.route('prospect.edit',$prospect->id).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
            <form method="POST" action="'.route('prospect.destroy', $prospect->id).'" style="display: inline-block;">
            <input type="hidden" name="_token" value="'.csrf_token().'">
            <input type="hidden" name="_method" value="DELETE">
            <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
            <i class="mdi mdi-delete"></i>
            </a>
            </form>
            <a href="'.route('prospect.confirmed',$prospect).'" class="btn btn-success btn-xs" data-toggle="tooltip" title="Verified Customer"><i class="mdi mdi-account-check"></i></a>';
        })
        ->rawColumns(['action'])
        ->addIndexColumn()
        ->make(true);
    }
}
