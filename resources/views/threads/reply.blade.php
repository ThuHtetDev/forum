<reply v-bind:reply="{{$reply}}" inline-template v-cloak>
    <li id="reply-{{$reply->id}}">
        <p>
            <a href="{{route('user.profile',['user'=>$reply->owner->name])}}">
          
                <img src="{{$reply->owner->avatar()}}" alt="" class="mr-2" style="width:50px; height:50px; border-radius:50%;">
       
                {{$reply->owner->name}}
            </a> said: <span v-text="ago"></span>..
         </p>
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
            @if(\Auth::check())
                <div class="mr-4">
                    <favorite v-bind:reply="{{$reply}}"></favorite>
                </div>
            @endif
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