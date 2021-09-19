<template>
 <div class="container">
   <div class="row mt-5" v-if="$gate.isAdmin()">
     <div class="col-md-12">
       <div class="card">
         <div class="card-header d-flex justify-content-between">
            <div>
              <h3 class="card-title pt-2">Emails List</h3>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Subject</th>
                  <th>Email</th>
                  <th>Message</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(email, index) in emails" :key="index" @click="setActiveEmail(email, index)" :class="{ active: index == currentIndex }">
                  <td>{{ email.name }}</td>
                  <td>{{ email.subject }}</td>
                  <td>{{ email.email }}</td>
                  <td>{{ email.message }} $</td>
                </tr>
              </tbody>
            </table>
          </div>
       </div>   
     </div>  
   </div>
   <div v-if="!$gate.isAdmin()">
        <not-found></not-found>
    </div>
 </div>
</template>

<script>
import EmailDataService from "../services/EmailDataService";

export default {
  name: "emails-list",
  data() {
    return {
      emails: [],
      currentEmail: null,
      currentIndex: -1,
      name: ""
    };
  },
  methods: {
    retrieveEmails() {
      EmailDataService.getAll()
        .then(response => {
          this.emails = response.data;
          console.log(response.data);
        })
        .catch(e => {
          console.log(e);
        });
    },

    refreshList() {
      this.retrieveEmails();
      this.currentEmail = null;
      this.currentIndex = -1;
    },

    setActiveEmail(email, index) {
      this.currentEmail = email;
      this.currentIndex = index;
    },

    searchName() {
      EmailDataService.findByName(this.name)
        .then(response => {
          this.emails = response.data;
          console.log(response.data);
        })
        .catch(e => {
          console.log(e);
        });
    }
  },
  mounted() {
    this.retrieveEmails();
  }
};
</script>

<style>
.list {
  text-align: left;
  max-width: 750px;
  margin: auto;
}
</style>