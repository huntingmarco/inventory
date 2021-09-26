<template>
    <div>

    <!-- <div class="row">
        <router-link to="/add-payroll" class="btn btn-primary">Payroll</router-link>

    </div> -->
    <br>
        <input type="text" v-model="searchItem" class="form-control" style="width: 300px;" placeholder="Search Here">
    </br>

    <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Payroll List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Pay ID</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Status</th>
                        <th>Transact Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="payroll in filtersearch" :key="payroll.id">
                        <td>{{ payroll.id }}</td>
                        <td>{{ payroll.payfrom }}</td>
                        <td>{{ payroll.payto }}</td>
                        <td v-if="payroll.status == 'CREATED'"><span class="badge badge-primary">Created</span></td>
                        <td v-else=" "><span class="badge badge-success">Processed</span></td>
                        <td>{{ payroll.transact_date }}</td>
                        <td>
                            <router-link :to="{name: 'view-salary', params:{id:payroll.id}}" class="btn btn-sm btn-primary">View Payroll</router-link>
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
                return payroll.id.match(this.searchItem)
            })
        }
    },

    methods: {
        allPay(){
        axios.get('/api/payroll/')
        .then(({data}) => (this.payroll = data))
        .catch()
        },
       

    },
    created(){
        this.allPay();
    }
  
}
 

</script>


<style type="text/css">
    #em_photo{
        height:40px;
        width:40px;
    }
</style>