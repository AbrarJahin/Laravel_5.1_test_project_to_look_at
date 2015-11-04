@extends('layouts.member.master')

@section('contents')
    <meta id="meta" csrf-token="{{csrf_token()}}">

    <div class="col-md-5">
        @include('errors.form')
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Upcoming Webinars List
        <!-- <a href="{!!route('users.webinars.create', [$user->id])!!}"
            class="btn btn-success pull-right">Create New Webinar</a> -->
        <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">Create New Webinar</button>
        </div>

        <!-- Modal -->
          <div class="modal fade bs-example-modal-lg" id="myModal" role="dialog">
            <div class="modal-dialog modal-dialog modal-lg">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Create A new Webinar.</h4>
                </div>
                {!! Form::open(['url' => route('users.webinars.store', $user->id)]) !!}
                <div class="modal-body">
                  <div class="col-md-12">
                            <div class="row">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" name="title" placeholder="Webinar title">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Description" name="description" id="" cols="30" rows="10"></textarea>
                                </div>
                                  <div class="form-group">
                                      <input type="text" class="form-control" id="hosts" name="hosts" placeholder="Webinar hosts">
                                  </div>
                                <div class="form-group">
                                      <input type="text" class="form-control" id="webinar_subscriber_list_name" name="webinar_subscriber_list_name" placeholder="Webinar Subscriber List">
                                  </div>
                                <div class="form-group">
                                    <textarea class="form-control" name="webinar_subscriber_list_description" id="webinar_subscriber_list_description" rows="10" cols="30" placeholder="Webinar Subscriber List Description"></textarea>
                                  </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Start date and time</label><br>
                                        <div class="date-and-time">
                                            <input type="text" name="date_starts_on" class="form-control datepicker"
                                                     data-format="D, dd MM yyyy">

                                            <input type="text" class="form-control timepicker"
                                                   data-template="dropdown"
                                                   name="time_starts_on"
                                                   data-default-time="11:25 AM"
                                                   data-show-meridian="true"
                                                   data-minute-step="5"
                                                   data-second-step="5">
                                        </div>
                                    </div>
                                </div>
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="control-label">Timezone</label>

                                          <script type="text/javascript">
                                              jQuery(document).ready(function($)
                                              {
                                                  $("#sboxit-4").selectBoxIt({
                                                      showEffect: 'fadeIn',
                                                      hideEffect: 'fadeOut'
                                                  });
                                              });
                                          </script>

                                          <select type="hidden" class="form-control" id="sboxit-4" name="timezone"
                                                  style="display: none;">
                                              <option {{$timezone == 'Pacific/Midway' ? 'selected': ''}}
                                                      value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa</option>
                                              <option {{$timezone == 'America/Adak' ? 'selected': ''}}
                                                      value="America/Adak">(GMT-10:00) Hawaii-Aleutian</option>
                                              <option {{$timezone == 'America/Anchorage' ? 'selected': ''}}
                                                      value="America/Anchorage">(GMT-09:00) Alaska</option>
                                              <option {{$timezone == 'America/Los_Angeles' ? 'selected': ''}}
                                                      value="America/Los_Angeles">(GMT-08:00) Pacific Time (US & Canada)</option>
                                              <option {{$timezone == 'America/Denver' ? 'selected': ''}}
                                                      value="America/Denver">(GMT-07:00) Mountain Time (US & Canada)</option>
                                              <option {{$timezone == 'America/Chicago' ? 'selected': ''}}
                                                      value="America/Chicago">(GMT-06:00) Central Time (US & Canada)</option>
                                              <option {{$timezone == 'America/New_York' ? 'selected': ''}}
                                                      value="America/New_York">(GMT-05:00) Eastern Time (US & Canada)</option>
                                              <option {{$timezone == 'America/Glace_Bay' ? 'selected': ''}}
                                                      value="America/Glace_Bay">(GMT-04:00) Atlantic Time (Canada)</option>
                                              <option {{$timezone == 'America/St_Johns' ? 'selected': ''}}
                                                      value="America/St_Johns">(GMT-03:30) Newfoundland</option>
                                              <option {{$timezone == 'America/Argentina/Buenos_Aires' ? 'selected': ''}}
                                                      value="America/Argentina/Buenos_Aires">(GMT-03:00) Buenos Aires</option>
                                              <option {{$timezone == 'America/Noronha' ? 'selected': ''}}
                                                      value="America/Noronha">(GMT-02:00) Mid-Atlantic</option>
                                              <option {{$timezone == 'Atlantic/Cape_Verde' ? 'selected': ''}}
                                                      value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.</option>
                                              <option {{$timezone == 'Europe/Dublin' ? 'selected': ''}}
                                                      value="Europe/Dublin">(GMT) Greenwich Mean Time : Dublin</option>
                                              <option {{$timezone == 'Europe/London' ? 'selected': ''}}
                                                      value="Europe/London">(GMT) Greenwich Mean Time : London</option>
                                              <option {{$timezone == 'Europe/Amsterdam' ? 'selected': ''}}
                                                      value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                              <option {{$timezone == 'Europe/Belgrade' ? 'selected': ''}}
                                                      value="Europe/Belgrade">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                              <option {{$timezone == 'Europe/Brussels' ? 'selected': ''}}
                                                      value="Europe/Brussels">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                              <option {{$timezone == 'Africa/Cairo' ? 'selected': ''}}
                                                      value="Africa/Cairo">(GMT+02:00) Cairo</option>
                                              <option {{$timezone == 'Europe/Minsk' ? 'selected': ''}}
                                                      value="Europe/Minsk">(GMT+02:00) Minsk</option>
                                              <option {{$timezone == 'Europe/Moscow' ? 'selected': ''}}
                                                      value="Europe/Moscow">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                              <option {{$timezone == 'Asia/Dubai' ? 'selected': ''}}
                                                      value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat</option>
                                              <option {{$timezone == 'Asia/Yerevan' ? 'selected': ''}}
                                                      value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                                              <option {{$timezone == 'Asia/Kabul' ? 'selected': ''}}
                                                      value="Asia/Kabul">(GMT+04:30) Kabul</option>
                                              <option {{$timezone == 'Asia/Yekaterinburg' ? 'selected': ''}}
                                                      value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg</option>
                                              <option {{$timezone == 'Asia/Kolkata' ? 'selected': ''}}
                                                      value="Asia/Kolkata">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                              <option {{$timezone == 'Asia/Katmandu' ? 'selected': ''}}
                                                      value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                                              <option {{$timezone == 'Asia/Novosibirsk' ? 'selected': ''}}
                                                      value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk</option>
                                              <option {{$timezone == 'Asia/Rangoon' ? 'selected': ''}}
                                                      value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)</option>
                                              <option {{$timezone == 'Asia/Bangkok' ? 'selected': ''}}
                                                      value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                              <option {{$timezone == 'Asia/Hong_Kong' ? 'selected': ''}}
                                                      value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                              <option {{$timezone == 'Australia/Eucla' ? 'selected': ''}}
                                                      value="Australia/Eucla">(GMT+08:45) Eucla</option>
                                              <option {{$timezone == 'Asia/Tokyo' ? 'selected': ''}}
                                                      value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                              <option {{$timezone == 'Asia/Seoul' ? 'selected': ''}}
                                                      value="Asia/Seoul">(GMT+09:00) Seoul</option>
                                              <option {{$timezone == 'Australia/Adelaide' ? 'selected': ''}}
                                                      value="Australia/Adelaide">(GMT+09:30) Adelaide</option>
                                              <option {{$timezone == 'Australia/Darwin' ? 'selected': ''}}
                                                      value="Australia/Darwin">(GMT+09:30) Darwin</option>
                                              <option {{$timezone == 'Asia/Vladivostok' ? 'selected': ''}}
                                                      value="Asia/Vladivostok">(GMT+10:00) Vladivostok</option>
                                              <option {{$timezone == 'Australia/Lord_Howe' ? 'selected': ''}}
                                                      value="Australia/Lord_Howe">(GMT+10:30) Lord Howe Island</option>
                                              <option {{$timezone == 'Etc/GMT-11' ? 'selected': ''}}
                                                      value="Etc/GMT-11">(GMT+11:00) Solomon Is., New Caledonia</option>
                                              <option {{$timezone == 'Pacific/Norfolk' ? 'selected': ''}}
                                                      value="Pacific/Norfolk">(GMT+11:30) Norfolk Island</option>
                                              <option {{$timezone == 'Pacific/Auckland' ? 'selected': ''}}
                                                      value="Pacific/Auckland">(GMT+12:00) Auckland, Wellington</option>
                                              <option {{$timezone == 'Etc/GMT-12' ? 'selected': ''}}
                                                      value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                              <option {{$timezone == 'Pacific/Chatham' ? 'selected': ''}}
                                                      value="Pacific/Chatham">(GMT+12:45) Chatham Islands</option>
                                              <option {{$timezone == 'Pacific/Tongatapu' ? 'selected': ''}}
                                                      value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa</option>
                                              <option {{$timezone == 'Pacific/Kiritimati' ? 'selected': ''}}
                                                      value="Pacific/Kiritimati">(GMT+14:00) Kiritimati</option>
                                          </select>
                                      </div>
                                  </div>
                                <div class="col-md-4">
                                      <div class="form-group">
                                          <label class="control-label">Estimated duration</label>

                                          <script type="text/javascript">
                                              jQuery(document).ready(function($)
                                              {
                                                  $("#sboxit-5").selectBoxIt({
                                                      showEffect: 'fadeIn',
                                                      hideEffect: 'fadeOut'
                                                  });
                                              });
                                          </script>

                                          <select type="hidden" class="form-control" id="sboxit-5" name="duration" style="display: none;">
                                              @foreach([0.5, 1, 1.5, 2, 2.5, 3] as $d)
                                                  <option value="{{$d}}">{{$d}} h</option>
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
                                                          <input type="checkbox" value="{!!$list->id!!}" name="subscribers_lists[]" class="cbr cbr-done">
                                                          <label>
                                                              {{$list->name}}
                                                          </label>
                                                      </div>
                                                  </li>
                                              @endforeach
                                          </ul>
                                      </div>
                                  </div>
                                  <div class="col-md-4">

                                      <h4>Excluded subscriber's lists</h4>
                                      <div class="form-group">
                                          <ul class="icheck-list">
                                              @foreach($subscribersLists as $list)
                                                  <li>
                                                      <div class="form-group">
                                                          <input type="checkbox" value="{!!$list->id!!}" name="excluded_subscribers_lists[]" class="cbr cbr-done">
                                                          <label>
                                                              {{$list->name}}
                                                          </label>
                                                      </div>
                                                  </li>
                                              @endforeach
                                          </ul>
                                      </div>
                                  </div>
                                <div class="col-md-4">

                                    <h4>Allowed Panelists</h4>
                                    <div class="form-group">
                                        <ul class="icheck-list">
                                            @foreach($user->panelists as $panelist)
                                                <li>
                                                    <div class="form-group">
                                                        <input type="checkbox" value="{!!$panelist->id!!}" name="panelists[]" class="cbr cbr-done">
                                                        <label>
                                                            {{$panelist->user->name}}
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="submit" value="Add Webinar" name="submit" class="btn btn-primary pull-right">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </form>
              </div>
              
            </div>
          </div>

        <div class="panel-body">
            <div class="col-md-12">

                <table id="upcoming_webinars_list"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                    <meta name="base_url" content="{{URL::to('/')}}">
                    <thead id="bacground_fix">        <!-- I am forced to do this bad thing, because another CSS is applie to this page's table and I don't where is that, it will take time for me, so I leave it n giving emphasise on functionality  -->
                        <tr>
                            <td width="5%"></td>
                            <td>Title </td>
                            <td width="15%">Starts      </td>
                            <td width="10%">Created     </td>
                            <td width="10%">Actions     </td>
                        </tr>
                    </thead>
                </table>

                <!--
                <table class="table table-bordered">
                    <thead>
                    <td width="90px">ID</td>
                    <td>Title</td>
                    <td>Description</td>
                    <td>Hosts</td>
                    <td width="200px">Starts</td>
                    <td width="110px">Duration</td>
                    <td width="110px">Created</td>
                    <td width="80px">Actions</td>
                    </thead>
                    <tbody>
                    @foreach($upcoming_webinars as $webinar)
                        <tr>
                            <td>{{$webinar->id}}</td>
                            <td>{{$webinar->title}}</td>
                            <td>{{$webinar->description}}</td>
                            <td>{{$webinar->hosts}}</td>
                            <td>{{date('d F Y h:i A', strtotime($webinar->starts_on)).' '.$webinar->timezone}}</td>
                            <td>{{$webinar->duration}}</td>
                            <td>{{$webinar->created_at}}</td>
                            <td>
                                <a style="color:green" href="{!!route('users.webinars.edit',
                                          [$user->id,$webinar->uuid])!!}">
                                    <i class="fa fa-pencil fa-2x"></i>
                                </a>
                                <a style="color:red" href="#">
                                    <i class="fa fa-trash fa-3x"></i>
                                </a>
                                <a style="color:blue" target="_blank" href="{{url('/webinar/'.$webinar->uuid)}}">
                                    <i class="fa fa-eye fa-3x"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                -->

            </div>
            {!!$upcoming_webinars->render()!!}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Past Webinars List </div>
        <div class="panel-body">
            <div class="col-md-12">

                <table id="past_webinars_list"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
                    <meta name="base_url" content="{{URL::to('/')}}">
                    <thead id="bacground_fix">        <!-- I am forced to do this bad thing, because another CSS is applie to this page's table and I don't where is that, it will take time for me, so I leave it n giving emphasise on functionality  -->
                        <tr>
                            <td width="5%"></td>
                            <td>Title </td>
                            <td width="15%">Starts      </td>
                            <td width="10%">Created     </td>
                            <td width="10%">Actions     </td>
                        </tr>
                    </thead>
                </table>

