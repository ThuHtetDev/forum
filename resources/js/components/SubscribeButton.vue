<template>
    <div class="container">
        <button :class="classes" @click="subscribe()">
               {{ this.isActive ? "Unsubscribe" : "Subscribe" }}
        </button>
    </div>
</template>

<script>
    export default {
        props:['active'],
        data(){
            return{
                isActive: this.active
            }
        },
        computed:{
            classes(){
                return ['btn', 'btn-xs',this.isActive ? 'btn-secondary' : 'btn-danger'];
            }
        },
        methods:{
            subscribe(){
                let self = this;
                axios[(this.isActive ? 'delete' : 'post')](location.pathname +'/subscriptions')
                .then(function( response ){
                    // Handle success
                    let msg = self.isActive ? 'You unsubscribed this thread' : 'You subscribed this thread';
                    self.isActive = !self.isActive;
                    flash(msg);
                });

                // this.isActive = !this.isActive;
            }
        }
    }
</script>
