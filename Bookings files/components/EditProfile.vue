<template>
  <div>

        <!-- If successfully saved changes -->
        <div v-if="alert.success">
          <strong>Success!</strong>
          Successfully saved changes
        </div>

        <!-- If error during save changes -->
        <div v-if="alert.error">
          <strong>Error!</strong>
          An error has occured
        </div>

        <!-- Display the details of the user inside inputs -->
        <div v-if="user && prop_user">
          <label for="">Name and Surname</label>
          <input type="text" v-model="user.name"><br>

          <label for="">Email</label>
          <input type="text" v-model="user.email"><br>

          <label for="">Cell</label>
          <input type="text" v-model="user.cell"><br>

          <label for="">Password</label>
          <input type="password" placeholder="Only if it changed..." v-model="user.updatePassword"><br>

          <label for="">Gender</label>
          <select v-model="user.gender">
            <option value="-" selected disabled>Please select</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
          <br>

          <button @click="updateUser()">Save</button>
          <button @click="reset()">Reset</button>
        </div>

        <!-- There is no user to edit -->
        <div v-else>
          <div>User not found</div>
        </div>


  </div>
</template>

<script>
    export default {
        name: "edit-profile",
        props:['prop_user'],
        data(){
            return {
                user:null,
                alert: {
                  success: false,
                  error:false,
                }
            }
        },
        methods:{
            updateUser()
            {
                //There is no user, do not even try to save it
                if (!this.user) return;

                //If the original user is the same as the 'edited' user, it means nothing changed
                if(this.prop_user === this.user) {
                  this.alert
                  return;
                }

                //Send new details to server to update
                this.$http.patch('/profiles/update/'+this.user.userid, this.user).then(
                    (response)=>{

                        //Apply the updated changes to current user
                        this.user=response.body;

                        //Show the success message
                        this.alert.success = true;

                        //Hide the success message after 3 seconds
                        setTimeout(()=>{
                          this.alert.success = false;
                        },3000);
                    },
                    (error)=>{

                      //Show the error message
                      this.alert.error = true;

                      //Hide the error message after 3 seconds
                      setTimeout(()=>{
                        this.alert.error = false;
                      },3000);
                    },
                );
            },
            reset()
            {
                this.user=this.prop_user; //reset values
                this.$emit('cancelupdate'); //emit event so that if another component uses this component they can do something about it
            }
        },
        mounted(){
            //This ensures that 'this.user' does not refer to prop_user anymore by creating a new object
            //Pass by reference vs pass by value
            this.user = JSON.parse(JSON.stringify(this.prop_user));
        }
    }
</script>

<style scoped>

</style>
