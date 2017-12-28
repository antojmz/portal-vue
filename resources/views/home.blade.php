<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>Laravel - Componentes Vue</title> 
	<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
	<link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet"> 
</head>
<body>
	<div id="app">
		<v-app id="inspire">
			<v-navigation-drawer fixed clipped v-model="drawer" app dark>
				<v-list dense>
					<v-list-tile @click="">
						<v-list-tile-action>
							<v-icon>home</v-icon>
						</v-list-tile-action>
						<v-list-tile-content>
							<v-list-tile-title>Home</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
					<v-list-tile @click="">
						<v-list-tile-action>
							<v-icon>contact_mail</v-icon>
						</v-list-tile-action>
						<v-list-tile-content>
							<v-list-tile-title>Contact</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
				</v-list>
			</v-navigation-drawer>
			<v-toolbar color="indigo" dark fixed app>
				<v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
				<v-toolbar-title>Application</v-toolbar-title>
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
	<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
