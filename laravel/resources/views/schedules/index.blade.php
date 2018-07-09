@extends('main')
@section('content')
	<h1>Hello, <?php echo $_SERVER["HTTP_DISPLAYNAME"]; ?></h1> 
	<br><br>
	<a class="btn btn-primary" href="resident">Resident Page</a>	
	<br><br>		
	<a class="btn btn-primary" href="admin">Admin Page</a>
@endsection