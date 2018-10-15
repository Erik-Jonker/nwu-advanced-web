@extends('layouts.app')

@section('vuecontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8-offset-md-8 col-lg-6 offset-lg-3">
                @if(Auth::user()->role  == 'customer')
                    <edit-profile :prop_user="{{Auth::user()}}"> </edit-profile>
                @elseif(Auth::user()->role == 'admin')
                    <manage-profiles> </manage-profiles>
                @else
                    <div class="alert alert-danger">You have no role assigned</div>
                @endif
            </div>
        </div>
    </div>

@endsection