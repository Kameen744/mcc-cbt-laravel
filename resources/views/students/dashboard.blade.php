@extends('layouts.app')

@section('navbar')
    @include('layouts.navbar')
@endsection

@extends('layouts.app')
@section('content')
    <div class="vue-app">
        {{-- {{dd(Auth::guard('student')->user())}} --}}
        <student-dashbaord  user="{{Auth::guard('student')->user()}}"
        logout="{{ route('student.logout') }}">
        </student-dashbaord>
    </div>
@endsection
