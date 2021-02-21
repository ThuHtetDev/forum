<script>
    import Replies from './Replies.vue';
    export default {
        props:['initialReplyCount'],
        components:{
            Replies
        },
       data(){
           return {
               repliesCount: this.initialReplyCount
           }
       }
    }
</script>
