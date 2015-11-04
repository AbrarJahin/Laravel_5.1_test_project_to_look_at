@extends('layouts.member.master')

@section('contents')
    @include('errors.form')

    <style>

        .nav-pills>li.active>a, .nav-pills>li.active>a:hover, .nav-pills>li.active>a:focus {
            color: #fff;
            background-color: #4b6a7d;
        }

        .nav>li>a {
            text-decoration: none;
            background-color: #eee;
        }

        .nav>li>a:hover, .nav>li>a:focus {
            text-decoration: none;
            background-color: #c7c7c7;
        }
    </style>

    <div class="panel panel-default">
        <div class="panel-heading">Edit Webinar.
            <a class="btn btn-info pull-right" style="margin-left: 5px" href="{{ URL::to('members/webinar/'. $webinar->uuid) }}" target="_blank">Webinar Host</a>
            <!--<a class="btn btn-success pull-right" href="{{ URL::route('webinars.emails.create', $webinar->uuid) }}" target="_blank">Send Email</a>-->
            <a class="btn btn-purple pull-right" href="{{route('users.webinars.clone', [$user->id,$webinar->uuid])}}">Clone Webinar</a>

        </div>
        <div class="panel-body">
            <div class="col-md-12">
                {{--<<<Firs tab start>>>--}}
                <ul class="nav nav-pills nav-justified" role="tablist">
                    <li role="presentation"><a href="#tab-customize" aria-controls="tab-customize" role="tab" data-toggle="tab">Customize</a></li>
                    <li role="presentation" class="active"><a href="#tab-stats" aria-controls="tab-stats" role="tab" data-toggle="tab">Stats</a></li>
                    <li role="presentation"><a href="#tab-notifications" aria-controls="tab-notifications" role="tab" data-toggle="tab">Notifications</a></li>
                </ul>
                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane" id="tab-customize">
                        <div class="col-md-12">
                            <hr class="tall">
                            {!! Form::open(['url' => route('users.webinars.update', [$user->id,$webinar->id]), 'method'=> "PUT",
                         'id' => 'webinarForm']) !!}
                            <div class="row">
                                <div class="form-group">
                                    <label>Webinar Title</label>
                                    <input type="text" value="{{$webinar->title}}" class="form-control" id="name" name="title"
                                           placeholder="Webinar title">
                                </div>
                                <div class="form-group">
                                    <label>Webinar Description</label>
                        <textarea class="form-control" placeholder="Description" name="description" id="" cols="30"
                                  rows="10">{{$webinar->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Webinar Hosts</label>
                                    <input type="text" class="form-control" id="hosts" value="{{$webinar->hosts}}" name="hosts"
                                           placeholder="Webinar hosts">
                                </div>
                                <div class="form-group">
                                    <label>Shared Links</label>
                        <textarea class="form-control" placeholder="Shared Links" name="share" id="" cols="30"
                                  rows="10">{{$webinar->share}}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Streaming Server</label>
                                            <div class="form-group">
                                                <input type="radio"
                                                       name="streaming_server_id"
                                                       id="streaming_server_id_0"
                                                       value="custom"
                                                        {{$webinar->streaming_server_id == 'custom' ||
                                                         $webinar->streaming_server_id == '' ?'checked':''}}
                                                >
                                                <label for="streaming_server_id_0" >Custom</label>
                                            </div>
                                            @foreach($enabled_streaming_servers as $server)
                                                <div class="form-group">
                                                    <input type="radio"
                                                           name="streaming_server_id"
                                                           id="streaming_server_id_{{$server->id}}"
                                                           value="{{$server->id}}"
                                                            {{$server->id == $webinar->streaming_server_id? 'checked':''}}
                                                    >
                                                    <label for="streaming_server_id_{{$server->id}}" >{{$server->name}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group" id="share_container" {{$webinar->streaming_server_id == '' ||
                             $webinar->streaming_server_id == 'custom' ? '': 'style=display:none'}}>
                                            <label>Streaming Server Code</label>
                                <textarea class="form-control" name="streaming_server_code" id="streaming_server_code" cols="5" rows="5"
                                          placeholder="hangouts url or rmtp code">{{$webinar->streaming_server_id == ''||
                                    $webinar->streaming_server_id == 'custom' ? $webinar->streaming_server_code: ''}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Start date and time</label><br>

                                        <div class="date-and-time">
                                            <input type="text" name="date_starts_on" class="form-control datepicker"
                                                   data-format="D, dd MM yyyy"
                                                   value="{{ date('D, d M Y', strtotime($webinar->starts_on))}}"
                                            >
                                            <input type="text" class="form-control timepicker"
                                                   data-template="dropdown"
                                                   name="time_starts_on"
                                                   data-default-time="11:25 AM"
                                                   data-show-meridian="true"
                                                   data-minute-step="5"
                                                   data-second-step="5"
                                                   value="{{ date('h:i A', strtotime($webinar->starts_on))}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Timezone</label>

                                        <script type="text/javascript">
                                            jQuery(document).ready(function ($) {
                                                $("#sboxit-4").selectBoxIt({
                                                    showEffect: 'fadeIn',
                                                    hideEffect: 'fadeOut'
                                                });
                                            });
                                        </script>

                                        <select type="hidden" class="form-control" id="sboxit-4" name="timezone"
                                                style="display: none;">
                                            <option {{$webinar->timezone == 'Pacific/Midway' ? 'selected': ''}}
                                                    value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
                                            <option {{$webinar->timezone == 'America/Adak' ? 'selected': ''}}
                                                    value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
                                            <option {{$webinar->timezone == 'America/Anchorage' ? 'selected': ''}}
                                                    value="America/Anchorage">(GMT-09:00) Alaska</option>
                                            <option {{$webinar->timezone == 'America/Los_Angeles' ? 'selected': ''}}
                                                    value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
                                            <option {{$webinar->timezone == 'America/Denver' ? 'selected': ''}}
                                                    value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
                                            <option {{$webinar->timezone == 'America/Chicago' ? 'selected': ''}}
                                                    value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
                                            <option {{$webinar->timezone == 'America/New_York' ? 'selected': ''}}
                                                    value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
                                            <option {{$webinar->timezone == 'America/Glace_Bay' ? 'selected': ''}}
                                                    value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
                                            <option {{$webinar->timezone == 'America/St_Johns' ? 'selected': ''}}
                                                    value="America/St_Johns">(GMT-03:30) Newfoundland</option>
                                            <option {{$webinar->timezone == 'America/Argentina/Buenos_Aires' ? 'selected': ''}}
                                                    value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
                                            <option {{$webinar->timezone == 'America/Noronha' ? 'selected': ''}}
                                                    value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
                                            <option {{$webinar->timezone == 'Atlantic/Cape_Verde' ? 'selected': ''}}
                                                    value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
                                            <option {{$webinar->timezone == 'Europe/Dublin' ? 'selected': ''}}
                                                    value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
                                            <option {{$webinar->timezone == 'Europe/London' ? 'selected': ''}}
                                                    value="Europe/London">(GMT) Greenwich Mean Time : London</option>
                                            <option {{$webinar->timezone == 'Europe/Amsterdam' ? 'selected': ''}}
                                                    value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                            <option {{$webinar->timezone == 'Europe/Belgrade' ? 'selected': ''}}
                                                    value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                            <option {{$webinar->timezone == 'Europe/Brussels' ? 'selected': ''}}
                                                    value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                            <option {{$webinar->timezone == 'Africa/Cairo' ? 'selected': ''}}
                                                    value="Africa/Cairo">(GMT+02:00) Cairo</option>
                                            <option {{$webinar->timezone == 'Europe/Minsk' ? 'selected': ''}}
                                                    value="Europe/Minsk">(GMT+02:00) Minsk</option>
                                            <option {{$webinar->timezone == 'Europe/Moscow' ? 'selected': ''}}
                                                    value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                            <option {{$webinar->timezone == 'Asia/Dubai' ? 'selected': ''}}
                                                    value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
                                            <option {{$webinar->timezone == 'Asia/Yerevan' ? 'selected': ''}}
                                                    value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                                            <option {{$webinar->timezone == 'Asia/Kabul' ? 'selected': ''}}
                                                    value="Asia/Kabul">(GMT+04:30) Kabul</option>
                                            <option {{$webinar->timezone == 'Asia/Yekaterinburg' ? 'selected': ''}}
                                                    value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
                                            <option {{$webinar->timezone == 'Asia/Kolkata' ? 'selected': ''}}
                                                    value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                            <option {{$webinar->timezone == 'Asia/Katmandu' ? 'selected': ''}}
                                                    value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                                            <option {{$webinar->timezone == 'Asia/Novosibirsk' ? 'selected': ''}}
                                                    value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
                                            <option {{$webinar->timezone == 'Asia/Rangoon' ? 'selected': ''}}
                                                    value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
                                            <option {{$webinar->timezone == 'Asia/Bangkok' ? 'selected': ''}}
                                                    value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                            <option {{$webinar->timezone == 'Asia/Hong_Kong' ? 'selected': ''}}
                                                    value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                            <option {{$webinar->timezone == 'Australia/Eucla' ? 'selected': ''}}
                                                    value="Australia/Eucla">(GMT+08:45) Eucla</option>
                                            <option {{$webinar->timezone == 'Asia/Tokyo' ? 'selected': ''}}
                                                    value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                            <option {{$webinar->timezone == 'Asia/Seoul' ? 'selected': ''}}
                                                    value="Asia/Seoul">(GMT+09:00) Seoul</option>
                                            <option {{$webinar->timezone == 'Australia/Adelaide' ? 'selected': ''}}
                                                    value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
                                            <option {{$webinar->timezone == 'Australia/Darwin' ? 'selected': ''}}
                                                    value="Australia/Darwin">(GMT+09:30) Darwin</option>
                                            <option {{$webinar->timezone == 'Asia/Vladivostok' ? 'selected': ''}}
                                                    value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
                                            <option {{$webinar->timezone == 'Australia/Lord_Howe' ? 'selected': ''}}
                                                    value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
                                            <option {{$webinar->timezone == 'Etc/GMT-11' ? 'selected': ''}}
                                                    value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
                                            <option {{$webinar->timezone == 'Pacific/Norfolk' ? 'selected': ''}}
                                                    value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
                                            <option {{$webinar->timezone == 'Pacific/Auckland' ? 'selected': ''}}
                                                    value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
                                            <option {{$webinar->timezone == 'Etc/GMT-12' ? 'selected': ''}}
                                                    value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                            <option {{$webinar->timezone == 'Pacific/Chatham' ? 'selected': ''}}
                                                    value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
                                            <option {{$webinar->timezone == 'Pacific/Tongatapu' ? 'selected': ''}}
                                                    value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
                                            <option {{$webinar->timezone == 'Pacific/Kiritimati' ? 'selected': ''}}
                                                    value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Estimated duration</label>

                                        <script type="text/javascript">
                                            jQuery(document).ready(function ($) {
                                                $("#sboxit-5").selectBoxIt({
                                                    showEffect: 'fadeIn',
                                                    hideEffect: 'fadeOut'
                                                });
                                            });
                                        </script>

                                        <select type="hidden" class="form-control" id="sboxit-5" name="duration"
                                                style="display: none;">
                                            @foreach([0.5, 1, 1.5, 2, 2.5, 3] as $d)
                                                <option @if($webinar->duration == $d) selected @endif value="{{$d}}h">{{$d}} h</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <hr class="tall">
                                <div class="col-md-3">
                                    <h4>Assosiate subscriber's lists</h4>

                                    <div class="form-group">
                                        <ul class="icheck-list">
                                            @foreach($subscribersLists as $list)
                                                <li>
                                                    <div class="form-group">
                                                        <input type="checkbox" value="{!!$list->id!!}"
                                                               {{(hasSubscriberList($webinar->subscribers_lists,$list))?"checked":''}} name="subscribers_lists[]"
                                                               class="cbr cbr-done">
                                                        <label>
                                                            {{$list->name}}
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h4>Excluded subscriber's lists</h4>

                                    <div class="form-group">
                                        <ul class="icheck-list">
                                            @foreach($subscribersLists as $list)
                                                <li>
                                                    <div class="form-group">
                                                        <input type="checkbox" value="{!!$list->id!!}"
                                                               {{(hasSubscriberList($webinar->excluded_subscribers_lists,$list))?"checked":''}} name="excluded_subscribers_lists[]"
                                                               class="cbr cbr-done">
                                                        <label>
                                                            {{$list->name}}
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h4>Allowed Panelists</h4>

                                    <div class="form-group">
                                        <ul class="icheck-list">
                                            @foreach($user->panelists as $panelist)
                                                <li>
                                                    <div class="form-group">
                                                        <input type="checkbox" value="{!!$panelist->id!!}"
                                                               {{($webinar->panelists->contains($panelist))?"checked":''}} name="panelists[]"
                                                               class="cbr cbr-done">
                                                        <label>
                                                            {{$panelist->user->name}}
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <h4>SignUp New Subscribers</h4>
                                    <div class="form-group">
                                        <ul class="icheck-list">
                                            @foreach($subscribersLists as $list)
                                                <li>
                                                    <div class="form-group">
                                                        <input type="checkbox" value="{!!$list->id!!}" name="signup_subscribers[]" {{($webinar->signup_subscribers_lists->contains($list))?"checked":''}} class="cbr cbr-done">
                                                        <label>
                                                            {{$list->name}}
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                            @if($webinar_list)
                                                <li>
                                                    <div class="form-group">
                                                        <input type="checkbox" value="{!!$webinar_list->id!!}" name="signup_subscribers[]" {{($webinar->signup_subscribers_lists->contains($webinar_list))?"checked":''}} class="cbr cbr-done">
                                                        <label>
                                                            {{$webinar_list->name}}
                                                        </label>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                            </div>
                            <input type="submit" id="submit" name="submit" class="btn btn-primary pull-right">
                            </form>
                            {{--<<<First tab End>>>--}}
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane active" id="tab-stats">
                        <div class="col-md-12">
                            <hr class="tall">
                            <h2>Coming Soon</h2>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab-notifications">
                        <?php
                        $webinar_description = "Title: " . $webinar->title . "<br/>Description: " . $webinar->description . "<br/>Host: " . $webinar->hosts;
                        ?>
                        {{--<<<Third tab Starts>>>--}}
                        
                        <div class="col-md-12">
                            <h2><p class="text-center">Status</p></h2>
                            <div class="table-responsive">          
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Subject</th>
                                            <th>Subscribers</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($emailNotifications as $notification)
                                       <tr>
                                            <td>{{ $notification->subject }}</td>
                                            <td>{{ $notification->count_subscribers }}</td>
                                            <td>
                                                @if($notification->status == 0)
                                                Pending
                                                @elseif($notification->status == 1)
                                                Sent
                                                @elseif($notification->status == -1)
                                                Error
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {!! Form::open(["url" => route("users.webinars.email_notifications.post", [$user->id,$webinar->id]), "method" => "POST", "onsubmit" => "return validateEmailNotificationForm()"]) !!}
                        <div class="col-md-12">
                            <h2><p class="text-center">Compose New Email</p></h2>
                            <!--<div class="form-group">
                                <label for="reminder">Reminder:</label>
                                <select class="form-control" name="reminder" id="reminder">
                                    <option value="3h">3 hours before Webinar</option>
                                    <option value="6h">6 hours before Webinar</option>
                                    <option value="1d">1 day before Webinar</option>
                                </select>
                            </div>-->
                            <div class="form-group">
                                <label for="subject">Subject:</label>
                                <input type="text" class="form-control" id="subject" name="subject">
                            </div>
                            <div class="form-group">
                                <label for="subject">Content:</label>
                                <textarea id="content" name="content" class="form-control mceEditor" rows="3">{{ $webinar_description }}</textarea>
                                <h4>Variables</h4>
                                <p class="help-block">%name% - Webinar Name</p>
                                <p class="help-block">%hosts% - Webinar Hosts</p>
                                <p class="help-block">%webinar_date_time% - Webinar Date/Time with TZ</p>
                                <p class="help-block">%webinar_estimated_duration% - Webinar Estimated Duration</p>
                            </div>

                        </div>


                        <div class="col-md-6">
                            <h4>Select SMTP Method</h4>
                            @if($smtpList)
                            @foreach($smtpList as $smtp)
                            <div class="checkbox">
                                <label><input type="checkbox" value="{{ $smtp->id }}" name="smtp_method">{{ $smtp->name }}</label>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h4>Send it:</h4>
                            <label class="radio-inline">
                                <input type="radio" name="send_type" value="now"> Now
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="send_type" value="minutes_before"> Minutes Before Webinar
                            </label>
                            
                            <div class="form-group" id="minutes_before_box" style="display:none;">
                                <input type="number" min="0" step="1" name="minutes_before_webinar" id="minutes_before_webinar" class="form-control" />
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        {!! Form::close() !!}
                        {{--<<<Third tab Ends>>>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
            <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{asset('assets/members/js/daterangepicker/daterangepicker-bs3.css')}}">
    <link rel="stylesheet" href="{{asset('assets/members/js/select2/select2.css')}}">
    <link rel="stylesheet" href="{{asset('assets/members/js/select2/select2-bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets/members/js/multiselect/css/multi-select.css')}}">

    <script src="{{asset('assets/members/js/select2/select2.min.js')}}"></script>

    <script src="{{asset('assets/members/js/daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{asset('assets/members/js/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('assets/members/js/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{asset('assets/members/js/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/members/js/selectboxit/jquery.selectBoxIt.min.js')}}"></script>
    <script src="{{asset('assets/members/js/tagsinput/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{asset('assets/members/js/typeahead.bundle.js')}}"></script>
    <script src="{{asset('assets/members/js/handlebars.min.js')}}"></script>
    <script src="{{asset('assets/members/js/multiselect/js/jquery.multi-select.js')}}"></script>
    <script src="{{asset('assets/members/js/webinar/edit.js')}}"></script>
    <script type="text/javascript" src="{{ asset('tinymce/tiny_mce.js') }}"></script>
    <script type="text/javascript" src="{{ asset('scripts/editor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('scripts/validation.js') }}"></script>
    <script type="text/javascript">
        $("input[type='radio'][name='send_type']").on("change", function(){
             if($(this).val() == "minutes_before") {
                $("#minutes_before_box").show();
            } else {
                $("#minutes_before_box").hide();
            }
        });
    </script>
    @endsection

@endsection