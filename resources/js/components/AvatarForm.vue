<template>
    <div style="display:flex;">
            <div style="flex:1;">
                    <h1 class="display-4" v-text="user.name"></h1>
                    <p class="lead">
                        Member Since {{ago}}
                    </p>
                 
                        <form v-if="canUpdate" action="" method="POST" enctype="multipart/form-data" @submit.prevent="uploadFile">
                            <image-upload @loaded="onLoaded"></image-upload>

                            <button type="submit" class="btn btn-primary" >Upload</button>
                        </form>
               
            </div>
            <div>
                <img :src="avatar" alt="" style="width:200px; height:200px; border-radius:50%;">
            </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import ImageUpload from './ImageUpload.vue';

    export default {
        props: ['user'],
        components:{ ImageUpload },
        data(){
            return{
                avatar: this.user.avatar_path ? this.user.avatar_path : '/storage/avatars/default_avatar.png',
                chosenFile: ''
            }
        },
        computed:{
            canUpdate(){
                return this.authorize(user => user.id == this.user.id);
            },
            ago(){
                return moment(this.$props.user.created_at).fromNow();
            }
        },
        methods:{
            uploadFile(){
                if(this.chosenFile == '') return;
                let data = new FormData;
                data.append('avatar',this.chosenFile);
                 axios.post('/profiles/'+this.$props.user.id+'/avator',data)
                .then(function( response ){
                    // Handle success
                    flash('Avatar Uploaded');
                });
            },
            onLoaded(data){
                this.avatar = data.src;
                this.chosenFile = data.file;
            }
        }
    }
</script>
