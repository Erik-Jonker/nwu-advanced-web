<template>
  <div>
    <div class="accordion" id="accordion" v-if="profiles.length>0">

      <div class="card" v-for="(user,idx) in profiles">
        <div class="card-header" :id="'#collapse'+user.userid">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed float-right float-sm-left"
                    type="button"
                    data-toggle="collapse"
                    :data-target="'#collapse'+user.userid"
                    aria-expanded="false"
                    :aria-controls="'collapse'+user.userid"
            >
              {{user.name}}
            </button>
          </h5>
        </div>

        <div :id="'collapse'+user.userid" class="collapse" :aria-labelledby="'heading'+user.userid" data-parent="#accordion">
          <div class="card-body">
            <label for="">Name and Surname</label>
            <input type="text" class="form-control" v-model="profiles[idx].name"><br>

            <label for="">Email</label>
            <input type="text" class="form-control" v-model="profiles[idx].email"><br>

            <label for="">Cell</label>
            <input type="text" class="form-control" v-model="profiles[idx].cell"><br>

            <label for="">Role</label>
            <select v-model="profiles[idx].role" class="form-control">
              <option value="-" select disabled>Please select</option>
              <option value="admin">Admin</option>
              <option value="customer">Customer</option>
            </select>
            <br>

            <label for="">Gender</label>
            <select v-model="profiles[idx].gender" class="form-control">
              <option value="-" select disabled>Please select</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
            <br>

            <label for="">Password</label>
            <input type="text" placeholder="Only if it changed" class="form-control" v-model="profiles[idx].updatePassword"><br>

            <button class="btn btn-outline-primary float-right ml-3" @click="updateUser(idx)">Save</button>
            <br>
            <br>
            <br>
            <div class="alert alert-success" v-if="alert.success[idx]">
              <strong>Success!</strong>
              Successfully saved changes
            </div>

            <div class="alert alert-danger" v-if="alert.error[idx]">
              <strong>Error!</strong>
              An error has occured
            </div>
          </div>
        </div>
      </div>

    </div>
    <div v-else>
      <div class="alert alert-info" role="alert">No users found</div>
    </div>

    <br>
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
        name: "manage-profiles",
        data(){
            return {
                profiles:[],
                alert: {
                  success: [],
                  error: [],
                }
            }
        },
        methods:{
            getAllProfiles()
            {
                axios.get('/profiles/all').then(
                    (response)=>{
                        this.profiles = response.data;
                    },
                    (error)=>{

                    },
                );
            },
            updateUser(index=null)
            {
                if (this.profiles.length < 1 || index==null) return;

                axios.post('/profiles/update/'+this.profiles[index].userid, this.profiles[index]).then(
                    (response)=>{
                        this.profiles[index]=response.data;
                        this.alert.success[index] = true;
                        setTimeout(()=>{
                          this.alert.success[index] = false;
                        },3000);
                    },
                    (error)=>{
                      this.alert.error[index] = true;
                      setTimeout(()=>{
                        this.alert.error[index] = false;
                      },3000);
                    },
                );
            }
        },
        mounted(){
            this.getAllProfiles();
        }
    }
</script>

<style scoped>

</style>
