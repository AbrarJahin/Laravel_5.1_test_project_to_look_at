@extends('layouts.member.master')

@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">SMTP Servers
                <button type="button" class="btn btn-success pull-right" onclick="window.location.href='{{ URL::route('users.smtp.create', $userId) }}'">Create New SMTP Server</button> 
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <td>Name</td>
                    <td>SMTP Host</td>
                    <td>SMTP Username</td>
                    <td>#</td>
                    </thead>
                    <tbody>
                        @foreach($smtpList as $smtp)
                        <tr>
                            <td>{{ $smtp->name }}</td>
                            <td>{{ $smtp->host }}</td>
                            <td>{{ $smtp->username }}</td>
                            <td><a href="{{ route('users.smtp.edit',[$userId, $smtp->id]) }}">Edit</a>&nbsp;<a class="delete-resource" href="{{ route('users.smtp.destroy',[$userId, $smtp->id]) }}">Delete</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $smtpList->render() !!}
            </div>
        </div>
    </div>
</div>
@endsection