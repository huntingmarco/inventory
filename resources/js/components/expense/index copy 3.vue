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
  


        <!-- tabs -->

          <div class="col-xl-7 col-lg-7">
              <div class="card mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Expense List</h6>
                    </div>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">My entries</a>
                        </li>
                        <li class="nav-item" v-for="expenseuser in expenseusers" :key="expenseuser.user">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" @click="otherusers(expenseuser.user)" >{{ expenseuser.user }}</a>
                        </li>
                    </ul>

                    <!-- begin tab home -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                
                        <div class="card-body">
                        <!--<input type="text" v-model="searchItem" class="form-control" style="width: 560px;" placeholder="Search Product">-->
                            <div class="row"> 
                   
                           
                            
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

                        </div> 
                    </div> 

                     <!-- end tab home -->

                        <!-- begin other users -->  
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                         
                            <div class="card-body">
                            <!--<input type="text" v-model="searchItem" class="form-control" style="width: 560px;" placeholder="Search Product">-->
                            <div class="row"> 
                                <!-- <input type="text" v-model="getsearchItem" class="form-control" style="width: 560px;" placeholder="Search Product"> -->
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
                                        <tr v-for="expense2 in getfiltersearch" :key="expense2.id">
                                            <td>{{ expense2.details }}</td>
                                            <td>{{ expense2.amount }}</td>
                                            <td>{{ expense2.expense_date }}</td>
                                            <td>
                                                <router-link :to="{name: 'edit-expense', params:{id:expense2.id}}" class="btn btn-sm btn-primary">Edit</router-link>

                                                <a @click="deleteExpense(expense2.id)" class="btn btn-sm btn-danger"><font color="#fffffff">Delete</font></a>
                                            </td>
                                        </tr>
                                        
                                        </tbody>
                                </table>
                            </div>
                        </div> 
                    </div> 
                  <!-- end other users -->
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
            expenses:[],
            getexpenses:[],
            searchItem: '',
            getsearchItem: '',
            settings:'',
            expenseusers:'',
        }
    },
    computed:{
        filtersearch(){
            return this.expenses.filter(expense =>{
                return expense.details.match(this.searchItem)
            })
        },
        getfiltersearch(){
            return this.getexpenses.filter(getexpense =>{
                return getexpense.details.match(this.getsearchItem)
            })
        },
    },

    methods: {
        allExpense(){
           
        // axios.get('/api/expense/')
        // .then(({data}) => {this.expenses = data;})
        // .catch()
        // },
     
        var data = { user:this.user};

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
        allUsers(){
            axios.get('/api/expenseusers/'+this.user)
            .then(({data}) => (this.expenseusers = data))
            .catch()
        },
        otherusers(id){
            axios.get('/api/expenseotheruser/'+id)
            .then(({data}) => (this.getexpenses = data))
            .catch()
        },


    },
    created(){
        this.user = User.name(); 
        this.getsettings();
        this.allExpense();
        this.allUsers();
       
    }
  
}
 

</script>


<style type="text/css">
    #em_photo{
        height:40px;
        width:40px;
    }
</style>