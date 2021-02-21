<template>
    <div >
        <div v-for="(reply,index) in items" :key="reply.id">
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>
        <new-reply :endpoint="pathName" @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    export default {
        props: ['data'],
        components:{Reply,NewReply},
        data(){
            return{
                items: this.data,
                pathName: location.pathname + '/replies'
            }
        },
        methods:{
            add(reply){
                this.items.push(reply);
                this.$emit('added');
            },
            remove(index){
                this.items.splice(index,1);
                this.$emit('removed');
                flash('Your Reply has been deleted');
            }
        }
    }
</script>
