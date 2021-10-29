<template>
    <div>

    

        <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Trial Balance</h1>
                  </div>
                  <form class="user" @submit.prevent="generateTrialBalance">
                  
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="exampleFormControlTextarea1"><b>Transaction Date</b></label>
                                <input type="date" class="form-control" id="trndate" required="" v-model="date">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" id="generate">Generate</button>
                    </div>
                   
                    

                  </form>

                  <hr>

                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Transaction</h6>
                  </div>
                  <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Account </th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="account in accounts">
                                    <td>{{ account.item_name }}</td>
                                    <td>${{ account.debit }}</td>
                                    <td>${{ account.credit }}</td>
                                </tr>
                            </tbody>
                            <div class="card-footer">
                                <tr class="bg-dark text-white">
                                    <td>Total Debit:</td>
                                    <td>${{totalDebit}}</td>
                                    <td>=</td>
                                    <td>Total Credit:</td>
                                    <td>${{totalCredit}}</td>
                                    <td></td>
                                </tr>
                            </div>
                        </table>
                    </div>

                  
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
      date:'',
      accounts:[]
    }
  },
  computed:{
        totalDebit(){
            let total = 0;  
            for(let p of this.accounts) 
            {    total += parseFloat(p.debit);  }  
            return  parseFloat(total).toFixed(2);
        },
        totalCredit(){
            let total = 0;  
            for(let p of this.accounts) 
            {    total += parseFloat(p.credit);  }  
            return  parseFloat(total).toFixed(2);
        }
    },

  methods: {
   
    generateTrialBalance(){
        var data = {date:this.date, user: User.name()} //v-model name -> date:
        axios.post('/api/trialbalance/', data)
        .then(({data})=>{this.accounts = data;console.log(this.accounts)})
        .catch(error => this.errors = error.response.data.errors)
    },
    getsystemdate(){
            axios.get('/api/sysdate/')
            .then(({data}) => {this.date = data; })
            .catch()
        }
  },
  created(){
    this.getsystemdate();
  }
}
</script>


<style type="text/css">
    #asofdate,#generate{
        width: 200px; 
    }
</style>