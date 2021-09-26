<template>
    <div>

        <div class="row">
            <router-link to="/store-expense" class="btn btn-primary">Add Journal</router-link>

        </div>
      
        </br>
  
      
          <div class="col-xl-7 col-lg-7">
              <div class="card mb-6">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Journals</h6>
                    </div>

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">My entries</a>
                        </li>
                        <li class="nav-item" v-for="journaluser in journalusers" :key="journaluser.user">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" @click="otherusers(journaluser.user)" >{{ expenseuser.user }}</a>
                        </li>
                    </ul>

                    <!-- begin tab home -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                
                        <div class="card-body">
                            
                            <div class="row"> 
                                <input type="text" v-model="searchItem" class="form-control" style="width: 560px;" placeholder="Search Entry">
                           
                                <div class="wrapper" style="width: 700px; height: 400px;overflow: scroll;">
                                    <table id="tablehome" class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>Details</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="journal in filtersearch" :key="journal.id">
                                            <td>{{ journal.details }}</td>
                                            <td>{{ journal.amount }}</td>
                                            <td>{{ journal.entry_date }}</td>
                                            <td>
                                                <router-link :to="{name: 'edit-journal', params:{id:journal.id}}" class="btn btn-sm btn-primary">Edit</router-link>

                                                <a @click="cancelJournal(journal.id)" class="btn btn-sm btn-danger"><font color="#fffffff">Cancel</font></a>
                                            </td>
                                        </tr>
                                        <tr class="bg-dark text-white">
                                                <td>Totals:</td>
                                                <td>${{totalAmt}}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                        </tr>
                                        
                                        </tbody>
                                        
                                    </table>
                                </div>
                                

                            </div> 
                          

                        </div> 
                    </div> 
                  

                     <!-- end tab home -->

                        <!-- begin other users -->  
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                         
                            <div class="card-body">
                            <!--<input type="text" v-model="searchItem" class="form-control" style="width: 560px;" placeholder="Search Product">-->
                            <div class="row"> 
                                <input type="text" v-model="getsearchItem" class="form-control" style="width: 560px;" placeholder="Search Entry">
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
                                        <tr v-for="getjournal in getfiltersearch" :key="getjournal.id">
                                            <td>{{ getjournal.details }}</td>
                                            <td>{{ getjournal.amount }}</td>
                                            <td>{{ getjournal.entry_date }}</td>
                                            <td>
                                                <router-link :to="{name: 'edit-journal', params:{id:getjournal.id}}" class="btn btn-sm btn-primary">Edit</router-link>

                                                <a @click="cancelJournal(getjournal.id)" class="btn btn-sm btn-danger"><font color="#fffffff">Cancel</font></a>
                                            </td>
                                        </tr>
                                        <tr class="bg-dark text-white">
                                            <td>Totals:</td>
                                            <td>${{totalAmtOthers}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
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

// $(document).ready(function() {
//     $('#tablehome').DataTable( {
//         "scrollY": 200,
//         "scrollX": true
//     } );
// } );
export default {

created(){
if (!User.loggedIn()) {
    this.$router.push({ name: '/' })
}
},
data(){
    return {
        journals:[],
        getjournals:[],
        searchItem: '',
        getsearchItem: '',
        settings:'',
        journalusers:'',
    }
},
computed:{
    filtersearch(){
        return this.journals.filter(journal =>{
            return journal.details.match(this.searchItem)
        })
    },
    getfiltersearch(){
       
        return this.getjournals.filter(getjournal =>{
            return getjournal.details.match(this.getsearchItem)
        })
    },
    totalAmt(){
      let total = 0;  
      for(let p of this.journals) 
      {    total += parseFloat(p.amount);  }  
      return  parseFloat(total).toFixed(2);
    },
    totalAmtOthers(){
      let total = 0;  
      for(let p of this.getjournals) 
      {    total += parseFloat(p.amount);  }  
      return  parseFloat(total).toFixed(2);
    },
},

methods: {
  
    allJournal(){
       
    // axios.get('/api/expense')
    // .then(({data}) => {this.expenses = data;})
    // .catch()
    // },
 
    var param1 = { user:this.user};

    axios.post('/api/myjournal',param1)
    .then(({data}) => {this.journals = data;console.log(this.journals);})
    .catch()
    },
    deleteJournal(id){
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
            axios.delete('/api/journal/'+id)
            .then(()=>{
                this.journals  = this.journals.filter(journal =>{
                    return journal.id != id
                })
            })
            .catch(()=>{
                this.$router.push({name: 'journal'})
            })

            Swal.fire(
            'Deleted!',
            'Your file has been deleted.',
            'success'
            )
        }
        })
    },
    cancelJournal(id){
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'No.',
        }).then((result) => {
        if (result.isConfirmed) {
            axios.post('/api/canceljournal/'+id)
            .then(()=>{

                this.journals  = this.journals.filter(journal =>{
                    return journal.id != id
                });

                this.getjournals  = this.getjournals.filter(getjournal =>{
                    return getjournal.id != id
                })

            })
            .catch(()=>{
                this.$router.push({name: 'journals'})
            })

            Swal.fire(
            'Cancelled!',
            'Your file has been cancelled.',
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
        axios.get('/api/journalusers/'+this.user)
        .then(({data}) => (this.journalusers = data))
        .catch()
    },
    otherusers(id){
        axios.get('/api/journalotheruser/'+id)
        .then(({data}) => (this.getjournals = data))
        .catch()
    },

},

created(){
    this.user = User.name(); 
    this.getsettings();
    this.allJournal();
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
