@extends('layouts.member.master')

@section('contents')
<?php
$webinar_description = "Title: ".$webinar->title."<br/>Description: ".$webinar->description."<br/>Host: ".$webinar->hosts; 
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Compose Email</div>
            <div class="panel-body">
                <form role="form" action="{{URL::route('webinars.emails.store', $webinar->id)}}" method="Post" onsubmit="return validateWebinarEmailForm();">
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject" value="{{ 'Webinar Invitation : '.$webinar->title }}" />
                    </div>
                    <div class="form-group">
                        <label for="pwd">Content:</label>
                        <textarea class="form-control mceEditor" rows="5" id="content" name="content"><?php echo $webinar_description;?></textarea>
                    </div>
                    
                    @if($smtpList)
                    <div class="form-group">
                        <label for="pwd">Select SMTP Method</label>
                        @foreach($smtpList as $smtp)
                        <div class="checkbox">
                            <label><input type="checkbox" value="{{ $smtp->id }}" name="smtp_method[]">{{ $smtp->name }}</label>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script type="text/javascript" src="{{ asset('tinymce/tiny_mce.js') }}"></script>
<script type="text/javascript" src="{{ asset('scripts/editor.js') }}"></script>
<script type="text/javascript" src="{{ asset('scripts/validation.js') }}"></script>
<!-- /TinyMCE -->

@endsection
@endsection