<template>
  <div v-if="user">



    <button  data-toggle="modal" data-target="#newBookingModal"
            data-backdrop="static" data-keyboard="false">
      Create new booking
    </button>
    <br>
    <br>
    <br>


      <h2><strong>{{user.name}}</strong> booking log:</h2>


    <div v-if="user.bookings.length > 0">
      <table style="min-width: 730px">
        <thead>
        <tr>
          <td>Ref</td>
          <td>Service</td>
          <td>Date</td>
          <td>Status</td>
          <td>Action</td>
        </tr>
        </thead>
        <tbody>
        <tr v-for="booking in user.bookings">
          <td>
            {{booking.ref}}
          </td>
          <td>
            {{booking.service.description}}
          </td>
          <td>
            {{booking.date || 'not found'}}
          </td>
          <td>
            {{booking.status || 'not found'}}
          </td>
          <td>
            <button data-toggle="modal" data-target="#confirmDeleteModal"
                    data-backdrop="static" data-keyboard="false" @click="deleteBookingId = booking.bookingid">Remove
            </button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
    <div v-else>
      <i>You have no bookings, please create one to get started</i>
    </div>

    <!-- New Booking Modal -->
    <div class="modal fade" id="newBookingModal" tabindex="-1" role="dialog" aria-labelledby="newBookingModalLabel"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="newBookingModalLabel">Create new booking</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <template v-if="bookingCreateSuccess">
              <div class="alert alert-success" role="alert">Successfully created booking</div>
            </template>
            <template v-else>
              <label for="">When is the booking?</label>
              <input class="form-control" v-model="booking.date" type="datetime-local">
              <br>
              <label>What type of service do you want?</label>
              <select name="" class="form-control" v-model="booking.serviceid">
                <option value="-" selected disabled>Please select</option>
                <option :value="service.serviceid" v-for="service in services">{{service.description}}</option>
              </select>
              <p v-if="services.length < 1" class="text-danger">There are no available services</p>
            </template>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="bookingCreateSuccess=false">Close</button>
            <button type="button" class="btn btn-primary" @click="createBooking()"
                    :disabled="booking.serviceid ==='-' || !booking.date || bookingCreateSuccess">Save booking
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Confirm delete booking -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
         aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmDeleteModalLabel">Are you sure?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <template v-if="bookingDeleteSuccess">
              <div class="alert alert-success" role="alert">Successfully deleted booking</div>
            </template>
            <template v-else>
              Are you sure you want to delete your booking? This cannot be undone!
            </template>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="deleteBookingId=null; bookingDeleteSuccess=false;">Close</button>
            <button type="button" class="btn btn-danger" :disabled="bookingDeleteSuccess" @click="deleteBooking()">
              Delete booking
            </button>
          </div>
        </div>
      </div>
    </div>



  </div>
</template>

<script>
    export default {
        name: "personal-bookings",
        data() {
            return {
                user: null,
                booking: {
                    date: '',
                    serviceid: '-',
                    userid: null,
                },
                services: [],
                deleteBookingId: null, //this will hold the booking ID while we wait for the user to confirm
                bookingCreateSuccess: false,
                bookingDeleteSuccess: false,
            }
        },
        props: ['prop_user'],
        methods: {
            getBookings() {
                axios.get('/bookings/get/user/' + this.prop_user.userid).then(
                    (response) => {
                        this.user = response.data;
                    },
                    (error) => {

                    },
                );
            },
            getServices() {
                axios.get('/services/all/').then(
                    (response) => {
                        this.services = response.data;
                    },
                    (error) => {

                    },
                );
            },
            createBooking() {
                axios.post('/bookings/create', this.booking).then(
                    (response) => {
                        this.bookingCreateSuccess=true;
                        this.getBookings(); //refresh bookings
                        this.getServices(); //refresh services
                    },
                    (error) => {

                    },
                );
            },
            deleteBooking() {
                if (!this.deleteBookingId) return;

                axios.post('/bookings/delete/' + this.deleteBookingId).then(
                    (response) => {
                        this.deleteBookingId = null; //reset the select booking
                        this.bookingDeleteSuccess = true;
                        this.getBookings(); //refresh bookings
                        this.getServices(); //refresh services
                    },
                    (error) => {

                    },
                );
            }
        },
        mounted() {
            this.getBookings();
            this.getServices();
            this.booking.userid = this.prop_user.userid;

            setInterval(
              ()=>{
                this.getBookings();
              }, 2000
            );
        }
    }
</script>

<style scoped>

</style>
