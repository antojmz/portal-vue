<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<!-- begin::Head -->
	<head>
	    @php
			header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
			header('Cache-Control: no-store, no-cache, must-revalidate');
			header('Cache-Control: post-check=0, pre-check=0', FALSE);
			header('Pragma: no-cache');
	    @endphp	
		<meta charset="utf-8" />
		<title>{{ config('app.name', 'Laravel') }}</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    	<meta name="csrf-token" content="{{ csrf_token() }}">
		<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    	{!! Html::style('css/app.css') !!}
		<script src="{{ asset('js/utils/utils.js') }}"></script>
	</head>
	<body>
		<div id="divAccesos" style="position:relative;z-index:1;">
			<div id="DivSpiner" style="position:absolute;z-index:3;">
				<v-container fluid fill-height>
					<v-layout justify-center align-center>
						<v-progress-circular indeterminate color="indigo lighten-4"></v-progress-circular>
					</v-layout>
				</v-container>
			</div>				
			<v-app id="DivAccesos" style="display:none;position:relative;z-index:2;">
				<v-toolbar color="indigo" dark fixed app>
					<v-toolbar-title>
						Portal de Proveedores
            		</v-toolbar-title>
		                <v-spacer></v-spacer>
						    <v-menu offset-y>
						    	<v-btn icon slot="activator">
						    		@php  
										$avatarUser = Auth::user()->usrUrlimage;
										(strlen($avatarUser) > 10) ? $avatar=$avatarUser : $avatar="img/default.png";
									@endphp
							        <v-avatar size="32px" :tile="tile">
							        	<img class="avatar" src="{{ asset($avatar) }}" alt="">
							        </v-avatar>
                          		</v-btn>
		                        <div style="width:250px;">
			                        <v-list style="background-color:#7986CB;">
		                        		<h2 style="color:white" class="text-xs-center">
		                        			@php echo Auth::user()->usrNombreFull; @endphp
		                        		</h2>
		                        		<h4 style="color:white" class="text-xs-center">
											@php echo Auth::user()->usrEmail; @endphp
		                        		</h4>
			                        </v-list>
			                        <v-list>
			                        	<v-list-tile href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
			                                <v-list-tile-action>
						                		<v-icon>input</v-icon>
						              		</v-list-tile-action>
			                                <v-list-tile-title>
			                                	<span>Salir</span>
			                                </v-list-tile-title>
			                            </v-list-tile>
			                        </v-list>
		                        </div>
	                        </v-menu>
				</v-toolbar>
				<v-content>
					<v-container row>
						<v-layout justify-center>
				            <v-card>
				              <v-card-title>
				     			<h3 class="text-xs-center">
				    				Listado de accesos disponibles
				     			</h3>
				              </v-card-title>
				              <v-data-table :headers="headers" :items="listAccesos" v-bind:search="search">
				                <template slot="items" slot-scope="props">
				                	<tr v-on:dblclick="EligeAcceso(props.item)">
				                  		<td class="text-xs-right">@{{ props.item.usrNombreFull }}</td>
				                  		<td class="text-xs-right">@{{ props.item.usrUserName }}</td>
				                  		<td class="text-xs-right">@{{ props.item.des_perfil }}</td>
				                 	</tr>
				                </template>
				                <template slot="no-data">
				                	La consulta realizada no arrojo resultados
				                </template>
				              </v-data-table>
				            </v-card>
						</v-layout>
					</v-container>
				</v-content>
				<v-footer color="indigo" app>
					<span class="white--text">&copy; 2017</span>
				</v-footer>			
			</v-app>
		</div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        	{{ csrf_field() }}
        	<input type="hidden" name="_token" id="_token" value="{!! csrf_token() !!}">
        </form>
		<script Language="Javascript">
			var ruta = "{{ URL::route('accesos') }}"
			var d = [];
			d['v_accesos'] = JSON.parse(rhtmlspecialchars('{{ json_encode($v_accesos) }}'));
		</script>
		<script src="{{ asset('js/accesos/accesos.js') }}"></script>
	</body>
</html>