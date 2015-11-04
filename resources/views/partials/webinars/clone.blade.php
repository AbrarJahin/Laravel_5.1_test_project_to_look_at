@extends('layouts.member.master')

@section('contents')
    @include('errors.form')

    <div class="panel panel-default">
        <div class="panel-heading">Clone Webinar "{{$webinar->title}}"
        </div>
        <div class="panel-body">
            <div class="col-md-12">
                {!! Form::open(['url' => route('users.webinars.clone.post', [$user->id,$webinar->uuid]), 'method'=> "POST",
                'id' => 'webinarForm']) !!}
                <div class="row">
                    <div class="form-group">
                        <label>Webinar Title</label>
                        <input type="text" value="" class="form-control" id="name" name="title"
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
                                            checked >
                                    <label for="streaming_server_id_0" >Custom</label>
                                </div>
                                @foreach($enabled_streaming_servers as $server)
                                    <div class="form-group">
                                        <input type="radio"
                                               name="streaming_server_id"
                                               id="streaming_server_id_{{$server->id}}"
                                               value="{{$server->id}}" >
                                        <label for="streaming_server_id_{{$server->id}}" >{{$server->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group" id="share_container" >
                                <label>Streaming Server Code</label>
                                <textarea class="form-control" name="streaming_server_code" id="streaming_server_code" cols="5" rows="5"
                                    placeholder="hangouts url or rmtp code"></textarea>
                            </div>
                        </div>
                    </div>

                        <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Start date and time</label><br>

                            <div class="date-and-time">
                                <input type="text" name="date_starts_on" class="form-control datepicker"
                                       data-format="D, dd MM yyyy"
                                       value="{{date("D, d F Y")}}"
                                >
                                <input type="text" class="form-control timepicker"
                                       data-template="dropdown"
                                       name="time_starts_on"
                                       data-default-time="11:25 AM"
                                       data-show-meridian="true"
                                       data-minute-step="5"
                                       data-second-step="5"
                                       value="">
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
                <input type="submit" id="submit" name="submit" value="Clone" class="btn btn-primary pull-right">
                </form>
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
    @endsection

@endsection