@extends('layouts.member.master')

@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Notification Templates
                <button type="button" class="btn btn-success pull-right" onclick="window.location.href='{{ URL::route('users.notification-templates.create', $userId) }}'">Create New Notification Template</button>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <td>Subject</td>
                    <td>Description</td>
                    <td>#</td>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notification)
                        <tr>
                            <td>{{ $notification->subject }}</td>
                            <td>{!! $notification->content !!}</td>
                            <td><a href="{{ route('users.notification-templates.edit',[$userId, $notification->id]) }}">
                                    Edit
                                </a>
                                &nbsp;
                                <a class="delete-resource"
                                   href="{{ route('users.notification-templates.destroy',[$userId, $notification->id]) }}">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $notifications->render() !!}
            </div>
        </div>
    </div>
</div>
@endsection