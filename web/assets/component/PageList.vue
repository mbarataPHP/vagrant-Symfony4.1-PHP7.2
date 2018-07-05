<template>
    <div v-if="display">
        <page v-for="page in pages" :page="page" v-bind:key="page.id" />
    </div>
    <div v-else>
        <loading />
    </div>
</template>

<script>
    import Page from './Page.vue';
    import Loading from './Loading.vue';

    export default {
        name: 'pageList',
        data () {
            return {
                pages:[],
                display:false
            }
        },
        created: function () {
            this.get();
        },
        components: {
            'page':Page,
            'loading':Loading
        },
        methods:{
          get(){

              var user = this.$session.get('user');

              this.$http.get(process.env.APP_API+'/api/page/', {params:  {apikey:user.api_key}}).then( response => {
                  this.pages = response.body;
                  this.display = true;
              });
          }
        }

    }
</script>