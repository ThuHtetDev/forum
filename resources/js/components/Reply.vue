<template>
        <li :id="'reply-'+id" :class="hasBest ? 'best' : ''">
        <div style="display:flex">
            <div style="flex:1;">
                    <a :href="'/profiles/'+reply.owner.name" >
                        <img :src="avatar" alt="" class="mr-2" style="width:50px; height:50px; border-radius:50%;">
                        <span v-text="reply.owner.name"></span>
                    </a> said: <span v-text="ago"></span>..
            </div>
            <div v-if="authorization('markBestReply',reply)">
                <div v-if="!hasBest">
                    <button class="btn btn-secondary btn-sm mt-2" @click="markAsBest">Mark As Best Reply</button>
                </div>
                <div v-else>
                    <i class="fas fa-check-circle fa-3x"  style="color:#18BC9C"></i>
                    <button class="btn btn-sm btn-default text-danger" @click="cancelBest">Cancel</button>
                </div>
            </div>
            <div v-else>
                <div v-if="hasBest">
                    <i class="fas fa-check-circle fa-3x"  style="color:#18BC9C"></i>
                </div>
            </div>
          
         </div>
        <div class="mb-2">
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="" class="form-control" v-model="body" id="" cols="60" rows="5"></textarea>
                </div>
                <button class="btn btn-primary btn-sm" @click="update()">
                    Update
                </button>
                <button class="btn btn-link btn-sm" @click="cancel()">Cancel</button>
            </div>
            <div v-else v-text="body" class="m-3"> </div>
        </div>
        <div style="display:flex;">
        
                <div class="mr-4" v-if="signIn">
                    <favorite v-bind:reply="reply"></favorite>
                </div>
       

                <div v-if="authorization('updateReply',reply)">
                    <button class="btn btn-info btn-sm mr-4" @click="editing = true">
                        <i class="fas fa-edit" style="color:#fff"></i>
                    </button>
                    <button class="btn btn-danger btn-sm" @click="deleteReply()">
                         <i class="fas fa-trash"></i>
                    </button>
                </div>
      
        </div>
        <hr>
    </li>
</template>
<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';
    export default {
        props: [
            'reply'
        ],
        components: {Favorite},
        data:function(){
            return {
                editing: false,
                body: this.$props.reply.body,
                id: this.reply.id,
                avatar: this.reply.owner.avatar_path ? this.reply.owner.avatar_path : '/storage/avatars/default_avatar.png',
                hasBest: this.$props.reply.isBest
            }
        },
        computed:{
            ago(){
                return moment(this.$props.reply.created_at).fromNow();
            },
      
        },
        created(){
            window.events.$on('mark-this-best', id =>{
                if(id == this.reply.id){
                    this.hasBest = true;
                }else{
                    this.hasBest = false;
                }
            });

             window.events.$on('cancel-this-best', id =>{
                if(id == this.reply.id){
                    this.hasBest = false;
                }
            });

            
        },
        methods:{
            update(){
                if(this.body == '') return;

                axios.patch('/replies/'+this.$props.reply.id,{
                    body: this.body
                })
               .then(function( response ){
                    // Handle success
                    flash('Your Reply has been updated');
                });

                this.editing = false;
            },
            cancel(){
                this.body = this.$props.reply.body;
                this.editing = false;
            },
            deleteReply(){
                axios.delete('/replies/'+this.$props.reply.id);
                this.$emit('deleted',this.reply.id);
            },
            markAsBest(){
                axios.post('/replies/'+this.$props.reply.id+'/best-reply');
                flash('Your found best reply','success');
                window.events.$emit('mark-this-best',this.reply.id);
            },
            cancelBest(){
                axios.post('/replies/'+this.$props.reply.id+'/remove-best-reply');
                flash('Your just deleted best reply','success');
                window.events.$emit('cancel-this-best',this.reply.id);
            }
        }
    }
</script>

<style scoped>
.best{
 
}
</style>