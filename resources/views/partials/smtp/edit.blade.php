@extends('layouts.member.master')

@section('contents')
<div class="row">
    <div class="errors-container">
        @include('errors.form')
    </div>
    <?php
        $enabled = false;
        if(Input::old('enabled')){
            $enabled = true;
        } else if($smtp->enabled == 1){
            $enabled = true;
        }
    ?>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Edit SMTP Server</div>
            <div class="panel-body">
                {!! Form::open(['url' => route('users.smtp.update', [$smtp->customer_id, $smtp->id]), 'method'=> "PUT", 'onsubmit' => 'return validateSmtpForm()']) !!}
                    <div class="form-group">
                        <label for="subject">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo (Input::old('name')) ? Input::old('name') : $smtp->name;?>" placeholder="Name" />
                    </div>
                    <div class="form-group">
                        <label for="pwd">Hostname:</label>
                        <input type="text" class="form-control" id="host" name="host" value="<?php echo (Input::old('host')) ? Input::old('host') : $smtp->host;?>" placeholder="smtp.your-server.com" />
                    </div>
                    <div class="form-group">
                        <label for="pwd">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?php echo (Input::old('username')) ? Input::old('username') : $smtp->username;?>" placeholder="you@domain.com" />
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="text" class="form-control" id="password" name="password" value="<?php echo (Input::old('password')) ? Input::old('password') : $smtp->password;?>" placeholder="your smtp account password" />
                    </div>
                    <div class="form-group">
                        <label for="pwd">Port:</label>
                        <input type="text" class="form-control" id="port" name="port" value="<?php echo (Input::old('port')) ? Input::old('port') : $smtp->port;?>" placeholder="port" />
                    </div>
                    <div class="form-group">
                        <?php
                        $protocol = (Input::old('protocol')) ? Input::old('protocol') : $smtp->protocol;
                        ?>
                        <label for="pwd">Protocol:</label>
                        <select class="form-control" id="protocol" name="protocol">
                            <option value="">Choose</option>
                            <option value="tls" <?php echo ($protocol  == 'tls') ? 'selected="selected"' : '';?>>TLS</option>
                            <option value="ssl" <?php echo ($protocol  == 'ssl') ? 'selected="selected"' : '';?>>SSL</option>
                            <option value="starttls" <?php echo ($protocol  == 'starttls') ? 'selected="selected"' : '';?>>STARTTLS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pwd">From Email:</label>
                        <input type="text" class="form-control" id="from_email" name="from_email" value="<?php echo (Input::old('from_email')) ? Input::old('from_email') : $smtp->from_email;?>" placeholder="you@domain.com" />
                    </div>
                    <div class="form-group">
                        <label for="pwd">From Name:</label>
                        <input type="text" class="form-control" id="from_name" name="from_name" value="<?php echo (Input::old('from_name')) ? Input::old('from_name') : $smtp->from_name;?>" placeholder="From Name" />
                    </div>
                    <div class="form-group">
                        <label for="pwd">Reply-To Email:</label>
                        <input type="text" class="form-control" id="reply_email" name="reply_email" value="<?php echo (Input::old('reply_email')) ? Input::old('reply_email') : $smtp->reply_email;?>" placeholder="you@domain.com" />
                    </div>
                
                    <div class="form-group">
                        <input type="checkbox" id="enabled" name="enabled" {{ ($enabled) ? 'checked="checked"' : '' }}>
                        <label for="enabled">Enabled</label>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <input type="text" class="form-control" id="message" name="message" value="" placeholder="Text Message" />
                        <p class="help-block">Note: Enter Message and Hit "Test SMTP" Button to test smtp</p>
                    </div>
                    <button type="submit" id="smtp_submit_button" class="btn btn-primary">Submit</button>
                    <button type="button" id="smtp_test_button" class="btn btn-primary testSmtp">Test SMTP</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script type="text/javascript" src="{{ asset('scripts/validation.js') }}"></script>
@endsection
@endsection