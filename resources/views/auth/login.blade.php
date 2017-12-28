@extends('layouts.index')
@section('content')
<v-layout justify-center align-center>
	<v-flex xs12 sm12 md4 xl4>
        <br>
        <v-card style="background-color: white;">
            <div class="divForm">
				<v-form v-model="validLogin" ref="formLogin" lazy-validation>
	                <v-card-title>
		                <v-layout row>
		                    <v-flex xs12>
		                    	<h3 class="text-xs-center">
		                        	Inicio de sesión
		                    	</h3>
		                    </v-flex>
		                </v-layout>
	                </v-card-title>
	                <v-layout row>
	                    <v-flex xs10 offset-xs1>
	                      <v-text-field label="Login" v-model="FormLogin.usrUserName" :rules="ReglaInput" mask="########-#" v-bind:return-masked-value="true" required></v-text-field>
	                    </v-flex>
	                </v-layout>
	                <v-layout row>
	                    <v-flex xs10 offset-xs1>
	                      <v-text-field label="Password" type="password" v-model="FormLogin.usrPassword" :rules="ReglaInput" required></v-text-field>
	                    </v-flex>
	                </v-layout>
	                <v-layout row>
	                    <v-flex xs10 offset-xs1>
	                        <v-checkbox label="Recordarme" v-model="FormLogin.remember" required></v-checkbox>
	                    </v-flex>
	                </v-layout>
	                <v-layout row>
	                    <v-flex class="text-xs-center">
	                        <v-btn style="float: center;" round color="primary" @click="postLogin" :disabled="!validLogin">
	                            Iniciar sesion
	                        </v-btn>
	                    </v-flex>
	                </v-layout>
	                <br>
	                <v-layout row>
	                    <v-flex class="text-xs-center">
	                        <a style="float: center;" href="#" @click="toggleLogin" >Olvido su contraseña?</a>
	                    </v-flex>
	                </v-layout>
				</v-form>
            </div>
            <div class="divForm" style="display:none;">
                <v-card-title>
	                <v-layout row>
	                    <v-flex xs12>
	                    	<h3 class="text-xs-center">
	                        	Recuperar contraseña
	                    	</h3>
	                    </v-flex>
	                </v-layout>
                </v-card-title>					                
	            <v-layout row>
                    <v-flex xs10 offset-xs1>
						<v-form v-model="validRescue" ref="formRescue" lazy-validation>
                      		<v-text-field label="E-mail" :rules="ReglaEmail" v-model="FormRescue.email" required></v-text-field>
						</v-form>
                    </v-flex>
                </v-layout>

                <v-layout row>
                    <v-flex xs6>
                        <v-btn style="float: right;" round outline color="primary" @click="toggleLogin">
                            volver
                        </v-btn>
                    </v-flex>
                    <v-flex xs6>
                        <v-btn round color="primary" @click="postRescue" :disabled="!validRescue">
                            Enviar
                        </v-btn>
                    </v-flex>
                </v-layout>
            </div>
        <br>
        </v-card>
    </v-flex>
</v-layout>      
@endsection