<template>
                    <div class="row justify-content-center " v-if="siginIn">
                            <div class="form-group">
                                <div class="col-md-8">
                                    <textarea   name="reply" 
                                                v-model="body" 
                                                class="form-control" 
                                                rows="10" cols="60"
                                                placeholder="How Do You Think?.."
                                                id="replyBody"
                                                required>
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button @click="addReply()"
                                    class="btn btn-primary">
                                        Reply Comment
                                    </button>
                                </div>
                            </div>
                    </div>
                    <div v-else>
                            Please <a href="/login">Sign in</a> to post this reply.
                    </div>
</template>

<script>
    export default {
         props:['endpoint'],
        data:function(){
            return{
                body: '',
            }
        },
        mounted() {
                $('#replyBody').atwho({
                    at: "@",
                    delay:750,
                    callbacks: {
                        remoteFilter: function(query, callback) {
                            $.getJSON("/users", {name: query}, function(data) {
                                callback(data)
                            });
                        }
                    }
                });
        },
        computed:{
            siginIn(){
                return window.App.signIn;
            }
        },
        methods:{
            addReply(){
                let self = this;
                axios.post(this.endpoint,{body: this.body})
                .catch(error => {
                        flash(error.response.data, 'danger');
                    })
                    .then(({data}) => {
                        self.body = '';
                        flash('Your reply has been posted','success');
                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
