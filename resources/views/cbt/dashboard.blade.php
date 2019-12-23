@extends('layouts.app')
@section('content')
    <exam-page  user="{{Auth::guard('cbt')->user()}}" 
        logout="{{ route('exam.logout') }}">
    </exam-page>
@endsection