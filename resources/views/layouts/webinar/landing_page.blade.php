@extends('layouts.webinar.master')
@section('contents')
<div class="content slide">
    <ul class="responsive">
        <div class="top-header"> <h1>{{$webinar->title}}</h1> </div>
        {!! csrf_field() !!}
        <input type="hidden" id="webinar_id" value="{{ $webinar->id }}" />
        <li class="body-section">
            <div class="error_message" style="display:none; color: #e90d02"></div>

            <div class="sub">
                <h2>Reserve Your Spot! Webinar Registration</h2>
                <ul class="sub-container">
                    <li><input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Your First Name"></li>
                    <li><input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Your Last Name"></li>
                    <li><input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Email"></li>
                    <li><input class="btn btn-info optinForm" type="button" value="Register"></li>
                </ul>
            </div>
        </li>
    </ul>
</div>

@section('scripts')
<script type="text/javascript" src="{{ asset('scripts/webinar.js') }}"></script>
@endsection
@endsection