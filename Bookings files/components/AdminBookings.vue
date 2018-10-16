<template>
  <div>




      <h2>Manage bookings:</h2>

    <div v-if="bookings.length>0">

        <table>
          <thead>
          <tr>
            <td>Ref</td>
            <td>Client</td>
            <td>Service</td>
            <td>Date</td>
            <td>Status</td>
            <td>Action</td>
          </tr>
          </thead>
          <tbody>
          <tr v-for="booking in bookings">
            <td>
              {{booking.ref}}
            </td>
            <td>
              <a href="#" data-toggle="modal" data-target="#userProfileModal" @click="user=booking.user">{{booking.user.name}} </a>
              <br/>
              ({{booking.user.email}})
            </td>
            <td>
              {{booking.service.description}}
            </td>
            <td>
              {{formatDate(booking.date) || 'not found'}}
            </td>
            <td>
              <!-- Dynamic style binding -->
              <div :class="{green:booking.status=='approved',red:booking.status=='denied',blue:booking.status=='finished'}">
                {{ucfirst(booking.status) || 'not found'}}
              </div>
            </td>
            <td>
              <a href="#" @click="setBookingStatus('approved',booking.bookingid)">Approve</a> /
              <a href="#" @click="setBookingStatus('denied',booking.bookingid)">Deny</a><br>
              <a href="#" @click="setBookingStatus('finished',booking.bookingid)">Mark as finished</a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    <div v-else>
      <i>No one has created a booking yet</i>
    </div>


    <!--User profile modal in bootstrap-->
    <div class="modal fade" id="userProfileModal" tabindex="-1" role="dialog" aria-labelledby="userProfileModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userProfileModalLabel">User profile</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul class="list-group">
              <li class="list-group-item"><div class="ml-auto"><strong>Name: </strong> {{user.name || 'not set'}}</div></li>
              <li class="list-group-item"><div class="ml-auto"><strong>Email: </strong> {{user.email || 'not set'}}</div></li>
              <li class="list-group-item"><div class="ml-auto"><strong>Cell: </strong> {{user.cell || 'not set'}}</div></li>
              <li class="list-group-item"><div class="ml-auto"><strong>Gender: </strong> {{user.gender || 'not set'}}</div></li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>


  <!-- Just so the page can scroll down a bit more -->
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  </div>
</template>

<script>
    export default {
        name: "admin-bookings",
        data(){
            return {
                bookings:[],
                user:{}
            }
        },
        methods:{
            getBookings() {
                axios.get('/bookings/all').then(
                    (response) => {
                        this.bookings = response.data;
                    },
                    (error) => {

                    },
                );
            },
            setBookingStatus(status, bookingid)
            {
                axios.patch('/bookings/status/'+bookingid,{status:status}).then(
                    (response)=>{
                        this.getBookings(); //refresh bookings to update status and to check for new bookings
                    },
                    (error)=>{},
                )
            },
            ucfirst(string) { return string.charAt(0).toUpperCase() + string.slice(1); },
            formatDate(date){
              //Moment is a package that can format dates in human readable form. Go check them out!
              return Vue.moment(date).format('Do MMM [`]YY [at] h:mm a');
            }
        },
        mounted(){
            this.getBookings();

            //Refresh bookings every 30 seconds
            setInterval(
              ()=>{
                this.getBookings();
              }, 30000
            );
        }
    }
</script>

<style scoped>
/*  status colors */
  .green{color:green}
  .red{color:red}
  .blue{color:blue}
</style>
