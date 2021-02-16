<template>
        <div class="alert fade show alert-flash" :class="' alert-'+level" v-show="show" role="alert" v-text="body">
        </div>
</template>

<script>
    export default {
        props:[
            'message'
        ],
        data:function(){
            return{
                body: '',
                level: 'success',
                show: false
            }
        },
        created(){
            if(this.message){
                let data = {
                    message: this.message,
                    level: 'success'
                };
                this.flash(data);
            }
        

            window.events.$on('flash', data => {
                this.flash(data);
            });
        },
        methods:{
            flash(data){
                this.body = data.message;
                this.level = data.level;
                this.show = true;

                this.hide();
            },
            hide(){
                setTimeout(() => {
                    this.show = false;
                },5000);
            }
        }
    }
</script>

<style scoped>
.alert-flash{
    position:fixed;
    bottom: 25px;
    right: 25px;
}
</style>
