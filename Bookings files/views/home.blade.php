@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in! Sweet!
                        <br><br>

                    <a href="{{url('/bookings')}}" class="btn btn-outline-primary float-right ml-3">Go to bookings</a>
                    @if(Auth::user()->role=='admin')
                            <a href="{{url('/profiles')}}" class="btn btn-outline-primary float-right ml-3">Manage Profiles</a>
                            <a href="{{url('/services')}}" class="btn btn-outline-primary float-right">Manage services</a>
                    @else
                        <a href="{{url('/profiles')}}" class="btn btn-outline-primary float-right ml-3">Manage Profile</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
