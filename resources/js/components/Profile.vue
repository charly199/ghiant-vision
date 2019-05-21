<style>
</style>


<template>
    <div>
      <div clas="col-lg-12">
        <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-black" style="background: url('./dist/img/photo1.jpg') center center; height: 300px;">
              <h3 class="widget-user-username">Elizabeth Pierce</h3>
              <h5 class="widget-user-desc">Web Designer</h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="" alt="User Avatar">
            </div>
            <div class="box-footer">
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

          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class=""><a href="#activity" data-toggle="tab" aria-expanded="false">Activités</a></li>
              <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Modifier Son profil</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="activity">
                <h1>voir un peu</h1>
              </div>

              <div class="tab-pane active" id="settings">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nom</label>

                    <div class="col-sm-10">
                      <input type="text" v-model="form.name" class="form-control" 
                      id="name" name="name" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" v-model="form.email" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="image" class="col-sm-2 control-label">Image de profil</label>

                    <div class="col-sm-10">
                      <input type="file" class="form-control" id="image" name="image">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="bio" class="col-sm-2 control-label">Experience</label>

                    <div class="col-sm-10">
                      <textarea class="form-control" id="bio" name="bio" placeholder="Experience"></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Mot de passe</label>

                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password" name="password" >
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Modifier</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
      </div>
    </div>
</template>

<script>
    export default {
        mounted() {
          axios.get('api/profile').then(({ data }) => {
            console.log(data);
          })
            
        },
        data(){
          return {
            form: new Form({
                id : '',
                name :  '',
                email : '',
                type : '',
                bio : '',
                photo: '',
            })
          }
        },

        created(){
          this.$Progress.start();
          axios.get('api/profile').then( ({ data }) => this.users = data.data );
        }
    }
</script>
