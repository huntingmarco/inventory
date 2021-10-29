<template>
    <div>

    <div class="row">
        <router-link to="/acctgroup" class="btn btn-primary">All Account Group</router-link>

    </div>

        <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Account Group</h1>
                  </div>
                  <form class="user" @submit.prevent="acctgroupInsert">
                  
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="exampleFormControlTextarea1"><b>Group Name</b></label>
                                <input type="text" class="form-control" id="exampleInputFirstName" placeholder="" v-model="form.group_name">
                                <small class="text-danger" v-if="errors.group_name">{{ errors.group_name[0] }}</small>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="exampleFormControlTextarea1"><b>Group Type</b></label>
                                <select class="form-control" v-model="form.grouptype">
                                    <option value="A">Assets</option>
                                    <option value="B">Liabilities</option>
                                    <option value="C">Capital</option>
                                    <option value="D">Income</option>
                                    <option value="E">Expense</option>
                                </select>
                                <small class="text-danger" v-if="errors.grouptype">{{ errors.grouptype[0] }}</small>
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

data(){
  return {
    form:{
      group_name: null,
      grouptype: null
      },
      errors: {}  
    }
  },

  methods: {
   
    acctgroupInsert(){
      axios.post('/api/acctgroup', this.form)
      .then(res => {
          this.$router.push({name: 'acctgroup'})
          Notification.success();
        })
        .catch(error => this.errors = error.response.data.errors)
    },
  }
  


}
 

</script>


<style type="text/css">
</style>