<template>


    <div v-if="display">
        <div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input type="email" v-model="email" v-bind:class="['form-control', error]" id="inputEmail" aria-describedby="emailHelp" placeholder="email">
            </div>
            <div class="form-group">
                <label for="inputPassword">Mot de passe</label>
                <input type="password" v-model="password"  v-bind:class="['form-control', error]" id="inputPassword" placeholder="mot de passe">
            </div>
            <button  class="btn btn-primary" v-on:click="send">Envoyer</button>
        </div>
    </div>
    <div v-else>
        <loading />
    </div>


</template>

<script>
    import Loading from './../component/Loading.vue';
    export default {
        name: 'login',
        data: function () {
            return {
                email: '',
                password: '',
                display:true,
                error: ''
            }
        },
        methods: {
            send: function (event) {
                this.display = false;
                this.error = '';
               // console.log(this.email, this.password);
                var tab = {};
                tab['username'] = this.email;
                tab['password'] = this.password;
                this.$http.post(process.env.APP_API+'/security/login', tab).then( response => {
                    this.display = true;
                    //this.message = response.data.message;

                    this.$session.start();
                    this.$session.set('user', response.body);
                    this.$parent.isConnect = true;
                    this.$router.push({ name: "Index"});
                }, response => {
                    // error callback
                    this.display = true;
                    this.error = 'is-invalid';
                });


            }
        },
        components: {
            'loading':Loading
        }
    }
</script>