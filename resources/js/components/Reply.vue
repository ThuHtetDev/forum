<script>
    export default {
        props: [
            'reply'
        ],
        data:function(){
            return {
                editing: false,
                body: this.$props.reply.body
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
                    location.reload();
                    flash('Your Reply has been updated');
                });

                this.editing = false;
            },
            cancel(){
                this.body = this.$props.reply.body;
                this.editing = false;
            }
        }
    }
</script>