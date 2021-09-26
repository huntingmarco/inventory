<template>
    <div>

    <div class="row">
        <router-link to="/add-payroll" class="btn btn-primary">Back</router-link>

    </div>

        <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Pay Salary</h1>
                  </div>
                  <form class="user" @submit.prevent="paySalary">
                  

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="text" disabled class="form-control" id="exampleInputFirstName" placeholder="Enter Your Name" v-model="form.name">
                                <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                            </div>

                            <div class="col-md-6">
                                <input type="email" disabled class="form-control" id="exampleInputFirstName" placeholder="Enter Your Email" v-model="form.email">
                                <small class="text-danger" v-if="errors.name">{{ errors.email[0] }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-3">
                                <label for="exampleFormControlSelect1">Pay ID</label>
                                <select class="form-control" id="exampleFormControlSelect1" v-model="form.pay_id">
                                    <option :value="pays.id" v-for="pay in pays">{{ pay.id }}</option>
                                </select>  
                                <small class="text-danger" v-if="errors.salary_month">{{ errors.pay_id[0] }}</small>
                            </div>

                           

                            <div class="col-md-46">
                                <label for="exampleFormControlSelect1">Pay</label>
                                <input type="number" class="form-control" id="exampleInputFirstName" placeholder="Enter pay" v-model="form.salary">
                                <small class="text-danger" v-if="errors.salary">{{ errors.salary[0] }}</small>
                            </div>
                        </div>
                    </div>
          
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Pay Now</button>
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
      name: '',
      email: '',
      pay_id: '',
      salary: '',
      user:''
      },
      pays:{},
      errors: {}  
    }
  },
  created(){
      let id = this.$route.params.id;
      axios.get('/api/employee/'+id)
      .then(({data})=>this.form = data)
      .catch(console.log('error'))
  },

  methods: {
  
    paySalary(){
        let id = this.$route.params.id;
        this.form.user = User.name(); 
      axios.post('/api/payroll/paid/'+id, this.form)
      .then(res => {
          this.$router.push({name: 'payroll'})
          Notification.success();
        })
        .catch(error => this.errors = error.response.data.errors)
    },
  },
  created(){
    axios.get('/api/payroll/')
    .then(({data}) => (this.pays = data))

  } 
  


}
 

</script>


<style type="text/css">
</style>