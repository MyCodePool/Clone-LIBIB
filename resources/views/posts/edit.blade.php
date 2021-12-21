@extends('layouts.app')




@section('content')

    <h1>Edit Post</h1>

    <form method="post" action="/posts/{{ $post->id }}">
        <!--@csrf <-- {{ csrf_field() }} ---->

        {{ csrf_field() }}

        <input type="hidden" name="_method" value="PUT">

        <input type="text" name="title" value="{{ $post->title }}"> <!-- title von Post -->

        <input type="submit" name="submit" value="UPDATE">

    </form>

    <h1>Delete Post</h1>

    <form method="post" action="/posts/{{ $post->id }}">

        {{ csrf_field() }}

        <input type="hidden" name="_method" value="DELETE">

        <input type="submit" name="submit" value="DELETE">

    </form>

@endsection