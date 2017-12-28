Vue.component('v-select', VueSelect.VueSelect);
Vue.use(VeeValidate, {
  locale: 'es',
});
var vu = new Vue({
    el: '#divUsuarios',
    data: {
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

        errorUsrEstado:false,
        msgUsrEstado : '',
        
        errorIdPerfil:false,
        msgIdPerfil:'',
        
        toggleForm : false,
        togglePerf: false,
        toggleCon: false,
        
        comboPerfiles:d['v_perfiles'],
        comboEstados:d['v_estados'],

        visible : false,
        filterTable: '',
        listUsuarios: d['v_usuarios'],
        columns: [
            {label: 'Nombres', field: 'usrNombreFull', align: 'center', filterable: true},
            {label: 'Login', field: 'usrUserName', align: 'center', filterable: true},
            {label: 'Email', field: 'usrEmail', align: 'center', filterable: true},
            {label: 'Creador', field: 'creador', align: 'center', filterable: true},
            {label: 'Modificador', field: 'modificador', align: 'center', filterable: true,},
            {label: 'Estado', field: 'des_estado', align: 'center', filterable: true},
            {label: 'Últimavisita', field: 'usrUltimaVisita', align: 'center', filterable: true},
            {label: 'Acciones', align: 'center', filterable: true}
        ],
        page: 1,
        
        listPerfiles:[] ,
        columnsP: [
            {label: 'Nombres', field: 'usrNombreFull', align: 'center', filterable: true},
            {label: 'Login', field: 'usrUserName', align: 'center', filterable: true},
            {label: 'Perfíl', field: 'estado_perfil', align: 'center', filterable: true},
            {label: 'Estado', field: 'des_perfil', align: 'center', filterable: true},
            {label: 'Acciones', align: 'center', filterable: true}
        ],
    },
    methods: {
        toggleF:function(){
            this.toggleForm==false ? this.toggleForm=true : this.toggleForm=false;
            this.toggleCon=false;
            this.FormUsuario.idUser='';
            this.FormUsuario.usrUserName='';
            this.FormUsuario.usrNombreFull='';
            this.FormUsuario.usrEmail='';
            this.FormUsuario.usrEstado= '';
            this.FormUsuario._token='';
        },
        togglePf:function(){
            this.FormPerfil.idPerfil = '';
            this.togglePerf==false ? this.togglePerf=true : this.togglePerf=false;
        },
        editarUsuario:function(row){
            this.toggleF();
            this.toggleCon=true;
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
                this.FormUsuario.usrEstado={ "value": 0, "label": "Inactivo", "orden": 1 }
            }else{
                this.FormUsuario.usrEstado={ "value": 1, "label": "Activo", "orden": 2 }
            }
            row.usrUltimaVisita!=null ? this.FormUsuario.usrUltimaVisita=row.usrUltimaVisita : this.FormUsuario.usrUltimaVisita="Desconocido";
            row.auCreadoEl!=null ? this.FormUsuario.auCreadoEl=row.auCreadoEl : this.FormUsuario.auCreadoEl="Desconocido";
            row.creador!=null ? this.FormUsuario.creador=row.creador : this.FormUsuario.creador="Desconocido";
            row.auModificadoEl!=null ? this.FormUsuario.auModificadoEl=row.auModificadoEl : this.FormUsuario.auModificadoEl="Desconocido";
            row.modificador!=null ? this.FormUsuario.modificador=row.modificador : this.FormUsuario.modificador="Desconocido";
        },
        reiniciarclave:function(row) {
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
            this.togglePf();
            axios.get(rutaP,{params:row}).then(response =>{
                if(response.status=="200"){
                    this.FormPerfil.idUser=row.idUser;
                    if (response.data.v_perfiles.length>0){
                        this.listPerfiles=response.data.v_perfiles;
                    }else{
                        this.listPerfiles='';
                        toastr.warning("Este usuario no tiene perfiles asignados aun.", "Aviso!");
                    }
                }else{
                    toastr.error("Comuniquese con el personal de sopore técnico", "Error!");
                }
            }).catch(error => {
                    toastr.error("Contacte al personal informático", "Error!");
            });
        },
        validateBeforeSubmit:function() {
            this.$validator.validateAll().then((result) => {
                if (this.FormUsuario.usrEstado.length<3){
                    this.errorUsrEstado=true;
                    this.msgUsrEstado ="El campo Estado es obligatorio.";
                    return;
                }else{
                    this.errorUsrEstado=false;
                    this.msgUsrEstado ="";
                    if (result){
                        this.regUsuario();
                    }
                }
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
            axios.post(rutaP,{idUser:this.FormPerfil.idUser,idPerfil: this.FormPerfil.idPerfil.value}).then(response =>{
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
        },
        regUsuario:function(){
            axios.post(ruta,this.FormUsuario).then(response =>{
                if(response.status=="200"){
                    var res = JSON.parse(response.data.f_registro_usuario);
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
});