@extends('layouts.app')
@section('vuecontent')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1 col-lg-10 offset-lg-1">

                @if(Auth::user()->role == 'admin')

                    <admin-bookings></admin-bookings>

                @elseif(Auth::user()->role == 'customer')

                    <personal-bookings :prop_user="{{auth()->user()}}"></personal-bookings>

                @else

                    <div class="alert alert-danger" role="alert">You have no role assigned</div>

                @endif

        </div>
    </div>
</div>
@endsection
