<template>
    <div>

    <div class="row">
        <router-link to="/pay" class="btn btn-primary">Back</router-link>

    </div>

        <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Payroll Range Update</h1>
                  </div>
                  <form class="user" @submit.prevent="payUpdate" enctype="multipart/form-data">
                  
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
                      <button type="submit" class="btn btn-primary btn-block col-md-6">Update</button>
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
      transact_date: '',
      },
      errors: {}  
    }
  },
  created(){
      let id = this.$route.params.id;
      axios.get('/api/pay/'+id)
      .then(({data})=>this.form = data)
      .catch(console.log('error'))
  },

  methods: {
    payUpdate(){
        let id = this.$route.params.id;
      axios.patch('/api/pay/'+id, this.form)
      .then(res => {
          this.$router.push({name: 'pay'})
          Notification.success();
        })
        .catch(error => this.errors = error.response.data.errors)
    },
  }

}
 

</script>


<style type="text/css">
</style>