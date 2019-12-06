@extends('layouts.app')
@section('content')
    <div class="vue-app container-fluid">
        {{-- @include('library.layouts.topnavbar') --}}
        <library-home></library-home>
        {{-- @include('library.body') --}}
        {{-- @include('library.layouts.bottomnavbar') --}}
    </div>
@endsection