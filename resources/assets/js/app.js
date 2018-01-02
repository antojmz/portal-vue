/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.onbeforeunload = function (e) {
    document.getElementById("divSpiner").style.display="none"; 
    document.getElementById("divApp").style.display="block"; 
}
require('./bootstrap');
// window.Vue = require('vue');
import Vue from 'vue'
import Vuetify from 'vuetify'
import axios from 'axios'
import moment from 'moment' 
import jquery from 'jquery'
import toastr from 'toastr'
Vue.use(Vuetify)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('usuario', require('./components/Usuario.vue'));
Vue.component('password', require('./components/Cambio_pass.vue'));
Vue.component('perfil', require('./components/Perfil.vue'));

const app = new Vue({
    el: '#divPrincipal',
    created(){
      window.addEventListener('beforeunload', this.onbeforeunload)
      window.addEventListener('keydown', function(e) {if(e.keyCode == 116){this.salir=1;}});
    },
    mounted(){
      document.getElementById("divSpiner").style.display="none"; 
      document.getElementById("divApp").style.display="block";
      this.CerrarSesion()
    },
    data:{
      tile:false,
      dialog: false,
      drawer: null,
      salir:0,
      FormLogout:{
        _token:'',
      },
      menu_sidebar: [
        { icon: 'home', text: 'Home', href: '/home' },
        {
          icon: 'keyboard_arrow_up',
          'icon-alt': 'keyboard_arrow_down',
          text: 'Usuarios',
          model: false,
          children: [
            { icon: 'account_circle', text: 'Listado de usuarios',href: '/admin/usuarios' }
          ]
        },
        { icon: 'settings', text: 'Settings', href:'/home'},
        { icon: 'chat_bubble', text: 'Send feedback', href:'/home'},
        { icon: 'help', text: 'Help', href:'/home'},
        { icon: 'phonelink', text: 'App downloads', href:'/home'},
        { icon: 'keyboard', text: 'Go to the old version', href:'/home'}
      ]
    },
    props: {
      source: String
    },
    methods:{
      cambiarSalir: function(){
        this.salir=1;
      },
      CerrarSesion: function(){
        // setTimeout(function(){
        //   app.Salir();
        // // }, 5000)
        // }, 600000)
      },
      onbeforeunload : function (){
        if (this.salir==0){
          // app.Salir();
        }
        this.salir=0;     
      },
      Salir: function(){
        axios.post("/logout", this.FormLogout).then(response => {
          window.location.href = "/";
        });
      }
    }
});
