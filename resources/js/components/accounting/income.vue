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
                    <h1 class="h4 text-gray-900 mb-4">Financial Condition</h1>
                  </div>
                  <form class="user" @submit.prevent="generateIncome">
                  
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="exampleFormControlTextarea1"><b>As of Date</b></label>
                                <input type="date" class="form-control" id="asofdate" required="" v-model="date">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block" id="generate">Generate</button>
                    </div>
                   
                    

                  </form>

                  <hr>

                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Income</h6>
                  </div>
                  <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Account </th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="account in get_income_account">
                                    <td>{{ account.item_id }}</td>
                                    <td>{{ account.item_name }}</td>
                                    <td>${{ account.bal }}</td>
                                </tr>
                            </tbody>
                            <div class="card-footer">
                                <tr class="bg-dark text-white">
                                    <td>Total Income:</td>
                                    <td>${{totalIncomeBal}}</td>
                                    <td></td>
                                </tr>
                            </div>
                        </table>
                    </div>

                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Expense</h6>
                        </div>
                        <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Account </th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="account in get_expense_account">
                                    <td>{{ account.item_id }}</td>
                                    <td>{{ account.item_name }}</td>
                                    <td>${{ account.bal }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                
                                
                            </tfoot>
                            <div class="card-footer">
                                <tr class="bg-dark text-white">
                                    <td>Total Expense:</td>
                                    <td>${{totalExpenseBal}}</td>
                                    <td></td>
                                </tr>
                                <tr class="bg-success text-white">
                                    <td>Net Income/Loss:</td>
                                    <td>${{netIncome}}</td>
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
   
    get_income_account(){
        return this.accounts
    },
    totalIncomeBal(){
      let total = 0;  
   
      for(let p of this.accounts) 
      {    total += parseFloat(p.bal);  }  
      return  parseFloat(total).toFixed(2);
    },
    get_expense_account(){
   
        return this.accounts
    },
    totalExpenseBal(){
      let total = 0;  
     
      for(let p of this.accounts) 
      {    total += parseFloat(p.bal);  }  
      return  parseFloat(total).toFixed(2);
    },
    netIncome(){
      let total = 0;  
    
      for(let inc of this.accounts) 
      {    total += parseFloat(inc.bal);  }  

    
      for(let exp of this.accounts) 
      {    total -= parseFloat(exp.bal);  }
      return  parseFloat(total).toFixed(2);
    },
    },

  methods: {
   
    generateIncome(){
       
        var data = {date:this.date, user: User.name()} //v-model name -> date:
        axios.post('/api/income/', data)
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