@extends('layouts.app')
@section('styles')

@endsection
@section('content')
  <div class="dashboard-main-wrapper">
    @include('includes.navbar')
    @include('includes.left_sidebar')
    <div class="dashboard-wrapper">
      <div class="container-fluid  dashboard-content">
        <div class="row">
          <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
              <h3 class="mb-2">Welcome back {{ Auth::user()->name }}! </h3>
              <div class="page-breadcrumb">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                  </ol>
                </nav>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- metric -->
          <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="text-muted">Customers</h5>
                <div class="metric-value d-inline-block">
                  <h1 class="mb-1 text-primary">{{ presentCustomers()->count() }} </h1>
                </div>
                <div class="metric-label d-inline-block float-right text-success">
                  <i class="fa fa-fw fa-caret-up"></i><span>5.27%</span>
                </div>
              </div>
              {{-- <div id="sparkline-1"></div> --}}
            </div>
          </div>
          <!-- /. metric -->
          <!-- metric -->
          <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="text-muted">Orders/Requests</h5>
                <div class="metric-value d-inline-block">
                  <h1 class="mb-1 text-primary">{{ presentOrders()->count() }} </h1>
                </div>
                <div class="metric-label d-inline-block float-right text-danger">
                  <i class="fa fa-fw fa-caret-down"></i><span>1.08%</span>
                </div>
              </div>
              {{-- <div id="sparkline-2"></div> --}}
            </div>
          </div>
          <!-- /. metric -->
          <!-- metric -->
          <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="text-muted">Revenue</h5>
                <div class="metric-value d-inline-block">
                  <h1 class="mb-1 text-primary">{{ presentPrice($sales) }}</h1>
                </div>
                <div class="metric-label d-inline-block float-right text-success">
                  <i class="fa fa-fw fa-caret-up"></i><span>2.10%</span>
                </div>
              </div>
              {{-- <div id="sparkline-3"></div> --}}
            </div>
          </div>
          <!-- /. metric -->
          <!-- metric -->
          <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="text-muted">Revenue Growth</h5>
                <div class="metric-value d-inline-block">
                  <h1 class="mb-1 text-primary">+28.45% </h1>
                </div>
                <div class="metric-label d-inline-block float-right text-success">
                  <i class="fa fa-fw fa-caret-up"></i><span>4.87%</span>
                </div>
              </div>
              {{-- <div id="sparkline-4"></div> --}}
            </div>
          </div>
          <!-- /. metric -->
        </div>
        <div class="row">
          <div class="col-xl-6 col-lg-12 col-md-6 col-sm-12 col-12">
            <div class="card">
              <h5 class="card-header">Monthly Due Services <strong>Total: ({{ $monthly_due_date->total() }})</strong></h5>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table">
                    <thead class="bg-light">
                      <tr class="border-0">
                        <th class="border-0">#</th>
                        <th class="border-0">Customer Name</th>
                        <th class="border-0">Telephone</th>
                        <th class="border-0">Service Date</th>
                        <th class="border-0 bg-danger text-light">Next Service Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($monthly_due_date->count() > 0)
                        @foreach($monthly_due_date as $order)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->customer->name }} </td>
                            <td>{{ $order->customer->telephone }} </td>
                            <td>{{ presentDate($order->actual_service_date) }}</td>
                            <td class="bg-danger-light">{{ presentDate($order->periodic_service_date) }}</td>
                          </tr>
                        @endforeach
                        @else
                        <tr>
                          <td colspan="5">
                            <p class="text-center font-bold">There are no due services this month!</p>
                          </td>
                        </tr>
                      @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        @if ($monthly_due_date->count() > 0)
                          <td colspan="4">{{ $monthly_due_date->links() }}</td>
                        @else
                          <td colspan="4">&nbsp;</td>
                        @endif
                        <td colspan="2"><a href="{{ route('order.index') }}" class="btn btn-outline-light float-right">View Details</a></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-6 col-lg-12 col-md-6 col-sm-12 col-12">
            <div class="card">
              <h5 class="card-header">Weekly Due Services <strong>Total: ({{ $weekly_due_date->total() }})</strong></h5>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table">
                    <thead class="bg-light">
                      <tr class="border-0">
                        <th class="border-0">#</th>
                        <th class="border-0">Customer Name</th>
                        <th class="border-0">Telephone</th>
                        <th class="border-0">Service Date</th>
                        <th class="border-0 bg-danger text-light">Next Service Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($weekly_due_date->count() > 0)
                        @foreach($weekly_due_date as $order)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->customer->name }} </td>
                            <td>{{ $order->customer->telephone }} </td>
                            <td>{{ presentDate($order->actual_service_date) }}</td>
                            <td class="bg-danger-light">{{ presentDate($order->periodic_service_date) }}</td>
                          </tr>
                        @endforeach
                      @else
                          <tr>
                            <td colspan="5">
                              <p class="text-center font-bold">There are no due services this week!</p>
                            </td>
                          </tr>
                      @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        @if ($weekly_due_date->count() > 0)
                          <td colspan="4">{{ $weekly_due_date->links() }}</td>
                        @else
                          <td colspan="4">&nbsp;</td>
                        @endif
                        <td colspan="2"><a href="{{ route('order.index') }}" class="btn btn-outline-light float-right">View Details</a></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-8 col-lg-12 col-md-8 col-sm-12 col-12">
            <div class="card">
              <h5 class="card-header">Top Paying Customer</h5>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table">
                    <thead class="bg-light">
                      <tr class="border-0">
                        <th class="border-0">#</th>
                        <th class="border-0">Invoice Date</th>
                        <th class="border-0">Customer Name</th>
                        <th class="border-0">Telephone</th>
                        <th class="border-0">Technician</th>
                        <th class="border-0">Payment Status</th>
                        <th class="border-0">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($top_customers->count() > 0)
                        @foreach($top_customers as $cust)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cust->invoice_date }}</td>
                            <td>{{ $cust->customer->name }} </td>
                            <td>{{ $cust->customer->telephone }} </td>
                            <td>{{ $cust->technician->name }}</td>
                            <td>{{ $cust->payment_status }}</td>
                            <td>{{ $cust->grand_total }} </td>
                          </tr>
                        @endforeach
                      @endif
                      <tr>
                        <td colspan="7"><a href="{{ route('account.index') }}" class="btn btn-outline-light float-right">View Details</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-lg-12 col-md-4 col-sm-12 col-12">
            <div class="card">
              <h5 class="card-header">Total Sale</h5>
              <div class="card-body">
                <canvas id="total-sale" width="220" height="155"></canvas>
                <div class="chart-widget-list">
                  @foreach (presentServiceTypes() as $service)
                    <p>
                      <span class="fa-xs text-{{ $service->id == 1 ? 'primary' : 'secondary' }} mr-1 legend-title"><i class="fa fa-fw fa-square-full"></i></span>
                      <span class="legend-text">{{ $service->name }}</span>
                      <span class="float-right">{{ presentPrice(totalSalesByService($service->id)->sum('total')) }}</span>
                    </p>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-7 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
              <h5 class="card-header">Latest Orders/Requests</h5>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table">
                    <thead class="bg-light">
                      <tr class="border-0">
                        <th class="border-0">#</th>
                        <th class="border-0">Customer Name</th>
                        <th class="border-0">Telephone</th>
                        <th class="border-0">Service Type</th>
                        <th class="border-0">Service Location</th>
                        <th class="border-0">Service Date</th>
                        <th class="border-0">Quantity</th>
                      </tr>
                    </thead>
                    <tbody>
                      @if($latest_orders->count() > 0)
                        @foreach($latest_orders as $order)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $order->customer->name }} </td>
                            <td>{{ $order->customer->telephone }} </td>
                            <td>{{ $order->service->name }}</td>
                            <td>{{ $order->service_location }}</td>
                            <td>{{ presentDate($order->actual_service_date) }}</td>
                            <td>{{ $order->dispenser_quantity }} </td>
                          </tr>
                        @endforeach
                      @endif
                      <tr>
                        <td colspan="7"><a href="{{ route('order.index') }}" class="btn btn-outline-light float-right">View Details</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
              <h5 class="card-header">Revenue by Location</h5>
              <div class="card-body">
                <div id="locationmap" style="width:100%; height:200px"></div>
              </div>
              <div class="card-body border-top">
                <div class="row">
                  @foreach (state() as $state)
                    <div class="col-xl-6">
                      <div class="sell-ratio">
                        <h5 class="mb-1 mt-0 font-weight-normal">{{ $state->name }}</h5>
                        <div class="progress-w-percent">
                          <span class="progress-value">{{ isset(totalRevenueByLocation($state->name)->total_sales) ? presentPrice(totalRevenueByLocation($state->name)->total_sales) : presentPrice(0) }}</span>
                          <div class="progress progress-sm">
                            <div class="progress-bar" role="progressbar" style="width: 72%;" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
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
  <script src="{{ asset('vendor/charts/charts-bundle/Chart.bundle.js') }}"></script>
  <script src="{{ asset('vendor/charts/charts-bundle/chartjs.js') }}"></script>
  <script src="{{ asset('libs/js/dashboard-sales.js') }}"></script>
@endsection
