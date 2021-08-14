<template>
    <a href="#" @click.prevent="addToCart">Add to cart &#10152;</a>
</template>

<script>
export default {
    data(){
        return{

        }
    },
    methods:{
        addToCart(){
            alert('addToCart');
        }
    }
}
</script>
