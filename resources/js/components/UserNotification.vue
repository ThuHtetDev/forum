<template>
      <li class="nav-item dropdown">
            
                    <a id="navbarDropdown"  class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fa fa-bell"   style="color:#3490DC" aria-hidden="true"></i> Notifications
                        <span class="badge badge-danger rounded-pill spanText" ></span>
                    </a>
          
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" v-if="notifications.length <= 0">
                    <li>There is no notifications yet</li>
            </div>
            <div v-else class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" >
                    <li v-for="notification in notifications" :key="notification.id">
                        <a class="dropdown-item"  
                        :href="notification.data.link" 
                        v-text="notification.data.message"
                        @click="markAsRead(notification)">
                        </a>
                        <hr>
                    </li>
                  
            </div>
        </li>
</template>

<script>
    export default {
        data(){
            return{
                notifications: [],
                countNoti: ''
            }
        },
        mounted(){
   
        },
        created(){
            let self = this;
            axios.get('/profiles/'+window.App.user.name+'/notifications')
            .then(response => {
                self.notifications = response.data;
                self.countNoti = self.notifications.length;
                document.querySelector('.spanText').textContent = self.countNoti;
            })
          
        },
        methods:{
            markAsRead(notification){
                 axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id);
            }
        }
    }
</script>
