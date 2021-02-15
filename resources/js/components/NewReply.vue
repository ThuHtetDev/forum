<template>
    <div class="container">
         <!-- @if(\Auth::check()) -->
                    <div class="row justify-content-center m-5" v-if="siginIn">
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <textarea   name="reply" 
                                                v-model="body" 
                                                class="form-control" 
                                                rows="10" cols="60"
                                                placeholder="How Do You Think?.."
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
        <!-- @else
            Please <a href="/login">Signin</a> to post this reply.
        @endif -->
    </div>
</template>

<script>
    export default {
        data:function(){
            return{
                body: '',
                siginIn: window.App.signIn
            }
        },
        methods:{
            addReply(){
                let self = this;
                axios.post('',{body: this.body})
                 .then(function( response ){
                    // Handle success
                    self.body = '';
                });
            }
        }
    }
</script>
