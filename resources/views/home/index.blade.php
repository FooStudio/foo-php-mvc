@extends('layout')

@section('content')
    <h1>Blog</h1>

    <h3>Posts</h3>
    {{url('home')}}
    <ul>
        @foreach($posts as $post)
            <li>
                <a href="/posts/{{$post->key_url}}">{{$post->title}}</a>
            </li>
        @endforeach
    </ul>

    <h3>Authors</h3>
    <ul>
        @foreach($authors as $author)
            <li>
                {{$author->name}}
            </li>
        @endforeach
    </ul>
@endsection