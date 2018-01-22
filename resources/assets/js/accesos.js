
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.onbeforeunload = function (e) {
    document.getElementById("DivAccesos").style.display="none"; 
    document.getElementById("DivSpiner").style.display="block"; 
}
require('./bootstrap');
// window.Vue = require('vue');
import Vue from 'vue'
import axios from 'axios'
import Vuetify from 'vuetify'
import jquery from 'jquery'
import toastr from 'toastr'
Vue.use(Vuetify)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
var vu = new Vue({
    el: '#divAccesos',
    data: {
        tile:false,
        visible : false,
        filterTable: '',
        listAccesos: d['v_accesos'],
        //datatabla
        search: '',
        pagination: {},
        headers: [
            {text: 'Nombres', value: 'usrNombreFull'},
            {text: 'Login', value: 'usrUserName'},
            {text: 'Perfíl', value: 'des_perfil'}
        ]
    },
    mounted: function () {
        document.getElementById("DivSpiner").style.display="none"; 
        document.getElementById("DivAccesos").style.display="block"; 
    },
    methods: {
        EligeAcceso:function(row){
            axios.post(ruta,row).then(response =>{
                if(response.status=="200"){
                    window.location.href = "/"+response.data.des_code;
                }else{
                    toastr.error("Comuniquese con el personal de sopore técnico", "Error!");
                }
            }).catch(error => {
                    toastr.error("Contacte al personal informático", "Error!");
            });
        }
    }
});
