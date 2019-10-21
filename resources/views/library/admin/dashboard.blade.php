@extends('layouts.app')
@section('content')
    <div class="vue-app">
        <libadmin-dashbaord  user="{{Auth::guard('libadmin')->user()}}"
        logout="{{ route('lib.admin.logout') }}" csrfkey="" >
        </libadmin-dashbaord>
    </div>
@endsection