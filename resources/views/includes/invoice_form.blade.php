<div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="dispenser_brand">Invoice No.</label>
      <input type="text" class="form-control" v-model="form.invoice_no" :class="{'is-invalid': errors.invoice_no}">
      <p v-if="errors.invoice_no" class="invalid-feedback">@{{ errors.invoice_no[0] }}</p>
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label>Customer</label>
        <select class="form-control" id="customer_id" v-model="form.customer_id" :class="{'is-invalid': errors.customer_id}">
          @foreach(presentCustomers() as $customer)
            <option data-add="{{ $customer->address }}" value="{{ $customer->id }}">{{ $customer->name }}</option>
          @endforeach
        </select>
        <p v-if="errors.customer_id" class="invalid-feedback">@{{ errors.customer_id[0] }}</p>
      </div>
      <div class="form-group col-md-6">
        <label>Technician</label>
        <select class="form-control" id="vendor_id" v-model="form.vendor_id" :class="{'is-invalid': errors.vendor_id}">
          @foreach(presentVendors() as $vendor)
            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
          @endforeach
        </select>
        <p v-if="errors.vendor_id" class="invalid-feedback">@{{ errors.vendor_id[0] }}</p>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label>Address</label>
      <textarea class="form-control" v-model="form.address" rows="4" id="address" placeholder="Please select a customer to populate address" :class="{'is-invalid': errors.address}"></textarea>
      <p v-if="errors.address" class="invalid-feedback">@{{ errors.address[0] }}</p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label>Title</label>
      <input type="text" class="form-control" v-model="form.title" :class="{'is-invalid': errors.title}">
      <p v-if="errors.title" class="invalid-feedback">@{{ errors.title[0] }}</p>
    </div>
    <div class="row">
      <div class="form-group col-md-6">
        <label>Invoice Date</label>
        <input type="date" class="form-control" v-model="form.invoice_date" :class="{'is-invalid': errors.invoice_date}">
        <p v-if="errors.invoice_date" class="invalid-feedback">@{{ errors.invoice_date[0] }}</p>
      </div>
      <div class="form-group col-md-6">
        <label>Due Date</label>
        <input type="date" class="form-control" v-model="form.due_date" :class="{'is-invalid': errors.due_date}">
        <p v-if="errors.due_date" class="invalid-feedback">@{{ errors.due_date[0] }}</p>
      </div>
    </div>
  </div>
</div>
<hr>
<div v-if="errors.services_empty">
  <p class="alert alert-danger">@{{ errors.services_empty[0] }}</p>
  <hr>
</div>

<div class="table-responsive">
  <table class="table table-bordered table-form" style="width:100%">
    <thead>
      <tr>
        <th>Service Type</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(service, index) in form.services" :key="index">
        <td class="table-service_type_id" :class="{'table-error': errors['services.' + index + '.service_type_id']}">
          <select class="table-control" v-model="service.service_type_id">
            @foreach(presentServiceTypes() as $serviceType)
              <option value="{{ $serviceType->id }}">{{ $serviceType->name }}</option>
            @endforeach
          </select>
        </td>
        <td class="table-price" :class="{'table-error': errors['services.' + index + '.price']}">
          <input type="text" v-model="service.price" class="table-control">
        </td>
        <td class="table-quantity" :class="{'table-error': errors['services.' + index + '.quantity']}">
          <input type="text" v-model="service.quantity" class="table-control">
        </td>
        <td class="table-total text-right">
          <span class="table-text pr-3">@{{ service.quantity * service.price }}</span>
        </td>
        <td class="table-remove">
          <span @click="removeItem(service)" class="table-remove-btn">&times;</span>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td class="table-empty" colspan="2">
          <span @click="addLine" class="btn btn-link pt-0 pb-0">Add Line</span>
        </td>
        <td class="table-label">Sub Total</td>
        <td class="table-amount text-right">@{{ subTotal }}</td>
      </tr>
      <tr>
        <td class="table-empty" colspan="2"></td>
        <td class="table-label">Discount</td>
        <td class="table-discount text-right" :class="{'table-error': errors.discount}">
          <input type="text" v-model="form.discount" class="table-discount_input text-right">
        </td>
      </tr>
      <tr>
        <td class="table-empty" colspan="2"></td>
        <td class="table-label">Grand Total</td>
        <td class="table-amount text-right">@{{ grandTotal }}</td>
      </tr>
    </tfoot>
  </table>
</div>
