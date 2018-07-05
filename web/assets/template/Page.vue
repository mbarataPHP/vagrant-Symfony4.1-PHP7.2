<template>
    <div>
        <div v-if="display">
            <div class="col-4">
                <div class="form-group row">
                    <label for="description">Description</label>
                    <textarea v-model="description" class="form-control" id="description"></textarea>
                </div>
                <button :disabled="this.submitText!=='Envoyer'" type="submit" class="btn btn-primary" v-on:click="send">{{ this.submitText }}</button>
            </div>
            <div class="col-8">
                <div class="row">
                    <h1>{{ page.title }}</h1>
                </div>
                <div class="row">
                    <articleComponent v-for="articleComponent in articleComponents" :articleComponent="articleComponent" v-bind:key="articleComponent.id" />

                </div>
            </div>
        </div>

        <div v-else>
            <loading />
        </div>
    </div>
</template>

<script>
    import Loading from './../component/Loading.vue';
    import ArticleComponent from './../component/ArticleComponent.vue';
    export default {
        name: 'templatePage',
        data () {
            return {
                display: true,
                title:'',
                page:{},
                description:'',
                articleComponents:[],
                submitText: 'Envoyer'
            }
        },
        created: function () {
            this.get();
        },
        methods:{
          get(){
              var user = this.$session.get('user');
              this.display = false;

              this.$http.get('api/page/get/'+this.$route.params.id, {params:  {apikey:user.api_key}}).then( response => {
                  this.page = response.body;
                this.articleComponents = response.body.articles;
                this.display = true;
            });
          },
          send(){
              var description = this.description;
              var user = this.$session.get('user');
              this.description = '';
              this.submitText = 'chargement';

              this.$http.post(process.env.APP_API+'/api/article/add/'+this.$route.params.id+'?apikey='+encodeURIComponent(user.api_key), {description:description}).then( response => {
                  this.submitText = 'Envoyer';
                  this.get();

              });
          }
        },
        components: {
            'loading':Loading,
            'articleComponent':ArticleComponent
        }


    }
</script>