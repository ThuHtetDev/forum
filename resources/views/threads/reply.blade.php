<reply v-bind:reply="{{$reply}}" inline-template v-cloak>
    <li>
        <p>From <a href="{{route('user.profile',['user'=>$reply->owner->name])}}">{{$reply->owner->name}}</a> said:</p>
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
            <div class="mr-4">
                <favorite v-bind:reply="{{$reply}}"></favorite>
            </div>
            @can('updateReplyPermission',$reply)
                <div class="mr-4">
                    <button class="btn btn-info btn-sm" @click="editing = true">Edit This Reply</button>
                </div>
                <div>
                    <button class="btn btn-danger btn-sm" @click="deleteReply()">
                            Delete This Reply
                    </button>
                </div>
            @endcan
        </div>
        <hr>
    </li>
</reply>