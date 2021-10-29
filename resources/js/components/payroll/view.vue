<template>
    <div>

    <div class="row">
        <div class="col-md-1">
          <router-link to="/payroll" class="btn btn-primary">Back</router-link>
        </div>
        <div class="col-md-2">
          <!-- <a @click="transactPayroll()" class="btn btn-sm btn-success"><font color="#fffffff">Transact Payroll</font></a> -->
          <a @click="transactPayroll()" v-if="paystatus == 'CREATED'" enabled class="btn btn-sm btn-success"><font color="#fffffff">Transact Payroll</font></a>
          <a v-else="paystatus == 'PROCESSED'" class="btn-sm btn-success"><font color="#fffffff">Processed</font></a>
         
        </div> 
        <div class="col-md-2">
          <a @click="printPayroll()" class="btn btn-sm btn-warning"><font color="#fffffff">Print</font></a>
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
                  <h6 class="m-0 font-weight-bold text-primary">Pay:{{pay_id}}</h6>
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
                <router-link :to="{name: 'edit-payroll', params:{id:payroll.id, pay_id:payroll.pay_id}}" class="btn btn-sm btn-primary" >Edit</router-link>

               
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
    created(){
      Reload.$on('AfterTransact',()=>{
          this.getPayStatus();
        });
    },
    data(){
        return {
            payroll:[],
            searchItem: '',
            pay_id:'',
            paystatus:''
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
        this.pay_id = id;
          axios.get('/api/payroll/view/'+id)
          .then(({data})=>this.payroll = data)
            .catch(error => this.errors = error.response.data.errors)
        },
        transactPayroll(){
          
          //update pay transact status and transact date
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, process it!'
            }).then((result) => {
            if (result.isConfirmed) {
              var data = { user:User.name()}
              axios.post('/api/payroll/transact/'+this.pay_id,data)
              .then(res => {
                    //Notification.success()
                    Reload.$emit('AfterTransact');
                  })
              .catch(error => this.errors = error.response.data.errors)

         
                Swal.fire(
                'Processed!',
                'Your pay has been processed.',
                'success'
                )
            }
            })
          
        },
        printPayroll(){
          alert('Print');
        }, 
        getPayStatus(){
        let id = this.$route.params.id;
        this.pay_id = id;
          axios.get('/api/payroll/status/'+id)
          .then(({data})=>this.paystatus = data)
            .catch(error => this.errors = error.response.data.errors)
        }
       

    },
    created(){
        this.viewSalary();
        this.getPayStatus();
    }
  
}
 

</script>


<style type="text/css">
    #em_photo{
        height:40px;
        width:40px;
    }
</style>