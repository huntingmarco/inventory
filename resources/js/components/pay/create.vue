<template>
    <div>

    <div class="row">
        <router-link to="/pay" class="btn btn-primary">All Pay</router-link>

    </div>

        <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Pay</h1>
                  </div>
                  <form class="user" @submit.prevent="payInsert" enctype="multipart/form-data">
                  
                    <div class="form-group">
                        <div class="form-row">
                       
                            <div class="col-md-3">
                                <label for="exampleFormControlSelect1">Pay from</label>
                                <input type="date" class="form-control" id="exampleInputFirstName" placeholder="Enter pay from"  v-model="form.payfrom">
                                
                                <small class="text-danger" v-if="errors.payfrom">{{ errors.payfrom[0] }}</small>
                            </div>

                            <div class="col-md-3">
                                <label for="exampleFormControlSelect1">Pay to</label>
                                <input type="date" class="form-control" id="exampleInputFirstName" placeholder="Enter pay to" v-model="form.payto">
                                <small class="text-danger" v-if="errors.payto">{{ errors.payto[0] }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="exampleFormControlSelect1">Details</label>
                                <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter details" v-model="form.details">
                                <small class="text-danger" v-if="errors.details">{{ errors.details[0] }}</small>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="exampleFormControlSelect1">Transact Date</label>
                                <input type="date" class="form-control" id="exampleInputFirstName" placeholder="Transact Date" v-model="form.transact_date">
                                <small class="text-danger" v-if="errors.address">{{ errors.transact_date[0] }}</small>
                            </div>

                        </div>
                    </div>

  
                    
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block col-md-6">Save</button>
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

created(){
    this.getsystemdate();
},
// new Date().toISOString().slice(0,10) }
//JSON.stringify(this.gdate()),
data(){
  return {
    form:{
      payfrom: null,
      payto: null,
      details: null,
      transact_date: null,
      user:'',
      },
      errors: {},
      settings:''

    }
  },

  methods: {

    payInsert(){
        this.form.user = User.name(); 
      axios.post('/api/pay', this.form)
      .then(res => {
          this.$router.push({name: 'pay'})
          Notification.success();
        })
        .catch(error => this.errors = error.response.data.errors)
    },

    getsystemdate(){
            axios.get('/api/settings/')
            .then(({data}) => {this.settings = data.sysdate; console.log(this.settings,'asdf');})
            .catch()
        }
    
    

  }

}
 

</script>


<style type="text/css">
</style>