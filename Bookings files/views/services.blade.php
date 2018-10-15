@extends('layouts.app')
@section('vuecontent')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-10 offset-md-1 col-lg-6 offset-lg-3">

                @if(Auth::user()->role == 'admin')

                    <manage-services></manage-services>

                @else

                    <div class="alert alert-danger" role="alert">You do not have access to modify services</div>

                @endif

            </div>
        </div>
    </div>
@endsection