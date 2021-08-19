<template>
    <span class="badge badge-pill badge-warning align-top">{{ basketCount }}</span>
</template>

<script>
    export default {
        props:{
            basketCount:{
                required:true
            }
        },
        mounted(){

        }
    }
</script>