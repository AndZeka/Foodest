<template>
  <div class="submit-form">
    <h2 class="contactUs-txt">Contact us!</h2>
    <div class="contact-form" v-if="!submitted">
      <div class="form-group">
        <label for="name">Name:</label>
        <input
          type="text"
          class="form-control"
          id="name"
          required
          v-model="email.name"
          name="name"
        />
      </div>

      <div class="form-group">
        <label for="subject">Subject:</label>
        <input
          class="form-control"
          id="subject"
          required
          v-model="email.subject"
          name="subject"
        />
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input
          class="form-control"
          id="email"
          required
          v-model="email.email"
          name="email"
        />
      </div>
      <div class="form-group">
        <label for="message">Message:</label>
        <textarea rows="4" cols="2"
          class="form-control"
          id="message"
          required
          v-model="email.message"
          name="message"
        />
      </div>

      <button @click="saveEmail" class="btn btn-success">Submit</button>
    </div>

    <div class="btn-group" v-else>
      <h4>You submitted successfully!</h4>
    </div>
  </div>
</template>

<script>
import EmailDataService from "../services/EmailDataService.js";

export default {
  name: "add-email",
  data() {
    return {
      email: {
        id: null,
        name: "",
        subject: "",
        email:"",
        message: ""
      },
      submitted: false
    };
  },
  methods: {
    saveEmail() {
      var data = {
        name: this.email.name,
        subject: this.email.subject,
        email: this.email.email,
        message: this.email.message
      };

      EmailDataService.create(data)
        .then(response => {
          this.email.id = response.data.id;
          console.log(response.data);
          this.submitted = true;
        })
        .catch(e => {
          console.log(e);
        });
    },
    
    newEmail() {
      this.submitted = false;
      this.email = {};
    }
  }
};
</script>

<style>
.submit-form {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  max-width: 800px;
  height: 600px;
  padding: 20px;
  margin: auto;
  background: linear-gradient(#9ffd96, #66db93);
  opacity: 0.8;
  border-radius: 5px;
  font-size: 20px;
}
.contact-form{
  width: 500px;
  height: 400px;
}

.btn-success{
  margin: 3% 45% !important;
}
label{
  margin-bottom:3px;
}
.contactUs-txt{
  margin-bottom: 20px;
}
.btn-group{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
</style>