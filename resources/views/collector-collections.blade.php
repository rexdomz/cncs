@extends('layouts.master')

@section('content')

<collector-view-only :user-name={{ Auth::user()->name }}></collector-view-only>

@endsection