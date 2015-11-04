
@extends('partials.subscribers-lists.index')

@section('subscribers-contents')

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Create A new List.</h4>
				</div>
				{!! Form::open(['url' => route('users.subscribers-lists.store',$user->id)]) !!}
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" id="name" name="name" placeholder="List name">
					</div>
					<div class="form-group">
						<textarea class="form-control" placeholder="Description" name="description" id="" cols="30" rows="10"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" id="submit" name="submit" value="Add" class="btn btn-primary pull-right">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				</form>
			</div>

		</div>
	</div>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="col-md-12">
			@include('errors.form')
		</div>
	</div>
</div>
@endsection