<template>
    <div class="container">
        <h2 class="text-center">Captura tus ideas</h2>
        <div class="well">
            <form>
                <div class="input-group">   
                    <v-text-field label="¿En que estas pensando?"></v-text-field>
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn--round theme--dark primary">Agregar</button>
                    </span>
                </div>
            </form>
            <hr>
            <ul class="list-unstyled">
                <li v-for="idea in ideas">
                    <p>
                        <small class="text-muted">
                            <em>
                                {{ idea.created_at }}
                            </em>
                        </small>
                        {{ idea.description }}
                    </p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                ideas:[],
            }

        },
        created: function(){
            this.getIdeas();
            console.log("cargado el componente");
        },
        methods:{
            getIdeas: function(){
                var urlIdeas = 'mis-ideas';
                axios.get(urlIdeas).then(response=>{
                    this.ideas = response.data
                });
            }
        }
    }
</script>
