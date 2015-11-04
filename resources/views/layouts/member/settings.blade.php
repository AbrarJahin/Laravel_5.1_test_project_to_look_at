@extends('layouts.member.master')
@section('contents')
<div class="row">
    <div class="errors-container">
        @include('errors.form')
    </div>

    <?php
    $domain = '';
    if (Input::old('custom_domain')) {
        $domain = Input::old('custom_domain');
    } else {
        if (isset($custom_domain->value)) {
            $domain = $custom_domain->value;
        }
    }
    ?>

    <div class="row col-md-12">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::open(array('url' => 'members/settings', 'class' => 'login-form fade-in', 'id'=>'frmSetting')) !!}

                <label for="customDomain">Custom Domain:</label>
                <input type="text" class="form-control" name="custom_domain" id="custom_domain" value="<?php echo $domain; ?>" />
                <p class="help-block"><small>Note: Atleast Two DNS Should Map</small></p>
                <button type="button" class="btn btn-primary validateWebinarDomain">Submit</button>

                {!! Form::close() !!}
            </div>
        </div>
        <hr class="tall">
    </div>
    <div class="row col-md-12">
        <div class="col-md-6">
            {!! Form::open(array('url' => 'members/settings', 'id'=>'settingsForm')) !!}

            <label for="timezone">Default Time Zone:</label>
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
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>

            {!! Form::close() !!}
        </div>
    </div>

</div>

<!-- Modal -->
<div id="domainValidationModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Checking Webinar Domain</h4>
            </div>
            <div class="modal-body">
                <p id="google_dns">Google DNS <span id="google_dns" class="pull-right">Loading...</span></p>
                <p id="level3_dns">Level3 DNS <span id="level3_dns" class="pull-right">Loading...</span></p>
                <p id="open_dns">Open DNS <span id="open_dns" class="pull-right">Loading...</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary closeValidateDomainModal" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
  $("#custom_domain").keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
</script>
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
<script src="{{asset('assets/members/js/webinar/edit.js')}}"></script><script type="text/javascript" src="{{url('scripts/validation.js')}}"></script>
@endsection
@endsection