<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceService;
use App\{Customer, Vendor};
use Illuminate\Http\Request;
use Validator;
use yajra\Datatables\Datatables;

class InvoiceController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    return view('pages.accounts.index');
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('pages.accounts.create');
  }

  public function overdue()
  {
    return view('pages.accounts.overdue');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    $request['discount'] = $request->discount == "" ? 0 : $request->discount;
    $request['invoice_no'] = str_replace(' ', '', $request->invoice_no);
    $messageStatus = messagingStatus();
    $this->validate($request, [
      'invoice_no' => 'required|alpha_dash|unique:invoices',
      'customer_id' => 'required',
      'vendor_id' => 'required',
      'address' => 'required|max:255',
      'title' => 'required|max:255',
      'invoice_date' => 'required|date_format:Y-m-d',
      'due_date' => 'required|date_format:Y-m-d',
      'discount' => 'required|numeric|min:0',
    ]);
    $customer = Customer::findOrFail($request->customer_id);
    $vendor = Vendor::findOrFail($request->vendor_id);

    if(count($request->service_type_id) == 0) {
      session()->flash('warning', 'One or more Service is required.');
      return redirect()->back()->withInput();
    }

    $data = $request->all();
    $data['sub_total'] = (float)$request->sub_total;
    $data['discount'] = (float)$request->discount;
    $data['grand_total'] = $request->sub_total - $request->discount;

    $invoice = Invoice::create($data);

    for ($i=0; $i < count($request->service_type_id); $i++) {
      $invoiceServ = new InvoiceService();
      $invoiceServ->invoice_id = $invoice->id;
      $invoiceServ->service_type_id = $request->service_type_id[$i];
      $invoiceServ->quantity = $request->quantity[$i];
      $invoiceServ->price = $request->price[$i];
      $invoiceServ->total = $request->quantity[$i] * $request->price[$i];
      $invoiceServ->save();
    }

    if ($messageStatus->value == 1) {
      if ($request->customer_id) {
        $total = presentPrice($data['grand_total']);
        $date = presentDate($request->invoice_date);
        $message = "Your service from Deterge is scheduled for {$date} with invoice #{$request->invoice_no}, {$total} to be paid to GTB: Deterge Nigeria Limited - 0115931331.";
        sendMessage($message, $customer->telephone);
      }
      if ($request->vendor_id) {
        $total = presentPrice($data['grand_total']);
        $date = presentDate($request->invoice_date);
        $message = "You've got a service from Deterge, scheduled for {$date} with invoice #{$request->invoice_no}, {$total} Customer mobile: $customer->telephone.";
        sendMessage($message, $vendor->telephone);
      }
    }

    session()->flash('success', 'Invoice generated successfully!');
    return redirect()->route('account.index');
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Invoice  $invoice
  * @return \Illuminate\Http\Response
  */
  public function show($id)
  {
    $invoice = Invoice::findOrFail($id);
    return view('pages.accounts.show', compact('invoice'));
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Invoice  $invoice
  * @return \Illuminate\Http\Response
  */
  public function edit($id)
  {
    $invoice = Invoice::with('services')->findOrFail($id);
    return view('pages.accounts.edit', compact('invoice'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Invoice  $invoice
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id)
  {
    $request['service_type_id'] = array_filter($request->service_type_id);
    $request['price'] = array_filter($request->price);
    $request['quantity'] = array_filter($request->quantity);
    $this->validate($request, [
      'invoice_no' => 'required|alpha_dash|unique:invoices,invoice_no,'.$id.',id',
      'customer_id' => 'required',
      'vendor_id' => 'required',
      'address' => 'required|max:255',
      'title' => 'required|max:255',
      'invoice_date' => 'required|date_format:Y-m-d',
      'due_date' => 'required|date_format:Y-m-d',
      'discount' => 'required|numeric|min:0'
    ]);

    if(count($request->service_type_id) == 0) {
      session()->flash('warning', 'One or more Service is required.');
      return redirect()->back()->withInput();
    }

    $invoice = Invoice::findOrFail($id);

    $data = $request->all();
    $data['sub_total'] = (float)$request->sub_total;
    $data['discount'] = (float)$request->discount;
    $data['grand_total'] = $request->sub_total - $request->discount;

    $invoice->update($data);

    InvoiceService::where('invoice_id', $invoice->id)->delete();

    for ($i=0; $i < count($request->service_type_id); $i++) {
      $invoiceServ = new InvoiceService();
      $invoiceServ->invoice_id = $invoice->id;
      $invoiceServ->service_type_id = $request->service_type_id[$i];
      $invoiceServ->quantity = $request->quantity[$i];
      $invoiceServ->price = $request->price[$i];
      $invoiceServ->total = $request->quantity[$i] * $request->price[$i];
      $invoiceServ->save();
    }

    session()->flash('success', 'Invoice updated successfully!');
    return redirect()->route('account.index');
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Invoice  $invoice
  * @return \Illuminate\Http\Response
  */
  public function destroy($id)
  {
    $invoice = Invoice::findOrFail($id);

    InvoiceService::where('invoice_id', $invoice->id)->delete();

    $invoice->delete();

    return redirect()->route('account.index');
  }

  public function ajaxLoad()
  {
    $invoices = Invoice::with(['services','customer','technician'])->orderBy('created_at', 'desc');
    return Datatables::of($invoices)
    ->editColumn('grand_total', function($invoice) {
      return presentPrice($invoice->grand_total);
    })
    ->editColumn('customer_id', function($invoice) {
      return $invoice->customer->name;
    })
    ->editColumn('vendor_id', function($invoice) {
      return $invoice->technician->name;
    })
    ->editColumn('payment_status', function($invoice) {
      if ($invoice->payment_status == 'transfer') {
        $transfer = 'Bank ' . $invoice->payment_status;
        return title_case($transfer);
      }
      if ($invoice->payment_status == 'online') {
        $online = $invoice->payment_status . ' Payment';
        return title_case($online);
      }
      if ($invoice->payment_status == 'paid') {
        $paid = $invoice->payment_status . ' Cash';
        return title_case($paid);
      }
      return title_case($invoice->payment_status);
    })
    ->editColumn('created_at', function($invoice) {
      return $invoice->created_at->diffForHumans();
    })
    ->addColumn('action', function ($invoice) {
      return '<a href="'.route('account.show',$invoice->id).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View"><i class="mdi mdi-eye"></i></a>
      <a href="'.route('account.edit',$invoice).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
      <a href="#" data-id="'.$invoice->id.'" data-status="'.$invoice->payment_status.'" class="btn btn-dark btn-xs" data-toggle="modal" data-target="#pay" title="Pay"><i class="mdi mdi-cash"></i></a>
      <form method="POST" action="'.route('account.destroy', $invoice).'" style="display: inline-block;">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="_method" value="DELETE">
      <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
      <i class="mdi mdi-delete"></i>
      </a>
      </form>';
    })
    ->rawColumns(['action'])
    ->addIndexColumn()
    ->make(true);
  }

  public function ajaxLoadOverdue()
  {
    $today = date('Y-m-d');
    $invoices = Invoice::with(['services','customer','technician'])->where([['due_date','<',$today],['payment_status','=','pending']])->orderBy('created_at', 'desc');
    return Datatables::of($invoices)
    ->editColumn('customer_id', function($invoice) {
      return $invoice->customer->name;
    })
    ->editColumn('vendor_id', function($invoice) {
      return $invoice->technician->name;
    })
    ->editColumn('grand_total', function($invoice) {
      return presentPrice($invoice->grand_total);
    })
    ->editColumn('payment_status', function($invoice) {
      if ($invoice->payment_status == 'transfer') {
        $transfer = 'Bank ' . $invoice->payment_status;
        return title_case($transfer);
      }
      if ($invoice->payment_status == 'online') {
        $online = $invoice->payment_status . ' Payment';
        return title_case($online);
      }
      if ($invoice->payment_status == 'paid') {
        $paid = $invoice->payment_status . ' Cash';
        return title_case($paid);
      }
      return title_case($invoice->payment_status);
    })
    ->editColumn('created_at', function($invoice) {
      return $invoice->created_at->diffForHumans();
    })
    ->addColumn('action', function ($invoice) {
      return '<a href="'.route('account.show',$invoice->id).'" class="btn btn-warning btn-xs" data-toggle="tooltip" title="View"><i class="mdi mdi-eye"></i></a>
      <a href="'.route('account.edit',$invoice).'" class="btn btn-info btn-xs" data-toggle="tooltip" title="Edit"><i class="mdi mdi-table-edit"></i></a>
      <a href="#" data-id="'.$invoice->id.'" data-status="'.$invoice->payment_status.'" class="btn btn-dark btn-xs" data-toggle="modal" data-target="#pay" title="Pay"><i class="mdi mdi-cash"></i></a>
      <form method="POST" action="'.route('account.destroy', $invoice).'" style="display: inline-block;">
      <input type="hidden" name="_token" value="'.csrf_token().'">
      <input type="hidden" name="_method" value="DELETE">
      <a href="#" class="btn btn-danger btn-xs" onclick="var c = confirm(\'Are you sure you want to delete this record?\'); if(c == false) return false; else this.parentNode.submit();" class="text-decoration-none p2 display-block on-hover-no-decoration" data-toggle="tooltip" title="Delete" data-toggle="tooltip" title="Delete">
      <i class="mdi mdi-delete"></i>
      </a>
      </form>';
    })
    ->rawColumns(['action'])
    ->addIndexColumn()
    ->make(true);
  }

  public function updateStatus(Request $request)
  {
    $data = $request->all();
    $validator = Validator::make($data, [
      'status' => 'required',
    ]);
    if($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }
    $pay = Invoice::findOrFail($data['id']);
    $pay->payment_status = $data['status'];
    $pay->save();
    session()->flash('success', 'Payment status updated successfully!');
    return redirect()->route('account.index');
  }
}
