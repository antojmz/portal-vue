<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" >
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
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<script src="{{ asset('js/utils/utils.js') }}"></script>
	</head>
	<body>
		<div id="divPrincipal" style="position:relative;z-index:1;">
			<div id="divSpiner">
				<br>
				<v-container fluid fill-height style="position:absolute;z-index:3;">
					<v-layout justify-center align-center>
						<v-progress-circular indeterminate color="indigo lighten-4"></v-progress-circular>
					</v-layout>
				</v-container>
			</div>
			<v-app id="divApp" style="display:none;position:relative;z-index:2;">
				<v-navigation-drawer fixed clipped v-model="drawer" app dark>
					<v-list dense>
				        <template v-for="(item, i) in menu_sidebar">
				          	<v-list-group v-if="item.children" v-model="item.model" no-action>
					            <v-list-tile slot="item" @click="">
									<v-list-tile-action>
										<v-icon>@{{ item.model ? item.icon : item['icon-alt'] }}</v-icon>
									</v-list-tile-action>
									<v-list-tile-content>
										<v-list-tile-title>
									 		@{{ item.text }}
										</v-list-tile-title>
									</v-list-tile-content>
					            </v-list-tile>
				            	<v-list-tile v-for="(child, i) in item.children" :key="i" :href="child.href">
				                	<v-list-tile-action v-if="child.icon">
				                		<v-icon>@{{ child.icon }}</v-icon>
				              		</v-list-tile-action>
				              		<v-list-tile-content>
				                		<v-list-tile-title>
				                  			@{{ child.text }}
				                		</v-list-tile-title>
				              		</v-list-tile-content>
				            	</v-list-tile>
				          	</v-list-group>
				          	<v-list-tile v-else :href="item.href" v-on:click="cambiarSalir">
					            <v-list-tile-action>
					            	<v-icon>@{{ item.icon }}</v-icon>
					            </v-list-tile-action>
				            	<v-list-tile-content>
				            		<v-list-tile-title>
				                		@{{ item.text }}
				              		</v-list-tile-title>
				            	</v-list-tile-content>
				          	</v-list-tile>
				        </template>
					</v-list>
				</v-navigation-drawer>
				<v-toolbar color="indigo" dark fixed app>
					<v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
					<v-toolbar-title>Portal de Proveedores</v-toolbar-title>
		                <v-spacer></v-spacer>
						<v-btn icon>
							<v-icon>apps</v-icon>
						</v-btn>
					    <v-btn icon>
					    	<v-icon>notifications</v-icon>
					    </v-btn>
					    <v-menu offset-y>
					    	<v-btn icon slot="activator">
					    		@php  
									$avatarUser = Auth::user()->usrUrlimage;
									(strlen($avatarUser) > 10) ? $avatar=$avatarUser : $avatar="img/default.png";
								@endphp
						        <v-avatar size="32px" :tile="tile">
						        	<img class="avatar" width="32" height="32" src="{{ asset($avatar) }}" alt="">
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
									<v-list-tile href="{{ route('perfil') }}">
		                                <v-list-tile-action>
					                		<v-icon>face</v-icon>
					              		</v-list-tile-action>
		                                <v-list-tile-title>
		                                	<span>Mi perfíl</span>
		                                </v-list-tile-title>
		                            </v-list-tile>
									<v-list-tile href="{{ route('password') }}">
		                                <v-list-tile-action>
					                		<v-icon>settings_backup_restore</v-icon>
					              		</v-list-tile-action>
		                                <v-list-tile-title>
		                                	<span>Cambiar contraseña</span>
		                                </v-list-tile-title>
		                            </v-list-tile>
	            					@php
										$nroPerfiles = Session::get('nroPerfiles');
									@endphp
									@if (isset($nroPerfiles))
										@if ($nroPerfiles>1)
											<v-list-tile href="{{ route('accesos') }}">
				                                <v-list-tile-action>
							                		<v-icon>autorenew</v-icon>
							              		</v-list-tile-action>
				                                <v-list-tile-title>
				                                	<span>Cambio de acceso</span>
				                                </v-list-tile-title>
				                            </v-list-tile>
										@endif
									@endif
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
					<v-container fluid fill-height>
						<v-layout justify-center align-center>
		         			@yield('content')
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
		<script src="{{ asset('js/app/app.js') }}"></script>
	</body>
</html>