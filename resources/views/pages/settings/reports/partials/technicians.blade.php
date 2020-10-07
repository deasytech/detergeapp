<a href="{{ route('report.export-vendors',[$_POST['date_start'],$_POST['date_end'],$_POST['technician']]) }}" class="btn btn-success m-b-10">Export to Excel</a>
<table id="basic-datatable" class="table table-striped table-bordered" style="width:100%">
  <tbody>
    <tr>
      <th>Customer Name</th>
      <th>Technician Name</th>
      <th>Service Date</th>
      <th>Next Service Date</th>
      <th>Service Cost</th>
      <th>Expenses</th>
      <th>Service Type</th>
      <th>Payment Status</th>
    </tr>
    @if (isset($results) && count($results) > 0)
    @foreach ($results as $result)
    <tr>
      <td>{{ $result->customer->name }}</td>
      <td>{{ $result->vendor->name }}</td>
      <td>{{ presentDate($result->actual_service_date) }}</td>
      <td>{{ presentDate($result->periodic_service_date) }}</td>
      <td>{{ presentPrice($result->cost) }}</td>
      <td>{{ presentPrice($result->other_cost) }}</td>
      <td>{{ $result->service->name }}</td>
      <td>{{ $result->payment_status }}</td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="8">
        <p class="text-center font-bold">No results found!</p>
      </td>
    </tr>
    @endif
  </tbody>
</table>