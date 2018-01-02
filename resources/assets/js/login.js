/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.onbeforeunload = function (e) {
	document.getElementById("divApp").style.display="none"; 
	document.getElementById("divSpiner").style.display="block"; 
}
require('./bootstrap');
// window.Vue = require('vue');
import jquery from 'jquery'
import toastr from 'toastr'
import Vue from 'vue'
import axios from 'axios'
import Vuetify from 'vuetify'

Vue.use(Vuetify)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
var app = new Vue({
	el:'#divLogin',
	data: {
		maskvalue:true,
		e3: 1,
        e31: true,
		validLogin: false,
		validRescue: false,
        name: '',
        ReglaInput: [
          (v) => !!v || 'Campo requerido.',
        ],
        ReglaEmail: [
          (v) => !!v || 'Campo requerido.',
          (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Ingrese una dirección de E-mail valida.'
        ],
		FormLogin:{
			usrUserName : '',
			usrPassword : '',
        	remember: false
		},
		FormRescue:{
			email : ''
		},
		errors: []
	}, 
    mounted: function () { 
		document.getElementById("divSpiner").style.display="none"; 
		document.getElementById("divApp").style.display="block"; 
    },
	methods:{
		toggleLogin:function(){
			$(".divForm").toggle("slow");
		},
		postLogin: function(){
	        if (this.$refs.formLogin.validate()) {
				axios.post("login",this.FormLogin).then(response =>{
					if(response.data.code=="200"){
						window.location.href = response.data.des_code;
					}else{
              			toastr.warning(response.data.des_code, "Aviso!");
					}
				}).catch(error => {
          			toastr.error(error.response.data, "Error!");
				});
	        }
		},
		postRescue: function(){
	        if (this.$refs.formRescue.validate()) {
				axios.post("/admin/recuperar",this.FormRescue).then(response =>{
					if(response.data.code=="200"){
              			toastr.success(response.data.des_code, "Procesado!");
					}else{
              			toastr.warning(response.data.des_code, "Aviso!");
					}
				}).catch(error => {
          			toastr.error(error.response.data, "Error!");
				});
	        }
		}
	}
});