<template>
    <div>

    <div class="row">
        <!-- <router-link to="/view-salary" class="btn btn-primary"></router-link> -->
        <router-link :to="{name: 'view-salary', params:{id:this.pay_id}}" class="btn btn-sm btn-primary">Back</router-link>
    </div>

        <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Update Payroll</h1>
                  </div>
                  <form class="user" @submit.prevent="updateSalary">
                  
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" disabled id="exampleInputFirstName" placeholder="Enter Your Name" v-model="form.name">
                                <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                            </div>

                            <div class="col-md-6">
                                <input type="email" class="form-control" id="exampleInputFirstName" placeholder="Enter Your Email" v-model="form.email">
                                <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-row">
                           

                            <input type="hidden" v-model="form.employee_id">
                            <div class="col-md-6">
                                <label for="exampleFormControlSelect1">Amount</label>
                                <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Salary" v-model="form.amount">
                                <small class="text-danger" v-if="errors.amount">{{ errors.amount[0] }}</small>
                            </div>
                        </div>
                    </div>
          
                    <div class="form-group col-md-6">
                      <button type="submit" class="btn btn-primary btn-block">Update</button>
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
      salary_month: '',
      amount: '',
      employee_id:'',
      pay_id:''
      },
      errors: {}  
    }
  },
  created(){
      let id = this.$route.params.id;
      this.pay_id = this.$route.params.pay_id;
      axios.get('/api/edit/payroll/'+id)
      .then(({data})=>this.form = data)
      .catch(console.log('error'))
  },

  methods: {
  
    updateSalary(){
        let id1 = this.$route.params.id;
        let id = this.$route.params.pay_id;
      axios.post('/api/payroll/update/'+id1, this.form)
      .then(res => {
          this.$router.push({name: 'view-salary',params: { id }})
          Notification.success();
        })
        .catch(error => this.errors = error.response.data.errors)
    },
  }
  


}
 

</script>


<style type="text/css">
</style>