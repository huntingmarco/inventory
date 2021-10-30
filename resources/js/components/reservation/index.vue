<template>
    <div>

    <div class="row">
        <router-link to="/store-reservation" class="btn btn-primary">Add Reservation</router-link>

    </div>
    <br>
        <input type="text" v-model="searchItem" class="form-control" style="width: 300px;" placeholder="Search Customer">
    </br>

    <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Reservation List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Date From</th>
                        <th>Date To</th>
                        <th>Category</th>
                        <th>Room</th>
                        <th>No. of Rooms</th>
                        <th>Customer</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="reservation in filtersearch" :key="reservation.id">
                        <td>{{ reservation.date_from }}</td>
                        <td>{{ reservation.date_to }}</td>
                        <td>{{ reservation.roomcategory_name }}</td>
                        <td>{{ reservation.room_name }}</td>
                        <td>{{ reservation.numrooms }}</td>
                        <td>{{ reservation.name }}</td>
                        <td>{{ reservation.phone }}</td>
                        <td>{{ reservation.email }}</td>
                        
                        <td v-if="reservation.status == 'RESERVED'"><span class="badge badge-warning">{{ reservation.status }}</span></td>
                        <td v-else="reservation.status == 'CANCELLED'"><span class="badge badge-danger">{{ reservation.status }}</span></td>
                        <td v-else="reservation.status == 'CHECKIN'"><span class="badge badge-info">{{ reservation.status }}</span></td>
                        <td v-else="reservation.status == 'CHECKOUT'"><span class="badge badge-success">{{ reservation.status }}</span></td>
            <td>
                <router-link :to="{name: 'edit-reservation', params:{id:reservation.id}}" class="btn btn-sm btn-primary">Edit</router-link>

                <a @click="deleteReservation(reservation.id)" class="btn btn-sm btn-danger"><font color="#fffffff">Cancel</font></a>
            </td>
                      </tr>
                      
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
          <!--Row-->


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
            reservations:[],
            searchItem: '',
        }
    },
    computed:{
        filtersearch(){
            return this.reservations.filter(reservation =>{
                return reservation.name.match(this.searchItem)
            })
        }
    },

    methods: {
        allReservation(){
        axios.get('/api/reservation/')
        .then(({data}) => {this.reservations = data;console.log(this.reservations)})
        .catch()
        },
        deleteReservation(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
            }).then((result) => {
            if (result.isConfirmed) {
                axios.post('/api/cancelreservation/'+id)
                .then(()=>{

                    // this.reservations  = this.reservations.filter(reservation =>{
                    //     return reservation.id != id
                    // });
                    Reload.$emit('AfterTransact');
                    //Notification.cart_success()
                    

                })
                .catch(()=>{
                    this.$router.push({name: 'reservation'})
                })

                Swal.fire(
                'Cancelled!',
                'Your file has been cancelled.',
                'success'
                )
            }
            })
        }



    },
    created(){
        this.allReservation();
        Reload.$on('AfterTransact',()=>{
          this.allReservation();
        });
    }
  
}
 

</script>


<style type="text/css">
    #em_photo{
        height:40px;
        width:40px;
    }
</style>