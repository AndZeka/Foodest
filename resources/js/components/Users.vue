<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdminOrRestaurant() ">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div>
              <h3 class="card-title pt-2">Users Table</h3>
            </div>
            <div class="d-flex flex-row align-items-center">
              <div class="card-tools mr-3">
                <div class="input-group input-group-sm" style="width: 150px">
                  <input
                    type="search"
                    name="table_search"
                    @keyup="searchit"
                    v-model="search"
                    class="form-control float-right"
                    placeholder="Search"
                  />
                  <div class="input-group-append">
                    <button @click="searchit" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="card-tools">
                <button class="btn btn-success text-white" @click="newModal">
                  Add New <i class="fas fa-user-plus white"></i>
                </button>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Registered At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users.data" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.type | upText }}</td>
                  <td>{{ user.created_at | myDate }}</td>
                  <td>
                    <a href="#" @click="editModal(user)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteUser(user.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
              <pagination :data="users" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- Modal -->
      <div
        class="modal fade"
        id="addNew"
        tabindex="-1"
        role="dialog"
        aria-labelledby="addNewLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 v-show="!editmode" class="modal-title" id="addNewLabel">
                Add New User
              </h5>
              <h5 v-show="editmode" class="modal-title" id="addNewLabel">
                Update User's Info
              </h5>
              <button type="button" class="close" @click="hideModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="editmode ? updateUser() : createUser()">
              <div class="modal-body">
                <div class="form-group">
                  <input
                    v-model="form.name"
                    type="text"
                    name="name"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('name') }"
                    placeholder="Name"
                  />
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <input
                    v-model="form.email"
                    type="text"
                    name="email"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('email') }"
                    placeholder="Email Address"
                  />
                  <has-error :form="form" field="email"></has-error>
                </div>
                <div class="form-group">
                  <textarea
                    v-model="form.bio"
                    type="text"
                    name="bio"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('bio') }"
                    placeholder="Short bio (optional)"
                  ></textarea>
                  <has-error :form="form" field="bio"></has-error>
                </div>
                <div class="form-group">
                  <select
                    name="type"
                    v-model="form.type"
                    id="type"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('type') }"
                  >
                    <option value="">Select User Role</option>
                    <option value="admin">Admin</option>
                    <option value="restaurant">Restaurant</option>
                    <option value="user">Standard User</option>
                  </select>
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <input
                    v-model="form.password"
                    type="password"
                    name="password"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('password') }"
                    placeholder="Password"
                  />
                  <has-error :form="form" field="password"></has-error>
                </div>
                
              </div>
              <input type="hidden">
              <input type="hidden" v-model="form.photo" name="photo">
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" @click="hideModal">
                  Close
                </button>
                <button
                  v-show="!editmode"
                  type="submit"
                  class="btn btn-success"
                >
                  Create
                </button>
                <button v-show="editmode" type="submit" class="btn btn-primary">
                  Update
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>    
    </div>
    <div v-if="!$gate.isAdminOrRestaurant()">
        <not-found></not-found>
    </div>
  </div>
</template>

<script>
import NotFound from './NotFound'
export default {
  data() {
    return {
      editmode: false,
      users: {},
      form: new Form({
        id: "",
        name: "",
        email: "",
        password: "",
        type: "",
        bio: "",
        photo: "default.png",
      }),
      search:''
    };
  },
  methods: {
    searchit:_.debounce(()=>{
      Fire.$emit('searching')
    },100),
    getResults(page = 1) {
        axios.get('api/user?page=' + page)
        .then(response => {
            this.users = response.data;
        });
    },
    updateUser() {
      this.$Progress.start();
      this.form
        .put("api/user/" + this.form.id)
        .then(() => {
          this.hideModal();
          toast.fire({
            icon: "success",
            title: "User updated successfully",
          });
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(user) {
      this.editmode = true;
      this.form.reset()
      $("#addNew").modal("show");
      this.form.fill(user);
    },
    newModal() {
      this.editmode = false;
      this.showModal();
      this.form.reset()
      $("#addNew").modal("show");
    },
    deleteUser(id) {
      swal
        .fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            this.form
              .delete("api/user/" + id)
              .then(() => {
                swal.fire("Deleted!", "Your file has been deleted.", "success");
                Fire.$emit("AfterCreate");
              })
              .catch(() => {
                swal.fire("Failed!", "Something went wrong.", "warning");
              });
          }
        });
    },
    showModal() {
      $("#addNew").modal("show");
    },
    hideModal() {
      $("#addNew").modal("hide");
    },
    loadUsers() {
      if (this.$gate.isAdminOrRestaurant()) {
        axios.get("api/user").then(({ data }) => (this.users = data));
      }
    },
    createUser() {
      this.$Progress.start();
      this.form
        .post("api/user")
        .then(() => {
          Fire.$emit("AfterCreate");

          this.hideModal();

          toast.fire({
            icon: "success",
            title: "User created successfully",
          });
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
  },
  components:{
    'not-found':NotFound
    },
  created() {
    Fire.$on("searching", () => {
      let query = this.search;
      axios.get('api/findUser?q='+query)
      .then((data)=>{
        this.users=data.data
      })
      .catch(()=>{

      })
    });
    this.loadUsers();
    Fire.$on("AfterCreate", () => {
      this.loadUsers();
    });
    // setInterval(()=>this.loadUsers(),3000);
  },
};
</script>