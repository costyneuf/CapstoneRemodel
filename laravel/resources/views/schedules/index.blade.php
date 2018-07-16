@extends('main')
@section('content')
	<h3>Hello, <?php echo $_SERVER["HTTP_DISPLAYNAME"]; ?>,</h3>
	
	<br><br>

	<p>REMODEL (REsident MilestOne-baseD Educational Learning) is a system designed by David Stahl, MD (Associate Residency Program Director) in collaboration 
		with the CAPSTONE Teams from The Ohio State University (OSU) Department of Computer Science & Engineering, and in conjunction with leadership from 
		OSU Department Anesthesiology for the benefit of our anesthesiology residents.</p>
	
	<br><br>

	<p>Special thanks to:</p>
	<ul>
		<li>Xing Gao</li>
		<li>Hui Li</li>
		<li>Yi Xu</li>
	</ul>			

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