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
                body: this.$props.reply.body
            }
        },
        computed:{
            ago(){
                return moment(this.$props.reply.created_at).fromNow();
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
                $(this.$el).fadeOut(300,function(){
                        flash('Your Reply has been delete');
                });
            }
        }
    }
</script>