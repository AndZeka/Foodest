<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdminOrRestaurant()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div>
              <h3 class="card-title pt-2">{{ name }}'s Orders</h3>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Total Price</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="order in orders.data" :key="order.id">
                  <td>{{ order.id }}</td>
                  <td>{{ order.name }}</td>
                  <td>{{ order.qty }}</td>
                  <td>{{ order.price }} $</td>
                  <td>{{ order.created_at | myDate  }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
              <pagination :data="orders" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- Modal -->
      <!-- <div
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
              <h5 v-show="editmode" class="modal-title" id="addNewLabel">
                Update Order's Info
              </h5>
              <button type="button" class="close" @click="hideModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="editmode ? updateOrder() : createRestaurant()">
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
      </div>  -->
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
      orders: {},
      name:'',
      form: new Form({
        id: "",
        // product: "",
        qty: "",
        // price: "",
        // status: "",
      }),
      search:''
    };
  },
  methods: {
    searchit:_.debounce(()=>{
      Fire.$emit('searching')
    },100),
    getResults(page = 1) {
        axios.get('api/restaurantorders?page=' + page)
        .then(response => {
            this.orders = response.data;            
        });
    },
    loadorders() {
        if (this.$gate.isAdminOrRestaurant() || this.$gate.isUser()) {
            axios.get("api/restaurantorders").then(({ data }) => (this.orders = data));
        }
    },
  },
  mounted: function () {
    axios.get('api/findRestaurantName')
      .then((data)=>{        
          this.name = (Object.entries(data.data.data)[0][1]['name']);
      })
      .catch(()=>{
        console.log("ERRRR:: ",error.response.data);
      })
  },
  components:{
    'not-found':NotFound
    },
  created() {
    this.loadorders();
    Fire.$on("AfterCreate", () => {
      this.loadorders();
    });
    // setInterval(()=>this.loadorders(),3000);
  },
};
</script>