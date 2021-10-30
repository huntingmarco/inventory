

<template>
  
  <div>

 <div class="row">
  <router-link to="/reservation" class="btn btn-primary">Back</router-link>
   
 </div>



    <div class="row justify-content-center">
      <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Reservation</h1>
                  </div>

      <form class="user" @submit.prevent="reservationInsert" enctype="multipart/form-data">

        <div class="form-group">

        

          <div class="form-row">

           

                    <div class="col-md-6">
                            <label for="exampleFormControlSelect1">Room Category</label>
                            <select @change="changeCateg($event)" class="form-control" id="exampleFormControlSelect1" v-model="form.idcategory">
                                <option :value="category.id" v-for="category in room_categories">{{ category.name }}</option>
                            </select>  
                    </div>


                    <div class="col-md-6">
                              <label for="exampleFormControlSelect1">Room ID</label>
                              <select class="form-control" id="exampleFormControlSelect1" v-model="form.idroom">
                                <option :value="room.id" v-for="room in rooms">{{ rooms.room }}</option>
                              </select>   
                    </div>     
                    
                </div>
        </div>
       
        
         <div class="form-group">
            <div class="form-row">
                    <div class="col-md-6">
                        <label for="exampleFormControlSelect1">Date From</label>
                        <input type="date" class="form-control" id="exampleInputFirstName" placeholder="Transact Date" v-model="form.transact_date">
                        <small class="text-danger" v-if="errors.address">{{ errors.transact_date[0] }}</small>

                    </div>

                    <div class="col-md-6">
                        <label for="exampleFormControlSelect1">Date To</label>
                        <input type="date" class="form-control" id="exampleInputFirstName" placeholder="Transact Date" v-model="form.transact_date">
                        <small class="text-danger" v-if="errors.address">{{ errors.transact_date[0] }}</small>   
                    </div>    
            </div>
        </div>

       


        <div class="form-group">

          <div class="form-row">
              <div class="col-md-6">
                      <label for="exampleFormControlSelect1">Customer</label>
                      <model-list-select :list="customers"
                        v-model="form.customer_id"
                        option-value="id"
                        option-text="name"
                        placeholder="select item">
                      </model-list-select>  
              </div>


            <div class="col-md-6">
                <label for="exampleFormControlSelect1">Phone</label>
                <input type="text" class="form-control" id="exampleInputFirstName"  v-model="form.buying_price">
                <small class="text-danger" v-if="errors.buying_price"> {{ errors.buying_price[0] }} </small>
            </div>

          </div>
        </div>


        <div class="form-group">

          <div class="form-row">
            <div class="col-md-6">
                    <label for="exampleFormControlSelect1">Email</label>
                    <input type="text" class="form-control" id="exampleInputFirstName"  v-model="form.buying_price">
                    <small class="text-danger" v-if="errors.buying_price"> {{ errors.buying_price[0] }} </small>  
            </div>


            <div class="col-md-6">
                <label for="exampleFormControlSelect1">Notes</label>
                <input type="text" class="form-control" id="exampleInputFirstName"  v-model="form.buying_price">
                <small class="text-danger" v-if="errors.buying_price"> {{ errors.buying_price[0] }} </small>
            </div>

          </div>
        </div>



        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block col-md-6">Submit</button>
        </div>
        
      </form>
                  <hr>
                  <div class="text-center">
  
  
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
import 'vue-search-select/dist/VueSearchSelect.css';
import { ModelListSelect } from 'vue-search-select';


  export default {
    created(){
      if (!User.loggedIn()) {
        this.$router.push({name: '/'})
      }
    },

    data(){
    return {
      form:{
        idcategory: null,
        idroom: null,
        date_from: null,
        date_to: null,
        numrooms: null,
        customer_id: null,
        phone: null,
        email: null,
        notes: null
      },
      errors:{},
      room_categories:{},
      rooms:{},
      customers: [],
    }
  },

  methods:{
    reservationInsert(){
        console.log(this.form)
      axios.post('/api/reservation', this.form)
      .then(res => {
          this.$router.push({name: 'reservation'})
          Notification.success();
        })
        .catch(error => this.errors = error.response.data.errors)
    },

    changeCateg (event) {
      this.idcategory = event.target.value
      axios.get('/api/room/categ/'+this.idcategory)
      .then(response => {this.rooms = response.data;console.log(response);})
      .catch(error => this.errors = error.response.data.errors)
      
    },
    getsystemdate(){
            axios.get('/api/sysdate/')
            .then(({data}) => {this.form.date_from = data;this.form.date_to = data; })
            .catch()
        },
  },
  created(){
    axios.get('/api/category_room/')
    .then(({data}) => (this.categories = data))

    axios.get('/api/customer/')
    .then(({data}) => (this.customers = data))

    this.getsystemdate();

    axios.get('/api/category')
    .then(response => {this.room_categories = response.data;console.log(response);})

  } ,
  components: {
    ModelListSelect
    }


  }
   
</script>


<style type="text/css">
  
</style>