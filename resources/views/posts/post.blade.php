@extends('layout')

@section('content')
    <h2>{{$post->title}}</h2>
    <img src="{{$post->cover}}" alt="">
    <p>{{$post->body}}</p>
    <p>Author: <a href="/authors/{{$post->author->key_url}}">{{$post->author->name}}</a></p>
@endsection