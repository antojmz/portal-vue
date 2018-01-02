<template>
  <v-flex xs12 sm12 md12 xl12>
    <v-card>
      <v-card-title>
        <v-layout row>
          <v-flex xs12>
            <h3 class="text-xs-center">
              Actualización de datos
            </h3>
          </v-flex>
        </v-layout>
      </v-card-title>
      <v-layout row wrap>
        <v-flex xs12 sm12 md8>              
          <v-form  v-model="validP" ref="formP" lazy-validation>
            <input type="hidden" v-model="FormPerfil._token" value="{!! csrf_token() !!}">
            <input type="hidden" v-model="FormPerfil.idUser">
            <v-layout row>
              <v-flex xs10 offset-xs1 md6 offset-md3>
                <v-text-field label="Login" v-model="FormPerfil.usrUserName" disabled></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex xs10 offset-xs1 md6 offset-md3>
                <v-text-field label="Nombres" v-model="FormPerfil.usrNombreFull" :rules="ReglaInput" :disabled="disabled" required></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex xs10 offset-xs1 md6 offset-md3>
                <v-text-field label="Email" v-model="FormPerfil.usrEmail" :rules="ReglaEmail" :disabled="disabled" required></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex xs10 offset-xs1 md6 offset-md3>
                <v-text-field label="Última visita" v-model="FormPerfil.usrUltimaVisita" disabled></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex xs10 offset-xs1 md6 offset-md3>
                <v-text-field label="Fecha de creación" v-model="FormPerfil.auCreadoEl" disabled></v-text-field>
              </v-flex>
            </v-layout>
          <v-layout row>
            <v-flex xs8 offset-xs4 md8 offset-md4>
              <v-btn round color="primary" v-show="ButonEditar" dark @click="habilitarCampos">modificar</v-btn>
              <v-btn round color="primary" v-show="!ButonEditar" dark @click="editarPerfil" :disabled="!validP">
                guardar
              </v-btn>
              <v-btn round outline color="primary" v-show="!ButonEditar" @click="inhabilitarCampos">
                cancelar
              </v-btn>
            </v-flex>
          </v-layout>
          </v-form>
        </v-flex>
        <v-flex xs12 sm12 md4>              
            <v-flex xs12 offset-xs3 md12 offset-md1>
              <input type="hidden" v-model="FormPerfil.idUser">
              <input type="hidden" v-model="FormPerfil.usrUrlimage">
              <v-avatar size="120px" :tile="tile">
                <img class="avatar" :src='FormPerfil.image' alt="">
              </v-avatar>
            </v-flex>
            <p></p>
            <v-flex xs12 offset-xs3 md12 offset-md1>
              <input type="file" class="form-control" @change="onFileChange">
            </v-flex>
            <p></p>
            <v-flex xs12 offset-xs3 md12 offset-md1>
              <v-btn round color="primary" dark @click="cargarImagen">cargar</v-btn>
              <v-btn round outline color="primary" @click="borrarImagen">eliminar</v-btn>
            </v-flex>
        </v-flex>
      </v-layout>
    </v-card>
  </v-flex>
</template>

