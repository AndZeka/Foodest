<template>
  <div class="container">
    <div class="row mt-5" v-if="$gate.isAdminOrRestaurant() || $gate.isUser()">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <div>
              <h3 class="card-title pt-2">Orders History</h3>
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
    </div>
    <div v-if="!$gate.isAdminOrRestaurant() && !$gate.isUser()">
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
        axios.get('api/myorders?page=' + page)
        .then(response => {
            this.orders = response.data;            
        });
    },
    loadorders() {
        if (this.$gate.isAdminOrRestaurant() || this.$gate.isUser()) {
            axios.get("api/myorders").then(({ data }) => (this.orders = data));
        }
    },
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