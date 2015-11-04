@extends('layouts.member.master')
@section('contents')
<div class="row">
    <div class="errors-container">
        @include('errors.form')
    </div>

    {!! Form::open(array('url' => 'members/update-profile', 'class' => 'login-form fade-in', 'role' => 'form')) !!}

    <div class="col-md-12">
        <h1>Profile</h1>
    </div>

    <div class="col-md-4">
        <h3>Main Info</h3>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ $user->name }}">
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="name" name="email" placeholder="Enter Email" value="{{ $user->email }}">
        </div>
        
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
        </div>
        
        <div class="form-group">
            <label for="confirmpwd">Confirm Password:</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-Enter password">
        </div>
        
    </div>

    <div class="col-md-8">
        <h3>Contact Info</h3>

    </div>
    <div class="col-md-4">

        <div class="form-group">
            <label for="name">Contact Email</label>
            <input type="text" class="form-control" id="contact_email" name="contact_email"
                   placeholder="Contact Email" value="{{ $user->contact_email }}">
        </div>

        <div class="form-group">
            <label for="name">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone"
                   placeholder="Phone" value="{{ $user->phone }}">
        </div>

        <div class="form-group">
            <label for="name">Skype</label>
            <input type="text" class="form-control" id="skype" name="skype"
                   placeholder="Skype" value="{{ $user->skype }}">
        </div>

        <div class="form-group">
            <label for="name">Linked In Link</label>
            <input type="text" class="form-control" id="linkedin_link" name="linkedin_link"
                   placeholder="Linked In link" value="{{ $user->linkedin_link }}">
        </div>

    </div>
    <div class="col-md-4">

        <div class="form-group">
            <label for="name">Facebook Link</label>
            <input type="text" class="form-control" id="facebook_link" name="facebook_link"
                   placeholder="Facebook Link" value="{{ $user->facebook_link }}">
        </div>

        <div class="form-group">
            <label for="name">Twitter Link</label>
            <input type="text" class="form-control" id="twitter_link" name="twitter_link"
                   placeholder="Twitter Link" value="{{ $user->twitter_link }}">
        </div>

        <div class="form-group">
            <label for="name">Personal Site</label>
            <input type="text" class="form-control" id="site" name="site"
                   placeholder="Personal Site Link" value="{{ $user->site }}">
        </div>


    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    {!! Form::close() !!}

</div>
@endsection