<!--
                <table class="table table-bordered">
                    <thead>
                    <td width="90px">ID</td>
                    <td>Title</td>
                    <td>Description</td>
                    <td>Hosts</td>
                    <td width="200px">Starts</td>
                    <td width="110px">Duration</td>
                    <td width="110px">Created</td>
                    <td width="80px">Actions</td>
                    </thead>
                    <tbody>
                    @foreach($past_webinars as $webinar)
                        <tr>
                            <td>{{$webinar->id}}</td>
                            <td>{{$webinar->title}}</td>
                            <td>{{$webinar->description}}</td>
                            <td>{{$webinar->hosts}}</td>
                            <td>{{date('d F Y h:i A', strtotime($webinar->starts_on)).' '.$webinar->timezone}}</td>
                            <td>{{$webinar->duration}}</td>
                            <td>{{$webinar->created_at}}</td>
                            <td>
                                <a style="color:green" href="{!!route('users.webinars.edit',
													[$user->id,$webinar->uuid])!!}">
                                    <i class="fa fa-pencil fa-2x"></i>
                                </a>
                                <a style="color:red" href="#">
                                    <i class="fa fa-trash fa-3x"></i>
                                </a>
                                <a style="color:blue" target="_blank" href="{{url('/webinar/'.$webinar->uuid)}}">
                                    <i class="fa fa-eye fa-3x"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
-->
            </div>
            {!!$past_webinars->render()!!}
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
@endsection

@endsection
