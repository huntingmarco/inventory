<template>
    <div>

    <div class="row">
        <router-link to="/journal" class="btn btn-primary">Journal Entries</router-link>

    </div>

        <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Journal Entry</h1>
                  </div>
                  <form class="user" @submit.prevent="journalInsert">
                  
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="exampleFormControlTextarea1"><b>Entry details</b></label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="form.details"></textarea>
                                <small class="text-danger" v-if="errors.details">{{ errors.details[0] }}</small>
                            </div>

                            <div class="col-md-12">
                              <label for="exampleFormControlSelect1">Account Group</label>
                              <select @change="changeGroup($event)" class="form-control" id="exampleFormControlSelect1" v-model="form.group_id">
                                <option :value="acctgroup.group_id" v-for="acctgroup in acctgroups">{{ acctgroup.group_name }}</option>
                              </select>   
                            </div>

                            <div class="col-md-12">
                              <label for="exampleFormControlSelect1">Account Item</label>
                              <select class="form-control" id="exampleFormControlSelect1" v-model="form.item_id">
                                <option :value="acctitem.item_id" v-for="acctitem in acctitems">{{ acctitem.item_name }}</option>
                              </select>   
                            </div>

                            <div class="col-md-12"><br>
                                <label for="exampleFormControlTextarea1"><b>Amount</b></label>
                                <input type="number" step="0.01" class="form-control" id="exampleInputFirstName" placeholder="Enter Amount" v-model="form.amount">
                                <small class="text-danger" v-if="errors.amount">{{ errors.amount[0] }}</small>
                            </div>

                        </div>
                    </div>

                    
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Save</button>
                    </div>
                   
                  </form>

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
    form:{
      details: '',
      amount: '',  
      user:'',
      group_id: null,
      item_id: null,
      },
      errors: {},
      acctgroups:{},
      acctitems:{}
    }
  },

  methods: {
   
    journalInsert(){

      this.form.user = User.name(); 
      axios.post('/api/journal', this.form)
      .then(res => {
          this.$router.push({name: 'journal'})
          Notification.success();
        })
        .catch(error => this.errors = error.response.data.errors)
    },

    changeGroup (event) {
      this.group_id = event.target.value
      axios.get('/api/acctitem/group/'+this.group_id)
      .then(response => {this.acctitems = response.data;console.log(response);})
      .catch(error => this.errors = error.response.data.errors)
      
    }

  },

  created(){
    axios.get('/api/acctgroup')
    .then(response => {this.acctgroups = response.data;console.log(response);})
    

    // axios.get('api/acctitem/group/'+this.group_id)
    // .then(({data}) => (this.acctitems = data))
  

  } 
  
}
 

</script>


<style type="text/css">
</style>