<template>

    <div id="app" class="container">


        <div v-if="display">
            <div v-if="isConnect">
                <nav class="navbar navbar-light bg-light">
                    <button class="navbar-brand btn btn-link" @click="menu()">Menu</button>
                    <div class="form-inline">
                        <button :disabled="this.testDeconnect!=='Déconnexion'" class="btn btn-outline-danger my-2 my-sm-0" @click="deconnexion()">{{ this.testDeconnect }}</button>
                    </div>
                </nav>
            </div>
            <router-view/>
        </div>
        <div v-else>
            <loading />
        </div>

    </div>

</template>

<script>
    import Loading from './component/Loading.vue';
    export default {
        name: 'app',
        data () {
            return {
                display: false,
                isConnect:false,
                testDeconnect:'Déconnexion'
            }
        },
        created: function () {

            if (!this.$session.exists()) { //la session n'est pas active
                this.display = true;
                this.$router.push({ name: "Login"});

            }else{ //la sessione est active

                var user = this.$session.get('user');

                this.$http.get(process.env.APP_API+'/api/user/', {params:  {apikey:user.api_key}}).then( response => {
                    this.display = true;
                    this.isConnect = true;
                    this.$session.set('user', response.body);
                }, response => {
                    this.display = true;
                    this.isConnect = false;
                    this.$router.push({ name: "Login"});
                });


            }


        },
        methods: {
            menu(){
                this.$router.push({ name: "Index"});
            },
            deconnexion(){
                this.testDeconnect = 'Chargement';
                var user = this.$session.get('user');
                this.$http.get(process.env.APP_API+'/security/logout', {params:  {apikey:user.api_key}}).then( response => {
                    this.isConnect = false;
                    this.testDeconnect = 'Déconnexion';
                    this.$router.push({ name: "Login"});
                });
            }
        },
        components:{
            'loading':Loading
        }
    }
</script>