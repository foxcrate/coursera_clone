@include('admin.templates.header')

@include('admin.templates.sidebar')

@include('admin.templates.navbar')

<div class="container-xl">
	<div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class=" col-sm-6 ">
						<h2>Manage <b>Courses</b></h2>
					</div>
					<div class=" col-sm-6 ">
						<a href="#addSemesterModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Add New Course</span></a>
						<!-- <a href="#deleteSemesterModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE15C;</i> <span>Delete</span></a>						 -->
					</div>
				</div>
			</div>
			<table style="table-layout:fixed; width: 100%;" class="table table-striped table-hover">
				<thead>
					<tr>
						<th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
						</th>
						<th>ID</th>
						<th>Name</th>
						<th>Num Of Lessons</th>
						<th>Actions</th> 
					</tr>
				</thead>
				<tbody>
				@foreach ($courses as $course)
     
					<tr>
						<td style="word-wrap: break-word">
							<span class="custom-checkbox">
								<input type="checkbox" id="checkbox1" name="options[]" value="1">
								<label for="checkbox1"></label>
							</span>
						</td>
						<td style="word-wrap: break-word"> {{$course->id}} </td>
						<td style="word-wrap: break-word"> {{$course->name}} </td>
						<td style="word-wrap: break-word"> {{ count($course->lessons) }} </td>
						<td style="word-wrap: break-word">
							<!-- <a onClick="edit_function({{$course->id}})" href="#editSemesterModal" class="edit" data-toggle="modal"><i class="bi bi-pencil-fill"></i></a> -->
							<a href="{{ route('courses.details',['id'=>$course->id]) }}" title="Lessons" class="details"><i class="bi bi-eye-fill"></i></a>
                            <a onClick="delete_function({{$course->id}})" href="#deleteSemesterModal" class="delete" data-toggle="modal"><i class="bi bi-trash"></i></a>
                            
						</td>
					</tr>

				@endforeach

				</tbody>
			</table>
			<div class="clearfix">
				<div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
				<ul class="pagination">
					<li class="page-item disabled"><a href="#">Previous</a></li>
					<li class="page-item"><a href="#" class="page-link">1</a></li>
					<li class="page-item"><a href="#" class="page-link">2</a></li>
					<li class="page-item active"><a href="#" class="page-link">3</a></li>
					<li class="page-item"><a href="#" class="page-link">4</a></li>
					<li class="page-item"><a href="#" class="page-link">5</a></li>
					<li class="page-item"><a href="#" class="page-link">Next</a></li>
				</ul>
			</div>
		</div>
	</div>        
</div>
<!-- Add Modal HTML -->
<div id="addSemesterModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="{{route('courses.add')}}">
				@csrf
				<div class="modal-header">						
					<h4 class="modal-title">Add Course</h4>
					<button type="button " class="close btn-danger" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input type="text" name="name" class="form-control" required>
					</div>					
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-success" value="Add">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Edit Modal HTML -->
<div id="editSemesterModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="edit_form" name="alo" method="post" action="{{route('courses.edit')}}">
				@csrf
				<div class="modal-header">						
					<h4 class="modal-title">Edit Course</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>Name</label>
						<input id="edit_modal_name" name="name" type="text" class="form-control" required>
					</div>

				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-info" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Delete Modal HTML -->
<div id="deleteSemesterModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="delete_form" method="post" action="{{route('courses.delete')}}">
				@csrf
				<div class="modal-header">						
					<h4 class="modal-title">Delete Course</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">					
					<p>Are you sure you want to delete these Records?</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-danger" value="Delete">
				</div>
			</form>
		</div>
	</div>
</div>

<script> 

	// $(document).ready(function(){
	// 	// $("#edit_button").click(function(){
	// 	// 	alert("Alo");
	// 	// });
	// });
	var edit_id = 0;
	var delete_id = 0;

	function edit_function(id){
		edit_id = id;
		//alert(edit_id);
	}

	function delete_function(id){
		
		delete_id = id;
		// alert(delete_id);
	}

	$("#edit_form").submit(function(e) {

		e.preventDefault(); // avoid to execute the actual submit of the form.

		var formData = {
			id:edit_id,
			name: $("#edit_modal_name").val(),
		};
        //console.log(formData);

		$.ajax({
			headers: {
     			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   			},
			type: "POST",
			url: e.target.action,
			data: formData,
			dataType: "json",
			encode: true,
			}).done(function (data) {
			// console.log(data);
			window.location.reload();
		});

	});

	$("#delete_form").submit(function(e) {

		//alert(delete_id);

		e.preventDefault(); // avoid to execute the actual submit of the form.

		var formData = {
			id: delete_id,
		};

		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "POST",
			url: e.target.action,
			data: formData,
			dataType: "json",
			encode: true,
			}).done(function (data) {
			//console.log(data);
			window.location.reload();
		});

	});

</script>


