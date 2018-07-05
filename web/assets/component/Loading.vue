<template>

    <div  v-bind:class="[!display ? 'text-hide' : '', 'alert', 'alert-primary']" role="alert">
        Chargement
    </div>

</template>

<script>
    export default {
        name: 'loading',
        data () {
            return {
                display: true
            }
        },
        methods:{
            hide:function(){
                this.display = false;
            },
            show:function(){
                this.display = true;
            }
        }

    }
</script>