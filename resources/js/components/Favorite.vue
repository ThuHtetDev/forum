<template>
        <div class="fav" @click="addFav()">
            <span v-text="favCount"></span>
            <span v-if="isFavorited"><i class="fas fa-heart fa-2x"  style="color:red"></i></span>
            <span v-else><i class="far fa-heart fa-2x"  style="color:red"></i></span>
        </div>
</template>

<script>
    export default {
        props:['reply'],
        data:function(){
            return {
                favCount: this.$props.reply.favorites_count,
                isFavorited: this.$props.reply.isFavorited
            }
        },
        methods:{
            addFav(){
                let self = this;
                axios.post('/replies/'+this.$props.reply.id+'/favorite')
                .then(function( response ){
                    // Handle success
                    self.isFavorited = response.data;
                    if(response.data == true){
                        self.favCount++;
                    }else{
                        self.favCount--;
                    }
                });
            }
        }
    }
</script>

<style scoped>
.fav{
    cursor: pointer;
}
</style>