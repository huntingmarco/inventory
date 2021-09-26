<template>
    <div>

    <div class="row">
        <router-link to="/store-expense" class="btn btn-primary">Add Expense</router-link>

    </div>
    <br>
    <div class="form-row">
        <div class="col-md-3">
        <label for="exampleFormControlSelect1">Expense</label>
            <input type="text" v-model="searchItem" class="form-control" style="width: 300px;" placeholder="Search Here">
        </div>
        <!-- <div class="col-md-3">
            <label for="exampleFormControlSelect1">Date</label>
            <input type="date" class="form-control" enabled="true" style="width: 300px;" id="exampleInputFirstName" required="" v-model="date">
        </div> -->
        <!-- <div class="col-md-2">
            <a @click="allExpense()" class="btn btn-sm btn-success"><font color="#fffffff">Query</font></a>
        </div> -->
    </div>
    </br>
  

    <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Expense List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Details</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="expense in filtersearch" :key="expense.id">
                        <td>{{ expense.details }}</td>
                        <td>{{ expense.amount }}</td>
                        <td>{{ expense.expense_date }}</td>
            <td>
                <router-link :to="{name: 'edit-expense', params:{id:expense.id}}" class="btn btn-sm btn-primary">Edit</router-link>

                <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger"><font color="#fffffff">Delete</font></a>
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
            expenses:[],
            searchItem: '',
            settings:''
        }
    },
    computed:{
        filtersearch(){
            return this.expenses.filter(expense =>{
                return expense.details.match(this.searchItem)
            })
        }
    },

    methods: {
        allExpense(){
           
        // axios.get('/api/expense/')
        // .then(({data}) => {this.expenses = data;})
        // .catch()
        // },
        this.user = User.name(); 
        var data = { user:this.user};

        alert(data.user)
        axios.post('/api/expense',data)
        .then(({data}) => {this.expenses = data;})
        .catch()
        },
        deleteExpense(id){
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
                axios.delete('/api/expense/'+id)
                .then(()=>{
                    this.expenses  = this.expenses.filter(expense =>{
                        return expense.id != id
                    })
                })
                .catch(()=>{
                    this.$router.push({name: 'expense'})
                })

                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
            })
        },

        getsettings(){
            axios.get('/api/settings/')
            .then(({data}) => (this.settings = data))
            .catch()
        },



    },
    created(){
        this.getsettings();
        this.allExpense();
       
    }
  
}
 

</script>


<style type="text/css">
    #em_photo{
        height:40px;
        width:40px;
    }
</style>