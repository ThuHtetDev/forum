<template>
        <li :id="'reply-'+id">
        <p>
            <a :href="'/profiles/'+reply.owner.name" >
          
                <img :src="avatar" alt="" class="mr-2" style="width:50px; height:50px; border-radius:50%;">
                <span v-text="reply.owner.name"></span>
       
            </a> said: <span v-text="ago"></span>..
         </p>
        <div class="mb-2">
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="" class="form-control" v-model="body" id="" cols="60" rows="5"></textarea>
                </div>
                <button class="btn btn-primary" @click="update()">
                    Update
                </button>
                <button class="btn btn-link" @click="cancel()">Cancel</button>
            </div>
            <div v-else v-text="body"> </div>
        </div>
        <div style="display:flex;">
        
                <div class="mr-4" v-if="signIn">
                    <favorite v-bind:reply="reply"></favorite>
                </div>
       

                <div v-if="canUpdate">
                    <button class="btn btn-info btn-sm mr-4" @click="editing = true">Edit This Reply</button>
                    <button class="btn btn-danger btn-sm" @click="deleteReply()">
                            Delete This Reply
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
                avatar: this.reply.owner.avatar_path ? this.reply.owner.avatar_path : '/storage/avatars/default_avatar.png'
            }
        },
        computed:{
            ago(){
                return moment(this.$props.reply.created_at).fromNow();
            },
            signIn(){
                return window.App.signIn;
            },
            canUpdate(){
                 return this.authorize(user => user.id == this.reply.user_id);
            }
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
            }
        }
    }
</script>