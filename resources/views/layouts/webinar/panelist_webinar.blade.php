@extends('layouts.webinar.master')

@section('contents')


<h3>GTW Hero Webinar</h3>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3><p class="text-center">Best Lead Generation system</p></h3>
    </div>
    <div class="panel-body">
        <div class="col-md-8">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="http://www.youtube.com/embed/XGSy3_Czz8k"></iframe>
            </div>
        </div>
        <div class="col-md-4">
            <h5>Enter User Details:</h5>
            <form class="form-inline">
                <div class="form-group">
                    <label class="sr-only" for="exampleInputEmail3">Name</label>
                    <input type="text" class="form-control" placeholder="Enter Name">
                </div>
                <button type="submit" class="btn btn-default">Save</button>
            </form>
            <br/>
            <p><strong>Vote</strong></p>
            <div class="btn-group">
                <button type="button" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span> Yes</button>
                <button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-thumbs-down"></span> No</button>
            </div>
            
            <br/><br/>
            <div class="form-group">
                <label for="sharedUrl">Shared URLs:</label>
                <textarea class="form-control" rows="5" id="comment">https://www.google.com</textarea>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <h3>My questions</h3>
            
        <div class="pre-scrollable" style="border: 1px solid;">
            <ul class="list-group">
                <li class="list-group-item">What is webinar?</li>
                <li class="list-group-item">How Can I install webinar?</li>
                <li class="list-group-item">How webinar is useful?</li>
            </ul>
        </div>    
        <br/>
        <div class="form-group">
            <input type="text" class="form-control" id="inputEmail" placeholder="Ask your question here?">
            <br/>
            <button type="submit" class="btn btn-primary">Send</button>
        </div>
    </div>

    <div class="col-md-5">
        <h3>Public questions</h3>
        <div class="pre-scrollable" style="border: 1px solid;">
            <ul class="list-group">
                <li class="list-group-item">What is webinar?</li>
                <li class="list-group-item">How Can I install webinar?</li>
                <li class="list-group-item">How webinar is useful?</li>
                <li class="list-group-item">What is webinar?</li>
                <li class="list-group-item">How Can I install webinar?</li>
                <li class="list-group-item">How webinar is useful?</li>
                <li class="list-group-item">What is webinar?</li>
                <li class="list-group-item">How Can I install webinar?</li>
                <li class="list-group-item">How webinar is useful?</li>
                <li class="list-group-item">What is webinar?</li>
                <li class="list-group-item">How Can I install webinar?</li>
                <li class="list-group-item">How webinar is useful?</li>
                <li class="list-group-item">What is webinar?</li>
                <li class="list-group-item">How Can I install webinar?</li>
                <li class="list-group-item">How webinar is useful?</li>
            </ul>
        </div>
    </div>
</div>


@stop