@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="#">{{ $thread->creator->name }}</a> posted:
                        {{ $thread->title }}</div>
                    <div class="panel-body">
                        {{$thread->body}}
                    </div>
                </div>
                {{-- only get paginated replies --}}
                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}

                @if(auth()->check())
                    <form method="POST" action="{{ $thread->path() . '/replies' }}">
                        {{ csrf_field() }}
                        <textarea name="body" id="body" class="form-control" placeholder="Add a comment" rows="5"></textarea>
                        <button type="submit" class="btn btn-default">Add</button>
                    </form>
                @else
                    <h4 class="text-center"><a href="{{ route('login') }}">Sign in</a> to participate in the discussion!</h4>
                @endif
            </div>


            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p>
                        This thread was published {{ $thread->created_at->diffForHumans() }} by <a href="#">{{$thread->creator->name}}</a>, and has {{ $thread->replies_count }}
                            {{-- how to pluralize any string--}}
                            {{str_plural('comment', $thread->replies_count)}} .
                        </p>
                    </div>

            </div>
        </div>

    </div>
@endsection