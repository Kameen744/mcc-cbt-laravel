@extends('layouts.app')
    @section('content')
        <!-- Outer Row -->
<div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 p-0">
            
        <img src="{{asset('storage/images/logo.png')}}" alt="MCCHST LOGO" class="mt-4 mb-2" style="width: 200px; height:200px; margin:auto;">
            <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-8 mb-5 pb-5">
                        <form method="POST" action="{{ route('student.login') }}" class="user">
                            @csrf
    
                            <div class="form-group">
                                <input type="text" 
                                class="form-control form-control-user shadow-lg @error('appnumber') is-invalid @enderror" 
                                name="appnumber" placeholder="Enter your application no..." value="{{ old('appnumber') }}">
    
                                @error('appnumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user shadow-lg @error('password') is-invalid @enderror" 
                                name="password" placeholder="Password..." >
    
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-user btn-block shadow-lg">
                                Login
                            </button>
                        </form>   
                </div>
            </div>
            </div> 
        </div>
        </div>
    </div>
    @endsection