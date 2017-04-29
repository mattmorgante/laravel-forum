@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}</div>
                    <div class="panel-body">
                        {{$thread->body}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        @if(auth()->check())
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form method="POST" action="{{ $thread->path() . '/replies' }}">
                        {{ csrf_field() }}
                        <textarea name="body" id="body" class="form-control" placeholder="Add a comment" rows="5"></textarea>
                        <button type="submit" class="btn btn-default">Add</button>
                    </form>
                </div>
            </div>
        @else
            <h4 class="text-center"><a href="{{ route('login') }}">Sign in</a> to participate in the discussion!</h4>
        @endif
    </div>
@endsection