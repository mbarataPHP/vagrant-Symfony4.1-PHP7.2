<template>

    <div class="row">
        <div class="row">
            <div class="form-inline">
                <div class="form-group">
                    <label for="inputTitle">Titre</label>
                    <input type="text" v-model="title"  id="inputTitle" class="form-control mx-sm-3">
                </div>
                <div class="col-auto my-1">
                    <button :disabled="this.createText!=='Créer'" v-on:click="send" class="btn btn-success">{{ this.createText }}</button>
                </div>
            </div>
        </div><br>
        <div class="row">
            <pageList ref="pageList" />
        </div>

    </div>
</template>

<script>

    import PageList from './../component/PageList.vue';
    export default {
        name: 'index',
        data: function () {
            return {
                title: '',
                createText:'Créer'
            }
        },
        components: {
            'pageList':PageList
        },
        methods:{
            send: function (event) {
                var user = this.$session.get('user');
                var title = this.title;
                this.title = '';
                this.createText = 'Chargement';
                this.$http.post(process.env.APP_API+'/api/page/create?apikey='+encodeURIComponent(user.api_key), {title:title}).then( response => {
                    this.$refs.pageList.get();
                this.createText = 'Créer';
                });
            }
        }
    }
</script>