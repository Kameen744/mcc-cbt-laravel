@extends('layouts.app')
@section('content')
    <student-dashbaord  user="{{Auth::guard('student')->user()}}"
    logout="{{ route('student.logout') }}">
    </student-dashbaord>
@endsection
