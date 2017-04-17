@extends('layout')

@section('content')
    <h1>Blog</h1>
    <ul>
        @foreach($posts as $post)
            <li>
                <a href="/posts/{{$post->key_url}}">{{$post->title}}</a>
            </li>
        @endforeach
    </ul>
@endsection