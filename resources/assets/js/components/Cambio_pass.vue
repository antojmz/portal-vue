<template>
  <v-container>
    <v-flex xs12 sm12 md6 offset-md3>
      <v-card>
        <v-card-title>
          <v-flex>
            <h3 class="text-xs-center">
              Cambio de Contraseña
            </h3>
          </v-flex>
          <hr>
        </v-card-title>
        <v-form v-model="validPass" ref="formP" lazy-validation>
          <v-flex xs8 offset-xs2>
            <v-text-field label="Contraseña actual" type="password" v-model="FormPasswd.password_old" :rules="ReglaInput" required></v-text-field>
          </v-flex>
          <v-flex xs8 offset-xs2>
            <v-text-field label="Nueva contraseña" type="password" v-model="FormPasswd.password" :rules="ReglaDistintos" required></v-text-field>
          </v-flex>
          <v-flex xs8 offset-xs2>
            <v-text-field label="Confime contraseña" type="password" v-model="FormPasswd.password_confirmation" :rules="ReglaIguales" required></v-text-field>
          </v-flex>
          <v-flex xs8 offset-xs3>
            <v-btn round color="primary" dark @click="cambiarPasswd" :disabled="!validPass">guardar</v-btn>
            <v-btn round outline color="primary" @click="">cancelar</v-btn>
          </v-flex>
        </v-form> 
      </v-card>
    </v-flex>
  </v-container>
</template>

<script>
  import toastr from 'toastr'
  export default {
    data () {
      return {
        FormPasswd:{
          password_old:'',
          password:'',
          password_confirmation:''
        },
        validPass: false,
        // primerPass : this.FormPasswd.password_old,
        ReglaInput: [
          (v) => !!v || 'Campo requerido.',
        ],
        ReglaDistintos: [
          (v) => !!v || 'Campo requerido.',
          (v) => v !== this.FormPasswd.password_old || 'Las contraseña actual y la nueva, deben ser distintas.'
        ],
        ReglaIguales: [
          (v) => !!v || 'Campo requerido.',
          (v) => v == this.FormPasswd.password || 'La confirmación del password no coincide.'
        ],
      }
    },
    methods:{
      cambiarPasswd:function(){
        var rutaP ='/admin/password';
        if (this.$refs.formP.validate()){
          axios.post(rutaP,this.FormPasswd).then(response =>{
            if(response.status=="200"){
              switch(response.data.code) {
                case "200":
                  toastr.success('Proceso con exito.', "Procesado!");
                  this.$refs.formP.reset();
                break;
                default:
                  toastr.warning(response.data.des_code, "Aviso!");
                break;
              }
            }else{
              toastr.warning(response.data.des_code, "Error!");
            }
          }).catch(error => {
            toastr.error("Contacte al personal informático", "Error!");
          });
        }
      }
    }
  }
</script>