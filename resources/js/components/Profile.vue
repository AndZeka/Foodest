<template>
  <div class="container">
  <div class="row">
    <div class="col-md-12 mt-3">
      <div class="card card-widget widget-user">
        <!-- Add the bg color to the header using any of the bg-* classes -->
        <div class="widget-user-header text-white" style="background: url('/imgs/cover.png') center center;">
          <h3 class="widget-user-username text-right">{{ this.form.name }}</h3>
          <h5 class="widget-user-desc text-right">{{ this.form.bio }}</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle img-profile" :src="getProfilePhoto()" alt="User Avatar">
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">3,200</h5>
                <span class="description-text">SALES</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4 border-right">
              <div class="description-block">
                <h5 class="description-header">13,000</h5>
                <span class="description-text">FOLLOWERS</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
            <div class="col-sm-4">
              <div class="description-block">
                <h5 class="description-header">35</h5>
                <span class="description-text">PRODUCTS</span>
              </div>
              <!-- /.description-block -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane" id="activity">
              <!-- Post -->
              <div class="post">
                <div class="user-block">
                  <img class="img-circle img-bordered-sm" src="" alt="user image">
                  <span class="username">
                    <a href="#">Jonathan Burke Jr.</a>
                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                  </span>
                  <span class="description">Shared publicly - 7:30 PM today</span>
                </div>
                <!-- /.user-block -->
                <p>
                  Lorem ipsum represents a long-held tradition for designers,
                  typographers and the like. Some people hate it and argue for
                  its demise, but others ignore the hate as they create awesome
                  tools to help create filler text for everyone from bacon lovers
                  to Charlie Sheen fans.
                </p>

                <p>
                  <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                  <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                  <span class="float-right">
                    <a href="#" class="link-black text-sm">
                      <i class="far fa-comments mr-1"></i> Comments (5)
                    </a>
                  </span>
                </p>

                <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
              </div>
              <!-- /.post -->

              <!-- Post -->
              <div class="post clearfix">
                <div class="user-block">
                  <img class="img-circle img-bordered-sm" src="" alt="User Image">
                  <span class="username">
                    <a href="#">Sarah Ross</a>
                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                  </span>
                  <span class="description">Sent you a message - 3 days ago</span>
                </div>
                <!-- /.user-block -->
                <p>
                  Lorem ipsum represents a long-held tradition for designers,
                  typographers and the like. Some people hate it and argue for
                  its demise, but others ignore the hate as they create awesome
                  tools to help create filler text for everyone from bacon lovers
                  to Charlie Sheen fans.
                </p>

                <form class="form-horizontal">
                  <div class="input-group input-group-sm mb-0">
                    <input class="form-control form-control-sm" placeholder="Response">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-danger">Send</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.post -->

              <!-- Post -->
              <div class="post">
                <div class="user-block">
                  <img class="img-circle img-bordered-sm" src="" alt="User Image">
                  <span class="username">
                    <a href="#">Adam Jones</a>
                    <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                  </span>
                  <span class="description">Posted 5 photos - 5 days ago</span>
                </div>
                <!-- /.user-block -->
                <div class="row mb-3">
                  <div class="col-sm-6">
                    <img class="img-fluid" src="" alt="Photo">
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-6">
                    <div class="row">
                      <div class="col-sm-6">
                        <img class="img-fluid mb-3" src="" alt="Photo">
                        <img class="img-fluid" src="" alt="Photo">
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-6">
                        <img class="img-fluid mb-3" src="" alt="Photo">
                        <img class="img-fluid" src="" alt="Photo">
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <p>
                  <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                  <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                  <span class="float-right">
                    <a href="#" class="link-black text-sm">
                      <i class="far fa-comments mr-1"></i> Comments (5)
                    </a>
                  </span>
                </p>

                <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
              </div>
              <!-- /.post -->
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane active" id="settings">
              <form class="form-horizontal">
                <div class="form-group row">
                  <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm12">
                    <input type="text" v-model="form.name" class="form-control" id="inputName" name="name" placeholder="Name" :class="{'is-invalid':form.errors.has('name')}">
                     <has-error :form="form" field="name"></has-error>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-12">
                    <input type="email" v-model="form.email" class="form-control" name="email" id="inputEmail" placeholder="Email" :class="{'is-invalid':form.errors.has('email')}">
                     <has-error :form="form" field="email"></has-error>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputName2" class="col-sm-2 col-form-label">Experience</label>
                  <div class="col-sm-12">
                    <textarea class="form-control" v-model="form.bio" name="bio" id="inputExperience" placeholder="Experience" :class="{'is-invalid':form.errors.has('bio')}"></textarea>
                    <has-error :form="form" field="bio"></has-error>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="photo" class="col-sm-2 col-form-label">Profile Photo</label>
                  <div class="col-sm-12">
                    <input type="file" @change="updateProfile" name="photo" class="form-input">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-sm-12 col-form-label">Passport (leave empty if not changing)</label>
                  <div class="col-sm-12">
                    <input type="password" v-model="form.password" name="password" class="form-control" id="password" placeholder="Password" :class="{'is-invalid':form.errors.has('password')}">
                     <has-error :form="form" field="password"></has-error>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-12">
                    <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Update</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
    </div>
  </div>
  </div>
</template>

<style scoped>
  .widget-user-header{
    background-size: cover !important;
    height: 250px;
  }
  .widget-user .card-footer{
    padding: 0;
  }
  #inputExperience{
    border-color: #6b7280;
  }

</style>

<script>
  export default {
    data(){
      return{
        form: new Form({
                'id':'',
                'name':'',
                'email':'',
                'password':'',
                'type':'',
                'bio':'',
                'photo':'',
            }) 
      }
    },

    methods:{
      getProfilePhoto(){
        let photo = "imgs/profile/default.png";
        if(this.form.photo){
          if(this.form.photo.length > 200){
            photo = this.form.photo;
          }else{
            photo = "imgs/profile/"+this.form.photo ;
          }
        }
        return photo;
        // let photo = (this.form.photo.length > 200) ? this.form.photo : "imgs/profile/"+this.form.photo ;
        // return photo;
      },
      updateInfo(){
        this.$Progress.start();
        this.form.put('api/profile/')
        .then(()=>{
          toast.fire({
              icon: 'success',
              title: 'User info updated successfully'
          })
          this.$Progress.finish();
          // Fire.$emit('AfterCreate');
        })
        .catch(()=>{
          this.$Progress.fail();
          
        });
      },
      updateProfile(e){
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
      }
    },

    mounted() {
    },

    created(){
      axios.get("api/profile")
      .then(({ data })=>(this.form.fill(data)));
    }
  };
</script>