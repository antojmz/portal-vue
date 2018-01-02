<template>
  <v-container style="background-color: white;" fluid>
    <div id="divTabla" class="divTabla">
      <div class="divPerfiles">
        <v-layout row>
          <v-flex md10 offset-md5>
              <span class="spanTitulo">Usuarios registrados</span>
          </v-flex>
        </v-layout>
        <hr><br>
        <v-layout row>
          <v-flex xs12>
            <v-card>
              <v-card-title>
                <v-flex xs12 md6 xl6>
                  <v-text-field append-icon="search" label="Search" single-line hide-details v-model="search"></v-text-field>
                </v-flex>
                <v-flex xs12 md6 xl6>
                  <v-btn round color="primary" dark @click="toggleF" style="float:right;">Agregar</v-btn>
                </v-flex>
              </v-card-title>
              <v-data-table :headers="headers" :items="listUsuarios" v-bind:search="search">
                <template slot="items" slot-scope="props">
                  <td class="text-xs-right">{{ props.item.usrNombreFull }}</td>
                  <td class="text-xs-right">{{ props.item.usrUserName }}</td>
                  <td class="text-xs-right">{{ props.item.usrEmail }}</td>
                  <td class="text-xs-right">{{ props.item.creador }}</td>
                  <td class="text-xs-right">{{ props.item.modificador }}</td>
                  <td class="text-xs-right">{{ props.item.des_estado }}</td>
                  <td class="text-xs-right">{{ props.item.usrUltimaVisita }}</td>
                  <td class="text-xs-right">{{ props.item.DescripcionBloqueo }}</td>
                  <td class="text-xs-center">
                    <v-menu offset-y>
                      <v-btn icon small color="cyan" dark slot="activator">
                        <v-icon dark>more_vert</v-icon>
                      </v-btn>
                      <v-list>
                        <v-list-tile @click="editarUsuario(props.item)">
                          <v-list-tile-title>
                            <span>Editar</span>
                          </v-list-tile-title>
                        </v-list-tile>
                        <v-list-tile @click.prevent="reiniciarclave(props.item)">
                          <v-list-tile-title>
                            <span>Reiniciar clave</span>
                          </v-list-tile-title>
                        </v-list-tile>
                        <v-list-tile @click.prevent="desactivarUsuario(props.item)">
                          <v-list-tile-title>
                              <span>Activar / Desactivar</span>
                          </v-list-tile-title>
                        </v-list-tile>
                        <v-list-tile @click="administrarperfiles(props.item)">
                          <v-list-tile-title>
                              <span>Administrar perfiles</span>
                          </v-list-tile-title>
                        </v-list-tile>
                      </v-list>
                    </v-menu>
                  </td>                   
                </template>
                <template slot="no-data">
                  La consulta realizada no arrojo resultados
                </template>
                <template slot="pageText" slot-scope="{ pageStart, pageStop }">
                  From {{ pageStart }} to {{ pageStop }}
                </template>
              </v-data-table>
            </v-card>
          </v-flex>
        </v-layout>
      </div>
    </div>
    <div class="divPerfiles" style="display:none;">
      <v-layout row>
            <v-flex xs12>
              <v-btn round outline color="primary" style="float: right;" @click="togglePf">volver</v-btn>
            </v-flex>
      </v-layout>
      <br>
      <v-layout row>
            <v-flex xs12 class="text-xs-center">
                <span id="spanAlert" class="text-xs-center spanSubTitulo">Administración de perfiles</span>
            </v-flex>
      </v-layout>
      <br><br>
      <v-form id="FormPerfil" v-model="validP" ref="formP" lazy-validation>
        <v-layout row>
          <v-flex xs4 offset-xs3>
            <v-select label="perfíl" v-model="FormPerfil.idPerfil" :items="comboPerfiles" :rules="ReglaInput" required autocomplete placeholder="Seleccione..."></v-select>
          </v-flex>
          <v-flex xs3 offset-xs1>
            <v-btn round color="primary" dark @click="validarPerfiles" :disabled="!validP">
              asignar
            </v-btn>
          </v-flex>
        </v-layout>
      </v-form>
        <br>
        <v-layout row>
          <v-flex xs12 sm12 md8 offset-md2>
                <v-card>
                  <v-data-table :headers="headersP" :items="listPerfiles" v-bind:search="searchP">
                    <template slot="items" slot-scope="props">
                      <td class="text-xs-right">{{ props.item.usrNombreFull }}</td>
                      <td class="text-xs-right">{{ props.item.usrUserName }}</td>
                      <td class="text-xs-right">{{ props.item.des_perfil }}</td>
                      <td class="text-xs-right">{{ props.item.estado_perfil }}</td>
                      <td class="text-xs-center">
                        <v-menu offset-y>
                          <v-btn icon small color="cyan" dark slot="activator">
                            <v-icon dark>more_vert</v-icon>
                          </v-btn>
                          <v-list>
                            <v-list-tile @click.prevent="desactivarPerfil(props.item)">
                              <v-list-tile-title>
                                  <span>Activar / Desactivar</span>
                              </v-list-tile-title>
                            </v-list-tile>
                          </v-list>
                        </v-menu>
                      </td>                  
                    </template>
                    <template slot="no-data">
                      La consulta realizada no arrojo resultados
                    </template>
                  </v-data-table>
                </v-card>
          </v-flex>
        </v-layout>       
      </div>
      </div>
      <div id="divForm" class="divTabla" style="display:none;">
        <v-layout row>
          <v-flex xs5 offset-xs4>
            <br>
            <center><span id="spanTitulo">Registro de usuarios</span></center>
          </v-flex>
        </v-layout>
        <br><hr>
        <v-form v-model="valid" ref="form" lazy-validation>
          <input type="hidden" v-model="FormUsuario.idUser">
          <input type="hidden" v-model="FormUsuario._token" value="{!! csrf_token() !!}">
          <v-layout row>
            <v-flex xs5 offset-xs4>
              <v-text-field label="Login" v-model="FormUsuario.usrUserName" :rules="ReglaInput" mask="########-#" v-bind:return-masked-value="true" required></v-text-field>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs5 offset-xs4>
              <v-text-field label="Nombres" v-model="FormUsuario.usrNombreFull" :rules="ReglaInput" required></v-text-field>
            </v-flex>
          </v-layout>
          <v-layout row>
            <v-flex xs5 offset-xs4>
              <v-text-field label="E-mail" v-model="FormUsuario.usrEmail" :rules="ReglaEmail" required></v-text-field>
            </v-flex>
          </v-layout>
          <div id="divestado" style="display:none;">
            <v-layout row>
              <v-flex xs5 offset-xs4>
                <v-select label="Estado usuario" v-model="FormUsuario.usrEstado" :items="comboEstados" :rules="ReglaInput" required autocomplete></v-select>
              </v-flex>
            </v-layout>
          </div>
          <div id="divSpanPerfiles" style="display:none;">
            <v-layout row>
              <v-flex xs5 offset-xs4>
                <v-text-field :label="FormUsuario.des_perfiles" v-model="FormUsuario.perfiles" readonly></v-text-field>
              </v-flex>
            </v-layout>
          </div>
          <div id="divConsulta" style="display:none;">
            <v-layout row>
              <v-flex xs5 offset-xs4>
                <v-text-field label="Última visita" v-model="FormUsuario.usrUltimaVisita" readonly></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex xs5 offset-xs4>
                <v-text-field label="Creado el" v-model="FormUsuario.auCreadoEl" readonly></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex xs5 offset-xs4>
                <v-text-field label="Creado por" v-model="FormUsuario.creador" readonly></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex xs5 offset-xs4>
                <v-text-field label="Modificado el" v-model="FormUsuario.auModificadoEl" readonly></v-text-field>
              </v-flex>
            </v-layout>
            <v-layout row>
              <v-flex xs5 offset-xs4>
                <v-text-field label="Modificado por" v-model="FormUsuario.modificador" readonly></v-text-field>
              </v-flex>
            </v-layout>
          </div>
          <v-layout row>
            <v-flex xs5 offset-xs5>
              <v-btn round color="primary" dark @click="regUsuario" :disabled="!valid">guardar</v-btn>
              <v-btn round outline color="primary" @click="toggleF">cancelar</v-btn>
            </v-flex>
          </v-layout>
        </v-form>
      </div>
    </div>
  </v-container>
