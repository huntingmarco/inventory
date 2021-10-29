<template>
    <div>

    <div class="row">
        <router-link to="/sales" class="btn btn-primary">Back</router-link>

    </div>

        <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Sales Details</h1>
                  </div>
                 

                  <div class="row">
                    <div class="col-lg-6 mb-4">
                    <!-- Simple Tables -->
                    <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Customer</h6>
                        </div>
                        <div class="table-responsive">

                            <ul class="list-group">
                                <li class="list-group-item"><b>Name :</b> {{ sales.name }} </li>
                                <li class="list-group-item"><b>Phone :</b> {{ sales.phone }}</li>
                                <li class="list-group-item"><b>Address :</b> {{ sales.address }}</li>
                                <li class="list-group-item"><b>Date :</b> {{ sales.sale_date }}</li>
                                <li class="list-group-item"><b>Pay Through :</b> {{ sales.payby }}</li>
                            </ul>

                        </div>
                        <div class="card-footer"></div>
                    </div>
                    </div>


                    <div class="col-lg-6 mb-4">
                    <!-- Simple Tables -->
                    <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Sale Summary</h6>
                        </div>
                        <div class="table-responsive">
                        
                            <ul class="list-group">
                                <li class="list-group-item"><b>Sub Total :</b> ${{ sales.sub_total }}  </li>
                                <li class="list-group-item"><b>Vat :</b> ${{ sales.vat }} </li>
                                <li class="list-group-item"><b>Total :</b> ${{ sales.total }} </li>
                                <li class="list-group-item"><b>Pay Amount :</b> ${{ sales.pay }} </li>
                                <li class="list-group-item"><b>Due Amount :</b> ${{ sales.due }} </li>
                            </ul>

                        </div>
                        <div class="card-footer"></div>
                    </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-12 mb-4">
                    <!-- Simple Tables -->
                    <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Sales Details</h6>
                        </div>
                        <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Code</th>
                                    <th>Image</th>
                                    <th>Qty</th>
                                    <th>Unit Price </th>
                                    <th>Total </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="detail in details">
                                    <td>{{ detail.product_name }}</td>
                                    <td>{{ detail.product_code }}</td>
                                    <td><img :src="'/'+detail.image" id="em_photo"></td>
                                    <td>${{ detail.product_price }} </td>
                                    <td>{{ detail.pro_quantity }}</td>
                                    <td>${{ detail.sub_total }} </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                    </div>
                </div>




                  <hr>
                  
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
</template>

<script type="text/javascript">

export default {

created(){
  if (!User.loggedIn()) {
    this.$router.push({ name: '/' })
  }
},

data(){
  return {
   
      errors: {},
      sales:{},
      details:{},  
    }
  },
  methods: {
    getSales(){
      let id = this.$route.params.id;

      axios.get('/api/sales/summary/'+id)
      .then(({data})=>{this.sales = data;})
      .catch()

      axios.get('/api/sales/saledetails/'+id)
      .then(({data})=>(this.details = data))
      .catch()
    }
  },
  created(){
      this.getSales();

  }
}
</script>


<style type="text/css">
</style>