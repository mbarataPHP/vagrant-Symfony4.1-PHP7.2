<template>
    <div class="row  col-12">
        <div class="card">
            <div class="card-body">
                {{ articleComponent.description }}
            </div>
        </div><br/>
    </div>
</template>

<script>

    export default {
        name: 'articleComponent',
        props: {
            articleComponent:Object
        }

    }
</script>