</template>

<script>
  import toastr from 'toastr'
  export default {
    data () {
      return {
        valid: false,
        validP: false,
        name: '',
        ReglaInput: [
          (v) => !!v || 'Campo requerido.',
        ],
        email: '',
        ReglaEmail: [
          (v) => !!v || 'Campo requerido.',
          (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Ingrese una dirección de E-mail valida.'
        ],
        select: null,
        listPerfiles: [],
        FormPerfil:{
          idUser:'',
          idPerfil:null        
        },
        FormUsuario:{
          idUser:'',
          idPerfil:null,
          perfiles:'',        
          des_perfiles:'',
          usrUserName:'',
          usrEmail:'',
          usrNombreFull:'',
          usrEstado: '',
          usrUltimaVisita:'Desconocido',
          auCreadoEl:'Desconocido',
          creador:'Desconocido',
          auModificadoEl:'Desconocido',
          modificador:'Desconocido',
          _token: ''
        },
        selected: [],
        alert: true,
        errorUsrEstado:false,
        msgUsrEstado : '',

        errorIdPerfil:false,
        msgIdPerfil:'',

        toggleForm : false,
        togglePerf: false,
        toggleCon: false,

        comboPerfiles:[],
        comboEstados:[],
        listPerfiles:[],
        //datatabla
        search: '',
        pagination: {},
        headers: [
        {text: 'Nombres', value: 'usrNombreFull'},
        {text: 'Login', value: 'usrUserName'},
        {text: 'Email', value: 'usrEmail'},
        {text: 'Creador', value: 'creador'},
        {text: 'Modificador', value: 'modificador'},
        {text: 'Estado', value: 'des_estado'},
        {text: 'Últimavisita', value: 'usrUltimaVisita'},
        {text: 'Estado Bloqueo', value: 'DescripcionBloqueo'},
        {text: 'Acciones'}
        ],
        listUsuarios: [],
        // Perfiles
        searchP: '',
        // pagination: {},
        headersP: [
        {text: 'Nombres', value: 'usrNombreFull'},
        {text: 'Login', value: 'usrUserName'},
        {text: 'Perfíl', value: 'des_perfil'},
        {text: 'Estatus', value: 'estado_perfil'},
        {text: 'Acciones'}
        ],
      }
    },
    created: function(){
      this.getUsuarios();
    },
    methods:{
      getUsuarios:function(){
        var urlUsuarios = 'usuariosD';
        axios.get(urlUsuarios).then(response=>{
          if(response.status=="200"){
            this.comboEstados=response.data.v_estados;
            this.comboPerfiles=response.data.v_perfiles;
            this.listUsuarios=response.data.v_usuarios;
          }
        });
      },
      toggleF:function(){
        this.$refs.form.reset()
        $(".divTabla").toggle();
        $("#divSpanPerfiles").hide();
        $("#divConsulta").hide();
        $("#divestado").show();
        // this.toggleForm==false ? this.toggleForm=true : this.toggleForm=false;
        // this.toggleCon=false;
        this.FormUsuario.idUser='';
        this.FormUsuario.usrUserName='';
        this.FormUsuario.usrNombreFull='';
        this.FormUsuario.usrEmail='';
        this.FormUsuario.usrEstado= '';
        this.FormUsuario._token='';
      },
      togglePf:function(){
        // this.FormPerfil.idPerfil = '';
        $(".divPerfiles").toggle();
        // this.togglePerf==false ? this.togglePerf=true : this.togglePerf=false;
      },
      editarUsuario:function(row){
        $(".divTabla").toggle();
        $("#divSpanPerfiles").show();
        $("#divConsulta").show();
        $("#divestado").hide();
        // this.toggleF();
        // this.toggleCon=true;
        if(row.des_Perfil!=null){
          var res = row.des_Perfil.split(",");
          res.length>1 ? this.FormUsuario.des_perfiles="Perfiles" : this.FormUsuario.des_perfiles="Perfil";
          this.FormUsuario.perfiles=row.des_Perfil;
        }else{
          this.FormUsuario.des_perfiles='Perfil';
          this.FormUsuario.perfiles="N/A o Inactivo";
        }
        this.FormUsuario.idUser=row.idUser;
        this.FormUsuario.usrUserName=row.usrUserName;
        this.FormUsuario.usrEmail=row.usrEmail;
        this.FormUsuario.usrNombreFull=row.usrNombreFull;
        if (row.usrEstado==0){
          this.FormUsuario.usrEstado={ "id": 0, "text": "Inactivo", "orden": 1 }
        }else{
          this.FormUsuario.usrEstado={ "id": 1, "text": "Activo", "orden": 2 }
        }
        row.usrUltimaVisita!=null ? this.FormUsuario.usrUltimaVisita=row.usrUltimaVisita : this.FormUsuario.usrUltimaVisita="Desconocido";
        row.auCreadoEl!=null ? this.FormUsuario.auCreadoEl=row.auCreadoEl : this.FormUsuario.auCreadoEl="Desconocido";
        row.creador!=null ? this.FormUsuario.creador=row.creador : this.FormUsuario.creador="Desconocido";
        row.auModificadoEl!=null ? this.FormUsuario.auModificadoEl=row.auModificadoEl : this.FormUsuario.auModificadoEl="Desconocido";
        row.modificador!=null ? this.FormUsuario.modificador=row.modificador : this.FormUsuario.modificador="Desconocido";
      },
      reiniciarclave:function(row) {
        var rutaR = "reiniciar";
        axios.post(rutaR,row).then(response =>{
          if(response.status=="200"){
            switch(response.data.code) {
              case "200":
              toastr.success('Proceso con exito.', "Procesado!");
              break;
              case "500":
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
      desactivarUsuario:function(row){
        var rutaA="activar";
        axios.post(rutaA,row).then(response =>{
          if(response.status=="200"){
            toastr.success('Proceso con exito.', "Procesado!");
            this.listUsuarios=response.data.v_usuarios; 
          }else{
            toastr.error("Comuniquese con el personal de sopore técnico", "Error!");
          }
        }).catch(error => {
          toastr.error("Contacte al personal informático", "Error!");
        });
      },
      desactivarPerfil:function(row){
        var rutaAP = "activarP";
        axios.post(rutaAP,row).then(response =>{
          if(response.status=="200"){
            toastr.success('Proceso con exito.', "Procesado!");
            this.listPerfiles=response.data.v_perfiles;
          }else{
            toastr.error("Comuniquese con el personal de sopore técnico", "Error!");
          }
        }).catch(error => {
          toastr.error("Contacte al personal informático", "Error!");
        });
      },
      administrarperfiles:function(row){
        $(".divPerfiles").toggle();
        var rutaP ='perfiles';
        axios.get(rutaP,{params:row}).then(response =>{
          if(response.status=="200"){
            this.FormPerfil.idUser=row.idUser;
            if (response.data.v_perfiles.length>0){
              this.listPerfiles=response.data.v_perfiles;
            }else{
              this.listPerfiles=[];
              toastr.warning("Este usuario no tiene perfiles asignados aun.", "Aviso!");
            }
          }else{
            toastr.error("Comuniquese con el personal de sopore técnico", "Error!");
          }
        }).catch(error => {
          toastr.error("Contacte al personal informático", "Error!");
        });
      },
      validarPerfiles:function(){
        if (this.FormPerfil.idPerfil.length<3){
          this.errorIdPerfil=true;
          this.msgIdPerfil='El campo Perfil es obligatorio.';
          return;
        }else{
          this.errorIdPerfil=false;
          this.msgIdPerfil='';
          this.regPerfil();
        }
      },
      regPerfil:function(){
        var rutaP ='perfiles';
        if (this.$refs.formP.validate()){
          axios.post(rutaP,{idUser:this.FormPerfil.idUser,idPerfil: this.FormPerfil.idPerfil.id}).then(response =>{
            if(response.status=="200"){
              var res = JSON.parse(response.data.f_registro_perfil);
              switch(res.code) {
                case "200":
                toastr.success('Proceso con exito.', "Procesado!");
                this.listPerfiles=response.data.v_perfiles;
                this.FormPerfil.idPerfil = '';
                break;
                case "-2":
                toastr.warning(res.des_code, "Aviso!");
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
      regUsuario:function(){
        if (this.$refs.form.validate()) {
          var ruta = "usuarios";
          this.FormUsuario.usrEstado=this.FormUsuario.usrEstado.id;
          axios.post(ruta,this.FormUsuario).then(response =>{
            if(response.status=="200"){
              var res = JSON.parse(response.data.f_registro.f_registro_usuario);
              switch(res.code) {
                case "200":
                  toastr.success('Proceso con exito.', "Procesado!");
                  this.listUsuarios=response.data.v_usuarios;
                  this.toggleF();
                break;
                case "-2":
                  toastr.warning(res.des_code, "Aviso!");
                break;
              } 
            }else{
              toastr.error("Comuniquese con el personal de sopore técnico", "Error!");
            }
          }).catch(error => {
            toastr.error("Contacte al personal informático", "Error!");
          });
        }
      }
    }
  }
</script>

<style type="text/css" media="screen">
  table.table tbody td:first-child, table.table tbody td:not(:first-child), table.table tbody th:first-child, table.table tbody th:not(:first-child), table.table thead td:first-child, table.table thead td:not(:first-child), table.table thead th:first-child, table.table thead th:not(:first-child){
    padding: 0 10px;
  }
</style>