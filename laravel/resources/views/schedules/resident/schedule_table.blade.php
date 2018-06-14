@extends('schedules.resident.schedule_basic')

@section('table_generator')

	@if(!is_null($schedule_data))
		<table class="table table-striped table-bordered" id="sched_table">
			<tr>
				<th>No.</th>
				<th>Loction</th>
				<th>Room</th>
				<th>Case Procedures</th>
				<th>Lead Surgeon</th>
				<th>Patient Class</th>
				<th>Start Time</th>
				<th>End Time</th>
				<th>Preference</th>
			</tr>

			
			<?php 
				$count = 1;				
			?>
			@foreach ($schedule_data as $row)
				<tr>
				<?php
					echo '<th id='.$count.'>'.$count.'</th>';
					echo '<th>'.$row->location.'</th>';
					echo '<th>'.$row->room.'</th>';
					echo '<th>'.$row->case_procedure.'</th>';
					echo '<th>'.$row->lead_surgeon.'</th>';
					echo '<th>'.$row->patient_class.'</th>';
					echo '<th>'.$row->start_time.'</th>';
					echo '<th>'.$row->end_time.'</th>';
					$count = $count + 1;
				?>
				<td>
					<select onchange = "changePreferences(this);" class = "PreferenceSelector" id = "Pref{{$count}}">
						<option disabled selected="selected" value= "default">Choose here</option>
						<option value= "first">First</option>
						<option value= "second">Second</option>
						<option value= "third">Third</option>
					</select>
				</td>
				</tr>
			@endforeach



		</table>
		<input align = "right" type='submit' class='btn btn-md btn-success' onclick="checkSelectedPreferences();">
		<p id = "Error Message" style="color:red; display: none;">Please select a First, Second, and Third Preference</p>


		<!--'">-->
	@else
		<h2>Error loading table!</h2>
	@endif

@endsection