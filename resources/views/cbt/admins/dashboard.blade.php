@extends('layouts.app')
@section('content')
    <div class="vue-app">
        <admin-dashbaord  user="{{Auth::guard('admin')->user()}}"
        logout="{{ route('admin.logout') }}" csrfkey="" >
        </admin-dashbaord>
    </div>
@endsection
