@extends('layouts.master')

@section('content')
    <div class="col-sm-8 blog-main">
        <h1>{{ $post->title }}</h1>
        {{ $post->body }}


        <div class="comments">
            <ul class="list-group">
                @foreach($post->comments as $comment)
                    <li class="list-group-item">

                        <strong> {{ $comment->created_at->diffForHumans() }}: &ensp;</strong>

                        {{ $comment->body }}

                    </li>
                @endforeach
            </ul>
        </div>


    </div>
@endsection