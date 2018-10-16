<template>
  <div>

    <button data-toggle="modal" data-target="#createModal">New</button>
    <br><br>

      <p>Manage services:</p>

    <ul v-if="services.length > 0">
      <li v-for="service in services">
        <p>{{service.description}}</p>
        <button @click="deleteServiceId = service.serviceid; serviceDeleteSuccess=false;" data-toggle="modal" data-target="#deleteModal">Remove
        </button>
        <button @click="rename.serviceid = service.serviceid; serviceRenameSuccess=false"
                data-toggle="modal" data-target="#renameModal">Edit
        </button>
      </li>
    </ul>
    <template v-else>There are no services, please add one</template>

    <!-- Rename service modal-->
    <div class="modal fade" id="renameModal" tabindex="-1" role="dialog" aria-labelledby="renameModalLabel"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="renameModalLabel">Rename service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <template v-if="serviceRenameSuccess">
              <div class="alert alert-success">
                Successfully renamed service
              </div>
            </template>
            <template v-else>
              <label for="">Rename: </label>
              <input type="text" class="form-control" v-model="rename.description">
            </template>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    @click="rename.serviceid = null; serviceCreateSuccess=false;">
              Close
            </button>
            <button type="button" class="btn btn-primary"
                    :disabled="rename.serviceid == null || rename.description ==''"
                    @click="renameService()">
              Save changes
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Create service modal-->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createModalLabel">Create new service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="create.description = ''; serviceCreateSuccess=false">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <template v-if="serviceCreateSuccess">
              <div class="alert alert-success">
                Successfully created service
              </div>
            </template>
            <template v-else>
              <label for="">New service: </label>
              <input type="text" class="form-control" v-model="create.description">
            </template>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    @click="create.description = ''; serviceCreateSuccess=false">Close
            </button>
            <button type="button" class="btn btn-primary" :disabled="create.description ==''" @click="createService()">
              Create service
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete service modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Are you sure?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <template v-if="serviceDeleteSuccess">
              <div class="alert alert-success">
                Successfully deleted service
              </div>
            </template>
            <template v-else>
              Are you sure you want to delete this service?
            </template>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    @click="deleteServiceId=null; serviceDeleteSuccess=false;">Close
            </button>
            <button type="button" class="btn btn-danger" :disabled="!deleteServiceId" @click="deleteService()">Delete
              service
            </button>
          </div>
        </div>
      </div>
    </div>

    <br>
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
        name: "manage-services",
        data() {
            return {
                services: [],
                rename: {
                    description: '',
                    serviceid: null,
                },
                create: {
                    description: '',
                },
                deleteServiceId: null,
                serviceRenameSuccess: false,
                serviceCreateSuccess: false,
                serviceDeleteSuccess: false,
            }
        },
        methods: {
            getServices() {
                axios.get('/services/all/').then(
                    (response) => {
                        this.services = response.body;
                    },
                    (error) => {
                      //NB catch the error, display a popup saying an error occured?
                    },
                );
            },
            renameService() {
                if (!this.rename.serviceid) return;

                axios.post('/services/rename/' + this.rename.serviceid, {description: this.rename.description}).then(
                    (response) => {
                        this.rename.description = '';
                        this.serviceRenameSuccess = true;
                        this.getServices(); //refresh services
                    },
                    (error) => {
                      //NB catch the error, display a popup saying an error occured?
                    },
                );
            },
            createService() {
                axios.post('/services/create/', {description: this.create.description}).then(
                    (response) => {
                        this.create.description = '';
                        this.serviceCreateSuccess = true;
                        this.getServices(); //refresh services
                    },
                    (error) => {
                      //NB catch the error, display a popup saying an error occured?
                    },
                );
            },
            deleteService() {
                axios.delete('/services/delete/' + this.deleteServiceId).then(
                    (response) => {
                        this.deleteServiceId = null;
                        this.serviceDeleteSuccess = true;
                        this.getServices(); //refresh services
                    },
                    (error) => {
                      //NB catch the error, display a popup saying an error occured?
                    },
                );
            }

        },
        mounted() {
            this.getServices();
        }
    }
</script>

<style scoped>

</style>
