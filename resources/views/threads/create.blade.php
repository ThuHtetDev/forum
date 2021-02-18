@extends('layouts.app')
@section('content')
<div class="container">
        @if(count($errors))
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    What's on my mind? create it..
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('thread.store') }}">
                        @csrf
                        <div class="form-group row">
                            <!-- <label for="channel" class="col-md-4 col-form-label text-md-right">Choose Channel</label> -->

                            <div class="col-md-12">
                                <select name="channel_id" class="form-control" id="" required>
                                    <option value="" disabled selected>Choose Channel ..</option>
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->id}}" {{old('channel_id') == $channel->id ? 'selected' : ''}}>{{$channel->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <!-- <label for="title" class="col-md-4 col-form-label text-md-right">Title</label> -->

                            <div class="col-md-12">
                                <input id="title" type="text" placeholder="Title Here.." class="form-control" name="title" value="{{ old('title') }}" required autocomplete="false" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <!-- <label for="body" class="col-md-4 col-form-label text-md-right">Description</label> -->

                            <div class="col-md-12">
                                <textarea name="body" placeholder="Description Here.." class="form-control" id="" rows="10" >{{ old('body') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Create Thread
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection