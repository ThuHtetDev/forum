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
                <form action="{{route('reply.favorite',['reply' => $reply->id ]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">
                        {{$reply->favorites_count}} {{\Str::plural('Like',$reply->favorites_count)}}
                    </button>
                </form>
            </div>
            <div class="mr-4">
                <button class="btn btn-info btn-sm" @click="editing = true">Edit This Reply</button>
            </div>
            @can('updateReplyPermission',$reply)
                <div>
                    <form action="{{route('reply.destory',['reply'=>$reply])}}" method="POST">
                        @method('delete')
                        @csrf 
                        <button type="submit" class="btn btn-danger btn-sm">
                            Delete This Reply
                        </button>
                    </form>
                </div>
            @endcan
        </div>
        <hr>
    </li>
</reply>