<script>
  import toastr from 'toastr'
  import moment from 'moment'
  export default {
    data () {
      return {
        validP: true,
        ButonEditar: true,
        disabled: true,
        name: '',
        ReglaInput: [
          (v) => !!v || 'Campo requerido.',
        ],
        email: '',
        ReglaEmail: [
          (v) => !!v || 'Campo requerido.',
          (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Ingrese una dirección de E-mail validos.'
        ],
        tile:false,
        FormPerfil:{
          usrUrlimage: null,
          image: null,
          _token: '',
          idUser:'',
          usrUserName:'',
          usrNombreFull:'',
          usrNombreFull2:'',
          usrEmail:'',
          usrEmail2:'',
          usrUltimaVisita:'Desconocido',
          auCreadoEl:'Desconocido',
          file: null
        },
      }
    },
    created: function () {
      this.getPerfil();
    },
    methods:{
      getPerfil:function(){
        var ruta = "/admin/perfilD";
        axios.get(ruta).then(response=>{
          if(response.status=="200"){
            this.FormPerfil.idUser=response.data.idUser;
            this.FormPerfil.usrUserName=response.data.usrUserName;
            this.FormPerfil.usrNombreFull=response.data.usrNombreFull;
            this.FormPerfil.usrNombreFull2=response.data.usrNombreFull;
            this.FormPerfil.usrEmail=response.data.usrEmail;
            this.FormPerfil.usrEmail2=response.data.usrEmail;
            var visita = moment(response.data.usrUltimaVisita, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
            this.FormPerfil.usrUltimaVisita=visita;
            var creadoel = moment(response.data.auCreadoEl, 'YYYY-MM-DD HH:mm:ss',true).format("DD-MM-YYYY");
            this.FormPerfil.auCreadoEl=creadoel;
            var img = response.data.usrUrlimage
            if (response.data.usrUrlimage!=null){
              if (img.length>5) {
                this.FormPerfil.usrUrlimage=response.data.usrUrlimage;
                this.FormPerfil.image=response.data.usrUrlimage;
              }
            }
          }
        }).catch(error => {
          toastr.error("Contacte al personal informático", "Error!");
        });
      },
      editarPerfil:function(){
        if (this.$refs.formP.validate()){
          var ruta = "/admin/perfil";
          axios.post(ruta,this.FormPerfil).then(response =>{
            if(response.status=="200"){
              this.ButonEditar=true; 
              this.disabled=true;
              toastr.success('Proceso con exito.', "Procesado!");
            }else{
              toastr.error("Comuniquese con el personal de sopore técnico", "Error!");
              return;
            }
          }).catch(error => {
            toastr.error("Contacte al personal informático", "Error!");
          });
        }
      },
      onFileChange(event) {
        this.FormPerfil.file = event.target.files[0]
      },
      cargarImagen:function(){
        var form = new FormData();
        form.append('idUser',this.FormPerfil.idUser);
        form.append('foto',this.FormPerfil.file);
        form.append('usrUrlimage',this.FormPerfil.usrUrlimage);
        var rutaC = "/admin/fotoc";
        axios.post(rutaC,form).then(response =>{
          if(response.status=="200"){
            switch(response.data.code) {
              case "200":
                toastr.success('Proceso con exito.', "Procesado!");
                this.FormPerfil.image=response.data.des_code;
                this.FormPerfil.usrUrlimage=response.data.des_code;
                $('.gavatar').attr('src',response.data.des_code)+ '?' + Math.random();
                $('.avatar').attr('src',response.data.des_code)+ '?' + Math.random();
              break;
              default:
                toastr.warning(response.data.des_code, "Aviso!");
              break;
            }
          }else{
            toastr.error("Comuniquese con el personal de sopore técnico", "Error!");
            return;
          }
        }).catch(error => {
          toastr.error("Contacte al personal informático", "Error!");
        });
      },
      borrarImagen:function(){
        if(this.FormPerfil.usrUrlimage==null){
          toastr.warning("No posees imagen de perfíl", "Aviso!");
        }else{
          var rutaE = "/admin/fotoe";
          axios.post(rutaE,this.FormPerfil).then(response =>{
            if(response.status=="200"){
              switch(response.data.code) {
                case "204":
                  this.FormPerfil.usrUrlimage=null;
                  $('.gavatar').attr('src','/img/default.png')+ '?' + Math.random();
                  $('.avatar').attr('src','/img/default.png')+ '?' + Math.random();
                  toastr.success('Proceso con exito.', "Procesado!");
                break;
                default:
                  toastr.warning(response.data.des_code, "Aviso!");
                break;
              }
            }else{
              toastr.error("Comuniquese con el personal de sopore técnico", "Error!");
            }
          }).catch(error => {
            toastr.error("Contacte al personal informático", "Error!");
          });
        }
      },
      habilitarCampos:function(){
        this.ButonEditar=false;
        this.disabled=false; 
      },
      inhabilitarCampos:function(){
        this.ButonEditar=true; 
        this.disabled=true;
        this.FormPerfil.usrEmail=this.FormPerfil.usrEmail2;
        this.FormPerfil.usrNombreFull=this.FormPerfil.usrNombreFull2;
      }
    }
  }
</script>