<template>
    <div>

    <div class="row">
        <div class="col-md-1">
          <router-link to="/payroll" class="btn btn-primary">Go Back</router-link>
        </div>
        <div class="col-md-1">
          <router-link to="/pay-salary" class="btn btn-primary">Add</router-link>
        </div> 
    </div>
    <br>
        <input type="text" v-model="searchItem" class="form-control" style="width: 300px;" placeholder="Search Here">
    </br>

    <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Employee List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="payroll in filtersearch" :key="payroll.id">
                        <td>{{ payroll.name }}</td>
                        <td>{{ payroll.salary_month }}</td>
                        <td>{{ payroll.amount }}</td>
                        <td>{{ payroll.salary_date }}</td>
            <td>
                <router-link :to="{name: 'edit-payroll', params:{id:payroll.id}}" class="btn btn-sm btn-primary">Edit</router-link>

               
            </td>
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
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
        this.$router.push({ name: '/' })
    }
    },
    data(){
        return {
            payroll:[],
            searchItem: '',
        }
    },
    computed:{
        filtersearch(){
            return this.payroll.filter(payroll =>{
                return payroll.name.match(this.searchItem)
            })
        }
    },

    methods: {
        viewSalary(){
            let id = this.$route.params.id;
      axios.get('/api/payroll/view/'+id)
      .then(({data})=>this.payroll = data)
        .catch(error => this.errors = error.response.data.errors)
     },
       

    },
    created(){
        this.viewSalary();
    }
  
}
 

</script>


<style type="text/css">
    #em_photo{
        height:40px;
        width:40px;
    }
</style>