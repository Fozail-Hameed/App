<template>
    <div class="container">
        <!-- <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users</div>
                    <router-view></router-view>
                    <div class="card-body">
                        I'm an User component.
                    </div>
                </div>
            </div>
        </div> -->
        <div class="row mt-5 justify-content-center">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title" style="color: blue;"><b>Users Table</b></h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-success" @click="newModal">Add New User <i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Joining Date</th>
                      <!-- <th>Info</th> -->
                      <th>Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for=" user in users" :key="user.id">
                      <td>{{ user.id }}</td>
                      <td>{{ user.name  }}</td>
                      <td>{{ user.email }}</td>
                      <td>{{ user.type  }}</td>
                      <td>{{ user.created_at | myDate }}</td>
                      <!-- <td>{{ user.bio }}</td> -->
                      <td>
                          <a href="#" @click="editModel(user)" class="fa fa-edit blue">
                              <!-- <i class="fa fa-edit"></i> -->
                          </a>
                          <a @click="deleteUser(user.id)" href="#" class="fas fa-trash-alt red" style="margin-left: 5px;">
                              <!-- <i class="fa fa-edit"></i> -->
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- Modal -->
            <div class="modal fade" id="addnew" tabindex="-1" role="dialog" aria-labelledby="addnewLabel" aria-hidden="true">
              <div class="modal-dialog " role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title blue" v-show="!editMode" id="addnewLabel"><b>Add New</b></h5>
                    <h5 class="modal-title blue" v-show="editMode" id="addnewLabel"><b>Update User</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                <form @submit.prevent="editMode ? updateUser() : CreateUser()">
                  <div class="modal-body">
                    <div class="form-group">
                      <input v-model="form.name" type="text" name="name"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Name">
                      <has-error :form="form" field="name"></has-error>
                    </div>

                    <div class="form-group">
                      <input v-model="form.email" type="text" name="email"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email">
                      <has-error :form="form" field="email"></has-error>
                    </div>

                    <div class="form-group">
                      <input v-model="form.password" type="password" name="password"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                      <has-error :form="form" field="password"></has-error>
                    </div>

                    <div class="form-group">
                      <!-- <input v-model="form.bio" type="text" name="bio"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }" placeholder="Short Bio for User (Optional)"> -->
                        <textarea v-model="form.bio" name="bio" class="form-control" rows="3" placeholder="Short Bio for User (Optional)" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                      <has-error :form="form" field="bio"></has-error>
                    </div>

                    <div class="form-group">
                      <select v-model="form.type" name="type"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                        <option value="">Select User Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Author">Author</option>
                        <option value="User">Standard User</option>
                    </select>
                      <has-error :form="form" field="password"></has-error>
                    </div>


                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                    <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Edit Model -->
           <!--  Edit Model End here -->
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                editMode: false,
                users : {},
                form: new Form({
                id:'',
                name: '',
                email: '',
                password: '',
                type: '',
                bio: '',
                photo: ''
                })
            }
        },
        methods: {
            updateUser(){
                this.$Progress.start();
                // console.log("edit");
                this.form.put('api/user/'+this.form.id)
                .then(() =>{
                    Swal.fire(
                      'Updated!',
                      'User has been updated.',
                      'success'
                    )
                    $('#addnew').modal('hide')
                    // this.$Progress.finish();
                })
                .catch(() =>{
                    this.$Progress.fail();
                });
            },
            editModel(user){
                this.editMode = true;
                //jo cache sai data pick krta tha ab woh nhe kry ga
                this.form.reset();
                $('#addnew').modal('show');
                this.form.fill(user);
            },
            newModal(){
                //jo cache sai data pick krta tha ab woh nhe kry ga
                this.editMode = false;
                this.form.reset();
                $('#addnew').modal('show');
            },
            CreateUser(){
                this.$Progress.start();
                //blow line will add new user blow one is url wich go to controller
                this.form.post('api/user');
                $('#addnew').modal('hide')
                Toast.fire({
                  icon: 'success',
                  title: 'User Added successfully'
                });
                this.$Progress.finish();
                // this.$router.go()
            },
            loadUsers(){
                axios.get("api/user").then(({data}) => (this.users = data.data));
            },
            deleteUser(id){
                Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    this.form.delete('api/user/'+id).then(() =>{
                        if (result.value) {
                    Swal.fire(
                      'Deleted!',
                      'User has been deleted.',
                      'success'
                    )
                    // this.$router.go()
                  }
              }).catch(() => {
                swal("Failed", "There was something wrong.","warning");
              });

                })
        },
        },
        created() {
            this.loadUsers();
        }
    }
</script>
