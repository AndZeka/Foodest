<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdmin() && role=='admin'">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div>
              <h3 class="card-title pt-2">Restaurants Table</h3>
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
                  <th></th>
                  <th>ID</th>
                  <th>User_ID</th>
                  <th>Name</th>
                  <th>Slug</th>
                  <th>Address</th>          
                  <th>Postcode</th>
                  <th>Registered At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="myrestaurant in myrestaurants.data" :key="myrestaurant.id">
                  <td><img class="img-circle img-profile" :src="myrestaurant.photo" alt="User Avatar" style="margin-top:0 !important; height: 25px !important"></td>
                  <td>{{ myrestaurant.id }}</td>
                  <td>{{ myrestaurant.user_id }}</td>
                  <td>{{ myrestaurant.name }}</td>
                  <td>{{ myrestaurant.slug }}</td>
                  <td>{{ myrestaurant.address }}</td>
                  <td>{{ myrestaurant.postcode }}</td>
                  <td>{{ myrestaurant.created_at | myDate }}</td>
                  <td>
                    <a href="#" @click="editModal(myrestaurant)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteRestaurant(myrestaurant.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
              <pagination :data="myrestaurants" @pagination-change-page="getResults"></pagination>
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
                Add New Restaurant
              </h5>
              <h5 v-show="editmode" class="modal-title" id="addNewLabel">
                Update Restaurant's Info
              </h5>
              <button type="button" class="close" @click="hideModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="editmode ? updateRestaurant() : createRestaurant()">
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
                    v-model="form.slug"
                    type="text"
                    value=""
                    name="slug"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('slug') }"
                    placeholder="Slug"
                  />
                  <has-error :form="form" field="slug"></has-error>
                </div>
                <div class="form-group">
                  <textarea
                    v-model="form.address"
                    type="text"
                    name="address"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('address') }"
                    placeholder="Address"
                  ></textarea>
                  <has-error :form="form" field="address"></has-error>
                </div>
                <div class="form-group">
                  <input
                    v-model="form.postcode"
                    type="text"
                    name="postcode"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('postcode') }"
                    placeholder="Postcode"
                  />
                  <has-error :form="form" field="postcode"></has-error>
                </div>
                <div class="form-group">
                  <input
                    type="file"
                    name="photo"
                    @change="updatePhoto"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('photo') }"
                  />
                  <has-error :form="form" field="photo"></has-error>
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
    <div class="row mt-5" v-if="$gate.isRestaurant() && role=='restaurant'">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div>
              <h3 class="card-title pt-2">Restaurants Table</h3>
            </div>
            <div class="d-flex flex-row align-items-center">
              <div class="card-tools">
                <button v-show="hideBtn" class="btn btn-success text-white" @click="newModal" >
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
                  <th></th>
                  <th>ID</th>
                  <th>User_ID</th>
                  <th>Name</th>
                  <th>Slug</th>
                  <th>Address</th>          
                  <th>Postcode</th>
                  <th>Registered At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="myrestaurant in myrestaurants.data" :key="myrestaurant.id">
                  <td><img class="img-circle img-profile" :src="myrestaurant.photo" alt="User Avatar" style="margin-top:0 !important; height: 25px !important"></td>
                  <td>{{ myrestaurant.id }}</td>
                  <td>{{ myrestaurant.user_id }}</td>
                  <td>{{ myrestaurant.name }}</td>
                  <td>{{ myrestaurant.slug }}</td>
                  <td>{{ myrestaurant.address }}</td>
                  <td>{{ myrestaurant.postcode }}</td>
                  <td>{{ myrestaurant.created_at | myDate }}</td>
                  <td>
                    <a href="#" @click="editModal(myrestaurant)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteRestaurant(myrestaurant.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
              <pagination :data="myrestaurants" @pagination-change-page="getResults"></pagination>
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
                Add New Restaurant
              </h5>
              <h5 v-show="editmode" class="modal-title" id="addNewLabel">
                Update Restaurant's Info
              </h5>
              <button type="button" class="close" @click="hideModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="editmode ? updateRestaurant() : createRestaurant()">
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
                    type="text"                  
                    v-model="form.slug"
                    name="slug"                    
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('slug') }"
                    placeholder="Slug"
                  />
                  <has-error :form="form" field="slug"></has-error>
                </div>
                <div class="form-group">
                  <textarea
                    v-model="form.address"
                    type="text"
                    name="address"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('address') }"
                    placeholder="Address"
                  ></textarea>
                  <has-error :form="form" field="address"></has-error>
                </div>
                <div class="form-group">
                  <input
                    v-model="form.postcode"
                    type="text"
                    name="postcode"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('postcode') }"
                    placeholder="Postcode"
                  />
                  <has-error :form="form" field="postcode"></has-error>
                </div>
                <div class="form-group">
                  <input
                    type="file"
                    name="photo"
                    @change="updatePhoto"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('photo') }"
                  />
                  <has-error :form="form" field="photo"></has-error>
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
      role: '',
      hideBtn: true,
      editmode: false,
      myrestaurants: {},
      form: new Form({
        id: "",
        user_id: "1",
        name: "",
        slug: "",
        address: "",
        postcode: "",
        photo: "",
      }),
      search:''
    };
  },
  methods: {
    searchit:_.debounce(()=>{
      Fire.$emit('searching')
    },100),
    getResults(page = 1) {
      axios.get('api/myrestaurants?page=' + page)
      .then(response => {
          this.myrestaurants = response.data;            
      });
    },
    editModal(myrestaurant) {
      this.editmode = true;
      this.form.reset()
      $("#addNew").modal("show");
      this.form.fill(myrestaurant);
    },
    newModal() {
      this.editmode = false;
      this.showModal();
      this.form.reset()
      $("#addNew").modal("show");
    },
    deleteRestaurant(id) {
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
              .delete("api/myrestaurants/" + id)
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
    loadRestaurants() {
        if (this.$gate.isAdminOrRestaurant()) {
            axios.get("api/myrestaurants").then(({ data }) => (this.myrestaurants = data));
        }
    },
    updateRestaurant() {
      this.$Progress.start();
      this.form
        .put("api/myrestaurants/" + this.form.id)
        .then(() => {
          this.hideModal();
          toast.fire({
            icon: "success",
            title: "Restaurant updated successfully",
          });
          this.$Progress.finish();
          Fire.$emit("AfterCreate");
        })
        .catch(() => {
          console.log("ERRRR:: ",error.response.data);
          this.$Progress.fail();
        });
    },
    createRestaurant() {
      this.$Progress.start();
      this.form
        .post("api/myrestaurants")
        .then(() => {
          Fire.$emit("AfterCreate");

          this.hideModal();

          toast.fire({
            icon: "success",
            title: "Restaurant created successfully",
          });
          this.$Progress.finish();
          if(this.role == 'restaurant'){
            this.hideBtn = false;
          }
        })
        .catch(error => {
          console.log("ERRRR:: ",error.response.data);
          this.$Progress.fail();
        });
    },
    getPhoto(){
      let photo = "imgs/restaurant/default.png";
      if(this.form.photo){
        if(this.form.photo.length > 200){
          photo = this.form.photo;
        }else{
          photo = "imgs/restaurant/"+this.form.photo ;
        }
      }
      return photo;
      // let photo = (this.form.photo.length > 200) ? this.form.photo : "imgs/profile/"+this.form.photo ;
      // return photo;
    },
    updatePhoto(e){
      let file = e.target.files[0];
      // console.log(file);
      let reader = new FileReader();
      if(file['size'] < 2111775){
        reader.onloadend = (file)=>{
          // console.log('Result', reader.result)
          this.form.photo = reader.result;
        }
        reader.readAsDataURL(file);
      }else{
        swal.fire(
            'Failed!',
            'You are uploading a large file',
            'error'
        )
      }
    },
    searchInLowerCase() {
      console.log(this.name);
      return this.slug.toLowerCase().replace(/\s+/g,'-');
    }
  },
  components:{
    'not-found':NotFound
  },
  created() {
    Fire.$on("searching", () => {
      let query = this.search;
      axios.get('api/findRestaurant?q='+query)
      .then((data)=>{
        this.myrestaurants=data.data
      })
      .catch(()=>{
        console.log("ERRRR:: ",error.response.data);
      })
    });
    this.loadRestaurants();
    Fire.$on("AfterCreate", () => {
      this.loadRestaurants();
    });
    axios.get('api/role')
      .then((data)=>{
        this.role = data.data;
      })
      .catch(()=>{
        console.log("ERRRR:: ",error.response.data);
      })
      axios.get('api/restaurantCount')
      .then((data)=>{
        if(data.data >= 1 && this.role == 'restaurant')
          this.hideBtn = true;
      })
      .catch(()=>{
        console.log("ERRRR:: ",error.response.data);
      })
    // setInterval(()=>this.loadRestaurants(),3000);
  },
  mounted: function () {
    axios.get('api/restaurantCount')
      .then((data)=>{
        if(data.data >= 1 && this.role == 'restaurant')
          this.hideBtn = false;
      })
      .catch(()=>{
        console.log("ERRRR:: ",error.response.data);
      })
  },
};
</script>

<style scoped>
.hideBtn{
  display: none;
}
</style>