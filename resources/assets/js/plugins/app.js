windows.Vue = require ('vue');
Vue.component('v-com', require('./components/Pru.vue'));

	var vm = new Vue({
		el:"#divPrincipal",
		created(){
			window.addEventListener('keyup', this.detectar)
			window.addEventListener('beforeunload', this.onbeforeunload)
		},
		mounted(){
			this.CerrarSesion()
		},
		data:{
			left: null,
			salir:0,
			FormLogout:{
				_token:'',
			},
			drawer: null,
		},
	    props: {
	      source: String
	    },
		methods:{
			cambiarSalir: function(){
				this.salir=1;
			},
			CerrarSesion: function(){
				setTimeout(function(){
					vm.Salir();
				// }, 5000)
				}, 600000)
			},
			detectar:function (e){
				// if (event.which == 116){
				// 	this.salir=1;
				// }
			},
			onbeforeunload : function (){
				if (this.salir==0){
					console.log("0000000000000000000000");
					// vm.Salir();
				}else{
					console.log("11111111111111111111111");
				}
				this.salir=0;			
			},
			Salir: function(){
				axios.post("/logout", this.FormLogout).then(response => {
					window.location.href = "/";
				});
			}
		},
	});
