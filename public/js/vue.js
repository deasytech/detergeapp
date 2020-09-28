Vue.config.productionTip = false;
Vue.config.devtools = false;
var app = new Vue({
  el: '#invoice',
  mounted:function() {
    $("#vendor_id").select2({
      placeholder: 'Search for Technician',
      allowClear: true
    });
    $("#customer_id").select2({
      placeholder: 'Search for customer',
      allowClear: true
    });
  },
  renderError (h, err) {
    return h('pre', { style: { color: 'red' }}, err.stack)
  },
  data: {
    isProcessing: false,
    form: {},
    errors: {}
  },
  created: function() {
    Vue.set(this.$data, 'form', _form);
  },
  methods: {
    addLine: function() {
      this.form.services.push({service_type_id: '', price: 0, quantity: 1});
    },
    removeItem: function(service) {
      var index = this.form.services.indexOf(service)
      this.form.services.splice(index, 1)
    },
    create: function() {
      this.isProcessing = true;
      this.$http.post('/account', this.form)
      .then(function(response) {
        if(response.data.created) {
          window.location = '/account/' + response.data.id;
        } else {
          this.isProcessing = false;
        }
      })
      .catch(function(response) {
        this.isProcessing = false;
        Vue.set(this.$data, 'errors', response.data.errors);
      })
    },
    update: function() {
      this.isProcessing = true;
      this.$http.put('/account/' + this.form.id, this.form)
      .then(function(response) {
        if(response.data.updated) {
          window.location = '/account/' + response.data.id;
        } else {
          this.isProcessing = false;
        }
      })
      .catch(function(response) {
        this.isProcessing = false;
        Vue.set(this.$data, 'errors', response.data);
      })
    }
  },
  computed: {
    subTotal: function() {
      return this.form.services.reduce(function(carry, service) {
        return carry + (parseFloat(service.quantity) * parseFloat(service.price));
      }, 0);
    },
    grandTotal: function() {
      return this.subTotal - parseFloat(this.form.discount);
    }
  }
})
