<template>
    <div>

    <div class="row">
        <router-link to="/store-pay" class="btn btn-primary">Add Pay</router-link>

    </div>
    <br>
        <input type="text" v-model="searchItem" class="form-control" style="width: 300px;" placeholder="Search Payfrom">
    </br>

    <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Pay List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Pay From</th>
                        <th>Pay to</th>
                        <th>Details</th></th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="pay in filtersearch" :key="pay.id">
                        <td>{{ pay.payfrom }}</td>
                        <td>{{ pay.payto }}</td>
                        <td>{{ pay.details }}</td>
            <td>
                <router-link :to="{name: 'edit-pay', params:{id:pay.id}}" class="btn btn-sm btn-primary">Edit</router-link>

                <a @click="deletePay(pay.id)" class="btn btn-sm btn-danger"><font color="#fffffff">Delete</font></a>
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
            pays:[],
            searchItem: '',
        }
    },
    computed:{
        filtersearch(){
            return this.pays.filter(pay =>{
                return pay.payfrom.match(this.searchItem)
            })
            //return this.pays
        }
    },

    methods: {
        allPay(){
        axios.get('/api/pay/')
        .then(({data}) => (this.pays = data))
        .catch()
        },
        deletePay(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('/api/pay/'+id)
                .then(()=>{
                    this.pays  = this.pays.filter(pay =>{
                        return pay.id != id
                    })
                })
                .catch(()=>{
                    this.$router.push({name: 'pay'})
                })

                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
            })
        }


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