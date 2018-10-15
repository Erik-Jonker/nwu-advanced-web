@extends('layouts.app')

@section('vuecontent')
    <edit-profile :prop_user="{{Auth::user()}}"></edit-profile>
@endsection