@extends('main')
@section('content')
	<h1>Hello, <?php echo $_SERVER["HTTP_DISPLAYNAME"]; ?></h1> 

	<?php
		use App\Resident;
		use App\Admin;
		
		$super_access = false;
		$access = false;
		if (Admin::where('email', $_SERVER['HTTP_EMAIL'])->exists()) {
			$super_access = true;
			$access = true;
		} else if (Resident::where('email', $_SERVER['HTTP_EMAIL'])->exists()) {			
			$access = true;
		}
	?>

	@if ($access)
		<br><br>
		<a class="btn btn-primary" href="resident">Resident Page</a>
	@endif
	
	@if ($super_access)
		<br><br>		
		<a class="btn btn-primary" href="admin">Admin Page</a>
	@endif

@endsection