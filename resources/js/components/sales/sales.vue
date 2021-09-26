   

<template>
  
  <div>

 
<br>
   <input type="text" v-model="searchTerm" class="form-control" style="width: 300px;" placeholder="Search Here">


<br>

   <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Today Sales</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Total Amount </th>
                        <th>Pay</th>
                        <th>Due</th>
                        <th>PayBy</th>
                         <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="sale in filtersearch" :key="sale.id">
                        <td> {{ sale.name }} </td>
                        <td> ${{ sale.total }}  </td>
                        <td> ${{ sale.pay }}  </td>
                        <td> ${{ sale.due }}   </td>
                        <td> {{ sale.payby }} </td>
                       
                        <td>
   <router-link :to="{name: 'view-sales', params:{id:sale.id}}" class="btn btn-sm btn-primary">View</router-link>

 
                        </td>
                      </tr>
                      <tr class="bg-dark text-white">
                          <td>Totals:</td>
                          <td>${{totalAmt}}</td>
                          <td>${{totalPay}}</td>
                          <td>${{totalDue}}</td>
                          <td></td>
                          <td></td>
                      </tr>
                    
                    </tbody>
                  </table>
                </div>
                <div class="card-footer">
                </div>
              </div>
            </div>
          </div>
          <!--Row-->


   
  </div>


</template>



<script type="text/javascript">
  
  export default {
    created(){
      if (!User.loggedIn()) {
        this.$router.push({name: '/'})
      }
    },
    data(){
      return{
        sales:[],
        searchTerm:''
      }
    },
    computed:{
      filtersearch(){
      return this.sales.filter(sale => {
         return sale.name.match(this.searchTerm)
      }) 
      },
      totalAmt(){
          let total = 0;  
          for(let p of this.sales) 
          {    total += parseFloat(p.total);  }  
          return total;
      },
      totalPay(){
          let total = 0;  
          for(let p of this.sales) 
          {    total += parseFloat(p.pay);  }  
          return total;
      },
      totalDue(){
          let total = 0;  
          for(let p of this.sales) 
          {    total += parseFloat(p.due);  }  
          return total;
      }
    },
 
  methods:{
    allSale(){
      axios.get('/api/sales/')
      .then(({data}) => (this.sales = data))
      .catch()
    },
   

  },
  created(){
    this.allSale();
  } 
  

  } 
</script>


<style type="text/css">
  #em_photo{
    height: 40px;
    width: 40px;
  }
</style>