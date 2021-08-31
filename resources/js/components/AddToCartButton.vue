<template>
    <a href="#" @click.prevent="addToCart">Add to cart &#10152;</a>
</template>

<script>
export default {
    props:{
        product:{
            required: true
        }
    },
    data(){
        return{
            count:''
        }
    },
    mounted(){
    },
    methods:{
        async addToCart(){
            var vm = this;
            this.$Progress.start();
            await axios.post('/basket', {product_id: this.product.id})
            .then(function(response) {
                toast.fire({
                    icon: "success",
                    title: "Food added to cart!",
                });
                vm.count = response.data.basket_count;
                this.$Progress.finish();      
            }).catch(() => {
                this.$Progress.fail();
            });
            this.$root.$emit('changeBasketCount', this.count);
        }
    }
}
</script>
