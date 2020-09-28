@extends('layouts.app')
@section('styles')
  <link href="{{ asset('vendor/select2/css/select2.css') }}" rel="stylesheet" />
  <link href="{{ asset('css/override.css') }}" rel="stylesheet" />
@endsection
@section('content')
  <div class="dashboard-main-wrapper">
    @include('includes.navbar')
    @include('includes.left_sidebar')
    <!-- ============================================================== -->
    <!-- wrapper  -->
    <!-- ============================================================== -->
    <div class="dashboard-wrapper">
      <div class="container-fluid dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
              <h2 class="pageheader-title">Generate New Invoice</h2>
              <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('app.dashboard') }}" class="breadcrumb-link">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('account.index') }}" class="breadcrumb-link">Invoices</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Generate Invoice</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
          <!-- ============================================================== -->
          <!-- basic form -->
          <!-- ============================================================== -->
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            @include('notifications.alert')
            <div class="card">
              <div class="card-body">
                <form action="{{ route('account.store') }}" method="post" class="form">
                  @csrf
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="dispenser_brand">Invoice No.</label>
                        <input type="text" class="form-control" name="invoice_no" required>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Customer</label>
                          <select class="form-control" id="customer_id" name="customer_id" required>
                            @foreach(presentCustomers() as $customer)
                              <option data-add="{{ $customer->address }}" value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Technician</label>
                          <select class="form-control" id="vendor_id" name="vendor_id" required>
                            @foreach(presentVendors() as $vendor)
                              <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" name="address" rows="4" id="address" placeholder="Please select a customer to populate address" required>{{ old('address') }}</textarea>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" required>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Invoice Date</label>
                          <input type="date" class="form-control" name="invoice_date" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Due Date</label>
                          <input type="date" class="form-control" name="due_date" required>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="table-responsive">
                    <table class="table table-bordered table-form" style="width:100%">
                      <thead>
                        <tr>
                          <th>Service Type</th>
                          <th>Price</th>
                          <th width="15%">Quantity</th>
                          <th width="20%">Total</th>
                          <th width="4%"></th>
                        </tr>
                      </thead>
                      <tbody class="tbody">
                        <tr class="tr_clone">
                          <td>
                            <select class="form-control" name="service_type_id[]" required>
                              <option value="">Choose Option</option>
                              @foreach(presentServiceTypes() as $serviceType)
                                <option value="{{ $serviceType->id }}">{{ $serviceType->name }}</option>
                              @endforeach
                            </select>
                          </td>
                          <td><input type="text" required maxlength="10" name="price[]" value="{{ old('price') }}" class="price form-control"></td>
                          <td><input type="text" required maxlength="5" value="{{ old('quantity') }}" name="quantity[]" class="quantity form-control"></td>
                          <td>
                            <input type="text" size="10" readonly class="subtotal form-control">
                          </td>
                          <td>
                            <button class="btn btn-outline-primary tr_clone_add" type="button"><span class="fas fa-plus"></span></button>
                          </td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td class="table-empty" colspan="2"></td>
                          <td class="table-label">Sub Total</td>
                          <td class="subTotal text-right">0</td>
                        </tr>
                        <tr>
                          <td class="table-empty" colspan="2"></td>
                          <td class="table-label">Discount</td>
                          <td class="table-discount text-right">
                            <input type="hidden" name="sub_total">
                            <input type="text" class="form-control discount text-right discount" name="discount" value="{{ old('discount') }}" placeholder="Enter Discount">
                          </td>
                        </tr>
                        <tr>
                          <td class="table-empty" colspan="2"></td>
                          <td class="table-label">Grand Total</td>
                          <td class="grandTotal text-right">0</td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <hr>
                </div>
                <div class="col-12 mb-4">
                  <p class="text-right">
                    <button type="submit" class="btn btn-space btn-primary">Create</button>
                    <a href="{{ route('account.index') }}" class="btn btn-space btn-secondary">Cancel</a>
                  </p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('includes.footer')
  </div>
</div>
@endsection
@section('scripts')
  <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
  <script type="text/javascript">
  $("#vendor_id").select2({
    placeholder: 'Search for Technician',
    allowClear: true
  });
  $("#customer_id").select2({
    placeholder: 'Search for customer',
    allowClear: true
  });
  var invoiceCode = Math.floor(1000 + Math.random() * 9000);
  var today = new Date().toISOString().slice(0,10);

  function addDays(date, days) {
    const copy = new Date(Number(date))
    copy.setDate(date.getDate() + days)
    return copy
  }

  const date = new Date();
  const newDate = addDays(date, 3);
  const dueDate = newDate.toISOString().slice(0,10);
  </script>
  <script type="text/javascript">
  $('#customer_id').on('change', function() {
    var address = $(this).find(':selected').data('add');
    $("#address").val(address)
  });

  $('input[name=title]').val('Service Invoice-' + invoiceCode)
  $('input[name=invoice_no]').val(invoiceCode)
  $('input[name=invoice_date]').val(today)
  $('input[name=due_date]').val(dueDate)

  $(function() {
    function totalIt() {
      var total = 0;
      $(".subtotal").each(function() {
        var val = this.value;
        total += val == "" || isNaN(val) ? 0 : parseInt(val);
      });
      $(".subTotal").text(total);
      $("input[name=sub_total]").val(total);
      $(".grandTotal").text(total);
      discount();
    }
    function discount() {
      var discount = parseInt($('.discount').val());
      discount = isNaN(discount) ? 0 : parseInt(discount);
      var total = $(".subTotal").html();
      $(".grandTotal").text(total-discount);
    }
    $(function() {
      var $to_clone = $('.tr_clone').first().clone();

      $("table").on('click', 'button.tr_clone_add', function() {
        var $tr = $(this).closest('.tr_clone');
        var $clone = $to_clone.clone();
        $clone.find(':text').val('');
        $tr.after($clone);
        $clone.find('input').val('');
        $('.tbody:first').find('.tr_clone:not(:last) .tr_clone_add')
        .removeClass('tr_clone_add').addClass('tr_clone_remove')
        .removeClass('btn-success').addClass('btn-danger')
        .html('<span class="fas fa-minus"></span>');
      }).on('click', 'button.tr_clone_remove', function(e) {
        $(this).parents('.tr_clone:first').remove();
        e.preventDefault();
        totalIt();
      });

      $(document).on("keyup", ".quantity, .price", function() {
        var $row = $(this).closest("tr"),
        prce = parseInt($row.find('.price').val()),
        qnty = parseInt($row.find('.quantity').val()),
        subTotal = prce * qnty;
        $row.find('.subtotal').val(isNaN(subTotal) ? 0 : subTotal);
        totalIt()
      });

      $(document).on("keyup", ".discount", function() {
        discount();
      })

    });
  });
  </script>
@endsection
