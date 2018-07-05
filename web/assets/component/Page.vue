<template>

    <div class="row media">
        <br>
        <div class="media-body col-md-6">
            <div class="media-body">
                <div class="row">

                    <div class="col-md-6">
                        <h3 class="mt-0">{{ page.title }}</h3>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary" @click="redirect()">afficher</button>
                    </div>
                </div>
                <div class="row">
                    <span>
                        {{ page.info }}
                    </span>
                </div>
            </div>

        </div>
    </div>

</template>

<script>

    export default {
        name: 'page',
        props: {
            page: Object
        },
        methods:{
            redirect(){
                this.$router.push({
                    name: 'Page',
                    params: { id: this.page.id }
                });
            }
        }
    }
</script>