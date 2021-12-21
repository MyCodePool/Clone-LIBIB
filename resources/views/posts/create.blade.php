@extends('layouts.app')




@section('content')


    <form method="post" action="/posts">
        @csrf <!-- {{ csrf_field() }} -->
        <input type="text" name="title" placeholder="Enter Title"> <!-- title von Post -->

        <input type="submit" name="submit">

    </form>

@endsection