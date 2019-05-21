<template>
    <div class="">
        <section class="content-header">
            <h1>
                Gestion des utilisateurs
                <small>Tous les utilisateurs sont présents ici</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Accuei</a></li>
                <li><a href="#">Tables</a></li>
            </ol>

            
        </section> 

        <div class="col-xs-12">
            
            <button type="button" class="btn btn-info" @click="newModal">
                Ajouter un utilisateur
              </button>


          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Responsive Hover Table</h3>

              <div class="box-tools">

                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Rechercher">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody>
                <tr>
                  <th>ID</th>
                  <th>Nom</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Ajouter le</th>
                  <th>Action</th>
                </tr>

                <tr v-for="user in users" :key="user.id" >
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td><span class="label label-success">{{ user.type | userType }}</span></td>
                  <td>{{ user.created_at | filterDate }}</td>
                  <td> 
                      <a href="#" @click="editModal(user)" title="Modifier"> 
                          <i class="fa fa-edit" style="color:green"></i> </a> &nbsp;
                      <a href="#" @click="deleteUser(user.id)" title="Supprimer"> 
                          <i class="fa fa-trash" style="color:red"></i> 
                        </a>
                    </td>
                </tr>
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>








        <div class="modal fade in " id="modal-default" style="none">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span></button>
                    <h4 class="modal-title">{{ editMode ? 'Modifier' : 'Ajouter' }} un utilisateur</h4>
                </div>
                <form @submit.prevent="editMode ? updateUser() : createUser()">
                <div class="modal-body">
                    <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                        placeholder="Entrez votre nom"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name" style="color:red"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.email" type="email" name="email"
                        placeholder="Votre Adresse Email"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email" style="color:red"></has-error>
                    </div>

                    <div class="form-group">
                        <textarea v-model="form.bio" name="bio"
                        placeholder="Votre Biographie" class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                        <has-error :form="form" field="bio" style="color:red"></has-error>
                    </div>


                    <div class="form-group">
                        <select name="type" id="type" v-model="form.type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }" >
                            <option value="">Choisissez un type</option>
                            <option value="admin">Administrateur</option>
                            <option value="user">Utilisateur Standard</option>
                            <option value="author">Rédacteur</option>
                        </select>
                        <has-error :form="form" field="type" style="color:red"></has-error>
                    </div>

                    <div class="form-group" v-show="!editMode">
                        <input v-model="form.password" type="password" name="password"
                        placeholder="Votre mot de passe"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password" style="color:red"></has-error>
                    </div>
                    

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">{{ editMode ? 'Modifier' : 'Ajouter' }}</button>
                </div>
                </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>    
</template>

<script>
    export default {

        data () {
            return {
                
                editMode: false,

                users : {},

                form: new Form({
                    id : '',
                    name :  '',
                    email : '',
                    password : '',
                    type : '',
                    bio : '',
                })
            }
        },

    
        methods: {

            editModal(user){
                this.editMode = true;
                this.form.reset();
                this.form.clear();
                $("#modal-default").modal('show');
                this.form.fill(user);
            },

            newModal(){
                this.editMode = false;
                this.form.reset();
                $("#modal-default").modal('show');
            },

            updateUser(){
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id).then(()=>{
                    Fire.$emit('AfterCreate');
                    this.loadUsers();
                    $("#modal-default").modal('hide');
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: "L'utilisateur a été modifier avec succès",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                }) ;
            },
            
            deleteUser(id){
                Swal.fire({
                    title: 'Êtes vous sur?',
                    text: "Vous ne pouvez plus récupérez les données!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Supprimer!'
                    }).then((result) => {

                    if(result.value){
                        this.$Progress.start();
                        this.form.delete('api/user/'+id).then( () => {
                        Swal.fire(
                        'Supprimer!',
                        'La suppresion à été effectué avec succès ',
                        'success'
                        )
                        Fire.$emit('AfterCreate');
                        this.loadUsers();
                        this.$Progress.finish();

                        } ).catch( () => {
                            this.$Progress.fail();
                            Swal.fire(
                            'Echec!',
                            "Une erreur s'est produit lors de la suppression",
                            'warning'
                            )
                        } )
                    }else{
                        Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: "L'utilisateur n'as pas été supprimé",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    }
                    
                    
                        
            

                })
            },

            loadUsers(){
                this.$Progress.start();
                axios.get('api/user').then( ({ data }) => this.users = data.data );
                this.$Progress.finish();
            },

            createUser(){
                this.$Progress.start();
                this.form.post('api/user')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    this.loadUsers();
                    $("#modal-default").modal('hide');
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: "L'utilisateur a été ajouter avec succès",
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();
                }) ;
                
                

            }
        },

        created(){
            this.loadUsers();
            Fire.$on( 'AfterCreate' , this.loadUsers);
            //setInterval(this.loadUsers , 3000);
        }
    }
</script>
