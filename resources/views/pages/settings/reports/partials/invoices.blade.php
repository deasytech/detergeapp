<a href="{{ route('report.export-invoices',[$_POST['payment_status'],$_POST['date_start'],$_POST['date_end']]) }}" class="btn btn-success m-b-10">Export to Excel</a>
<table id="basic-datatable" class="table table-striped table-bordered" style="width:100%">
  <tbody>
    <tr>
      <th>Invoice Date</th>
      <th>Invoice Due Date</th>
      <th>Customer Name</th>
      <th>Technician Name</th>
      <th>Service Cost</th>
    </tr>
    @if (count($results) > 0)
    @foreach ($results as $result)
    <tr>
      <td>{{ presentDate($result->invoice_date) }}</td>
      <td>{{ presentDate($result->due_date) }}</td>
      <td>{{ $result->customer->name }}</td>
      <td>{{ $result->technician->name }}</td>
      <td>{{ presentPrice($result->grand_total) }}</td>
    </tr>
    @endforeach
    @else
    <tr>
      <td colspan="5">
        <p class="text-center font-bold">No results found!</p>
      </td>
    </tr>
    @endif
  </tbody>
</table>