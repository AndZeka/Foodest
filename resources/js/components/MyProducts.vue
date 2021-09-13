<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdmin() && role == 'admin'">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div>
              <h3 class="card-title pt-2">Foods Table</h3>
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
                  <th>Restaurant_ID</th>
                  <th>Name</th>
                  <th>Slug</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Registered At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="myproduct in myproducts.data"
                  :key="myproduct.id"
                >
                  <td>
                    <img
                      class="img-circle img-profile"
                      :src="myproduct.photo"
                      alt="User Avatar"
                      style="margin-top: 0 !important; height: 50px !important"
                    />
                  </td>
                  <td class="align-middle">{{ myproduct.id }}</td>
                  <td class="align-middle text-center">{{ myproduct.restaurant_id }}</td>
                  <td class="align-middle">{{ myproduct.name }}</td>
                  <td class="align-middle">{{ myproduct.slug }}</td>
                  <td class="align-middle">{{ myproduct.description }}</td>
                  <td class="align-middle">{{ myproduct.price }}</td>
                  <td class="align-middle">{{ myproduct.created_at | myDate }}</td>
                  <td>
                    <a href="#" @click="editModal(myproduct)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteProduct(myproduct.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination
              :data="myproducts"
              @pagination-change-page="getResults"
            ></pagination>
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
                Add New Food
              </h5>
              <h5 v-show="editmode" class="modal-title" id="addNewLabel">
                Update Food's Info
              </h5>
              <button type="button" class="close" @click="hideModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form
              @submit.prevent="
                editmode ? updateProduct() : createProduct()
              "
            >
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
                    v-model="form.description"
                    type="text"
                    name="description"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('description') }"
                    placeholder="Description"
                  ></textarea>
                  <has-error :form="form" field="description"></has-error>
                </div>
                <div class="form-group">
                  <input
                    v-model="form.price"
                    type="text"
                    name="price"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('price') }"
                    placeholder="Price"
                  />
                  <has-error :form="form" field="price"></has-error>
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
              <input type="hidden" />
              <input type="hidden" v-model="form.photo" name="photo" />
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
    <div class="row mt-5" v-if="$gate.isRestaurant() && role == 'restaurant'">
      <div class="col-md-12">
        <div class="card" v-if="hideBtn">
          <div class="card-header d-flex justify-content-between">
            <div>
              <h3 class="card-title pt-2">Foods Table</h3>
            </div>
            <div class="d-flex flex-row align-items-center">
              <div class="card-tools">
                <button
                  class="btn btn-success text-white"
                  @click="newModal"                  
                >
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
                  <th>Restaurant_ID</th>
                  <th>Name</th>
                  <th>Slug</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Registered At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="myproduct in myproducts.data"
                  :key="myproduct.id"
                >
                  <td>
                    <img
                      class="img-circle img-profile"
                      :src="myproduct.photo"
                      alt="User Avatar"
                      style="margin-top: 0 !important; height: 50px !important"
                    />
                  </td>
                  <td class="align-middle">{{ myproduct.id }}</td>
                  <td class="align-middle text-center">{{ myproduct.restaurant_id }}</td>
                  <td class="align-middle">{{ myproduct.name }}</td>
                  <td class="align-middle">{{ myproduct.slug }}</td>
                  <td class="align-middle">{{ myproduct.description }}</td>
                  <td class="align-middle">{{ myproduct.price }}</td>
                  <td class="align-middle">{{ myproduct.created_at | myDate }}</td>
                  <td>
                    <a href="#" @click="editModal(myproduct)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteProduct(myproduct.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination
              :data="myproducts"
              @pagination-change-page="getResults"
            ></pagination>
          </div>
        </div>
        <div class="card" v-else-if="!hideBtn">
          <div class="card-header">
            <div>
              <h1 class="text-danger text-center font-weight-bold" style="font-size: 30px !important;"> You haven't opened any restaurant yet!</h1>
            </div>            
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
                Add New Food
              </h5>
              <h5 v-show="editmode" class="modal-title" id="addNewLabel">
                Update Food's Info
              </h5>
              <button type="button" class="close" @click="hideModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form
              @submit.prevent="
                editmode ? updateProduct() : createProduct()
              "
            >
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
                    v-model="form.description"
                    type="text"
                    name="description"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('description') }"
                    placeholder="Description"
                  ></textarea>
                  <has-error :form="form" field="description"></has-error>
                </div>
                <div class="form-group">
                  <input
                    v-model="form.price"
                    type="text"
                    name="price"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('price') }"
                    placeholder="Price"
                  />
                  <has-error :form="form" field="price"></has-error>
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
              <input type="hidden" />
              <input type="hidden" v-model="form.photo" name="photo" />
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
import NotFound from "./NotFound";

