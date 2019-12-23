@extends('layouts.app')
@section('content')
    <admin-dashbaord  user="{{Auth::guard('admin')->user()}}"
    logout="{{ route('admin.logout') }}" csrfkey="" >
    </admin-dashbaord>
@endsection
