@extends('layouts.member.master')

@section('contents')
<div class="panel panel-default">
	<div class="panel-heading">Create A new Webinar.</div>
	<div class="panel-body">
		<div class="col-md-12">
			{!! Form::open(['url' => route('users.webinars.store', $user->id)]) !!}
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

                        <select type="hidden" class="form-control" id="sboxit-4" name="timezone" style="display: none;">
                            {{$timestamp = time()}}
                            @foreach(timezone_identifiers_list() as $key => $zone)
                                {{date_default_timezone_set($zone)}}
                                <option value="{{$zone}}">
                                    GMT {{date('P', $timestamp)}} - {{$zone}}
                                </option>
                            @endforeach
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
                <div class="col-md-3">

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

			</div>
				<input type="submit" id="submit" name="submit" class="btn btn-primary pull-right">
			</form>
		</div>
		<div class="col-md-5">
			@include('errors.form')
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
@endsection

@endsection