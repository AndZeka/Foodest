<template>
    <span class="badge badge-pill badge-warning align-top">{{ cartCount }}</span>
</template>

<script>
    export default {
        props:{
            cartCount:{
                required:true
            }
        },
        mounted(){

        }
    }
</script>