<template>
    <div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Update Reservation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
              
              <form class="user" @submit.prevent="reservationUpdate" enctype="multipart/form-data">

                  <div class="form-group">



                    <div class="form-row">

                    

                              <div class="col-md-6">
                                      <label for="exampleFormControlSelect1">Room Category</label>
                                      <select @change="changeCateg($event)" class="form-control" id="exampleFormControlSelect1" v-model="editrecord.idcategory">
                                          <option :value="category.id" v-for="category in room_categories">{{ category.roomcategory_name }}</option>
                                      </select>  
                              </div>


                              <div class="col-md-6">
                                        <label for="exampleFormControlSelect1">Room ID</label>
                                        <select class="form-control" id="exampleFormControlSelect1" v-model="editrecord.idroom">
                                          <option :value="room.id" v-for="room in rooms">{{ room.room_name }}</option>
                                        </select>   
                              </div>     
                              
                          </div>
                  </div>


                  <div class="form-group">
                      <div class="form-row">
                              <div class="col-md-4">
                                  <label for="exampleFormControlSelect1">Date From</label>
                                  <input type="date" class="form-control" id="exampleInputFirstName1" placeholder="Date from" v-model="editrecord.date_from">
                                  <small class="text-danger" v-if="errors.address">{{ errors.date_from[0] }}</small>

                              </div>

                              <div class="col-md-4">
                                  <label for="exampleFormControlSelect1">Date To</label>
                                  <input type="date" class="form-control" id="exampleInputFirstName" placeholder="Date to" v-model="editrecord.date_to">
                                  <small class="text-danger" v-if="errors.address">{{ errors.date_to[0] }}</small>   
                              </div>   

                              <div class="col-md-4">
                                  <label for="exampleFormControlSelect1">No. of Rooms</label>
                                  <input type="number" class="form-control" id="exampleInputFirstName" placeholder="No. of Rooms" v-model="editrecord.numrooms">
                                  <small class="text-danger" v-if="errors.address">{{ errors.numrooms[0] }}</small>   
                              </div> 
                      </div>
                  </div>




                  <div class="form-group">

                    <div class="form-row">
                        <div class="col-md-6">
                                <label for="exampleFormControlSelect1">Customer</label>
                                <model-list-select :list="customers"
                                  v-model="editrecord.customer_id"
                                  option-value="id"
                                  option-text="name"
                                  placeholder="select item">
                                </model-list-select>  
                        </div>


                      <div class="col-md-6">
                          <label for="exampleFormControlSelect1">Phone</label>
                          <input type="text" class="form-control" id="exampleInputFirstName"  v-model="editrecord.phone">
                          <small class="text-danger" v-if="errors.phone"> {{ errors.phone[0] }} </small>
                      </div>

                    </div>
                  </div>


                  <div class="form-group">

                    <div class="form-row">
                      <div class="col-md-6">
                              <label for="exampleFormControlSelect1">Email</label>
                              <input type="text" class="form-control" id="exampleInputFirstName"  v-model="editrecord.email">
                              <small class="text-danger" v-if="errors.email"> {{ errors.email[0] }} </small>  
                      </div>


                      <div class="col-md-6">
                          <label for="exampleFormControlSelect1">Notes</label>
                          <input type="text" class="form-control" id="exampleInputFirstName"  v-model="editrecord.notes">
                          <small class="text-danger" v-if="errors.notes"> {{ errors.notes[0] }} </small>
                      </div>

                    </div>
                  </div>



                  <div class="form-group">
                      <div class="form-row">
                          <div class="col-md-6">
                            <button type="submit" class="btn btn-primary btn-block col-md-6" >Update</button>
                          </div>
                          <div class="col-md-2">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                      </div>
                  </div>

                  </form>

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
  props:['editrecord'],
created(){
  if (!User.loggedIn()) {
    this.$router.push({ name: '/' })
  }
},

data(){
  return {
      errors:{},
      room_categories:{},
      rooms:{},
      customers: [],
    }
  },
  created(){

       axios.get('/api/roomcategory/')
        .then(({data}) => (this.room_categories = data))

        axios.get('/api/room/')
        .then(({data}) => (this.rooms = data))


         axios.get('/api/customer/')
         .then(({data}) => (this.customers = data))
  },

  methods: {
    reservationUpdate(){

      const config={
					headers:{
						"Content-type":"multipart/form-data"
					}
				}
        
				const formData = new FormData();
				formData.append('idcategory',this.editrecord.idcategory);
				formData.append('idroom',this.editrecord.idroom);
				formData.append('date_from',this.editrecord.date_from);
				formData.append('date_to',this.editrecord.date_to);
        formData.append('numrooms',this.editrecord.numrooms);
        formData.append('customer_id',this.editrecord.customer_id);
				formData.append('phone',this.editrecord.phone);
				formData.append('email',this.editrecord.email);
        formData.append('notes',this.editrecord.notes);
        formData.append('_method', 'PUT')
     
				axios.post('/api/reservation/'+this.editrecord.id,formData,config).then((response)=>{
					$('#exampleModal').modal('hide');
					// this.$emit('recordUpdated',response)
          Reload.$emit('AfterTransact');
          $('.modal-backdrop').remove();
         
					Swal.fire({
						  position: 'center',
						  icon: 'success',
						  title: 'Your changes has been saved',
						  showConfirmButton: false,
						  timer: 1500
						})
					
				}).catch((error)=>{
					console.log(error)
				})
    },
    changeCateg (event) {
      this.idcategory = event.target.value
      axios.get('/api/room/categ/'+this.idcategory)
      .then(response => {this.rooms = response.data;console.log(response);})
      .catch(error => this.errors = error.response.data.errors)
      
    },
  },
  components: {
    ModelListSelect
    }
  


}
 

</script>


<style type="text/css">
</style>