export default {
  data() {
    return {
      hideBtn: false,
      role: "",
      editmode: false,
      myproducts: {},
      form: new Form({
        id: "",
        restaurant_id: "1",
        name: "",
        slug: "",
        description: "",
        price: "",
        photo: "",
      }),
      search: "",
    };
  },
  methods: {
    searchit: _.debounce(() => {
      Fire.$emit("searching");
    }, 100),
    getResults(page = 1) {
      axios.get("api/myproducts?page=" + page).then((response) => {
        this.myproducts = response.data;
      });
    },
    editModal(myproduct) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(myproduct);
    },
    newModal() {
      this.editmode = false;
      this.showModal();
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteProduct(id) {
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
              .delete("api/myproducts/" + id)
              .then(() => {
                swal.fire("Deleted!", "Your food has been deleted.", "success");
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
    loadProducts() {
      if (this.$gate.isAdminOrRestaurant()) {
        if(this.hideBtn){
          axios
          .get("api/myproducts")
          .then(({ data }) => (this.myproducts = data));
        }        
      }
    },
    updateProduct() {
      this.$Progress.start();
      this.form
        .put("api/myproducts/" + this.form.id)
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
          console.log("ERRRR:: ", error.response.data);
          this.$Progress.fail();
        });
    },
    createProduct() {
      this.$Progress.start();
      this.form
        .post("api/myproducts")
        .then(() => {
          Fire.$emit("AfterCreate");

          this.hideModal();

          toast.fire({
            icon: "success",
            title: "Food created successfully",
          });
          this.$Progress.finish();
        })
        .catch((error) => {
          console.log("ERRRR:: ", error.response.data);
          this.$Progress.fail();
        });
    },
    updatePhoto(e) {
      let file = e.target.files[0];
      // console.log(file);
      let reader = new FileReader();
      if (file["size"] < 2111775) {
        reader.onloadend = (file) => {
          // console.log('Result', reader.result)
          this.form.photo = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        swal.fire("Failed!", "You are uploading a large file", "error");
      }
    },
  },
  created() {
    axios.get('api/restaurantCount')
      .then((data)=>{        
        if(data.data >= 1 && this.role == 'restaurant')
          this.hideBtn = true;
      })
      .catch(()=>{
        console.log("ERRRR:: ",error.response.data);
      })
    Fire.$on("searching", () => {
      let query = this.search;
      axios
        .get("api/findProduct?q=" + query)
        .then((data) => {
          this.myproducts = data.data;
        })
        .catch(() => {
          console.log("ERRRR:: ", error.response.data);
        });
    });
    this.loadProducts();
    Fire.$on("AfterCreate", () => {
      this.loadProducts();
    });
    axios
      .get("api/roleProduct")
      .then((data) => {
        this.role = data.data;
      })
      .catch(() => {
        console.log("ERRRR:: ", error.response.data);
      });

  },
  mounted: function () {
    axios.get('api/restaurantCount')
      .then((data)=>{        
        if(data.data >= 1 && this.role == 'restaurant')
          this.hideBtn = true;
      })
      .catch(()=>{
        console.log("ERRRR:: ",error.response.data);
      })
  },
  components: {
    "not-found": NotFound,
  },
};
</script>