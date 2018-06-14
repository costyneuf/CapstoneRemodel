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
				<th>Submit</th>
			</tr>

			
			<?php 
				$count = 1;				
			?>
			@foreach ($schedule_data as $row)
				<tr>
				<?php
					echo '<th>'.$count.'</th>';
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
				<td>
						<input align = "center" type="button" value="Select" id='.$row->id.' class='btn btn-md btn-success' onclick="storePreference($row->id);">						
				</td>
				</tr>
			@endforeach



		</table>
		<!--'">-->
	@else
		<h2>Error loading table!</h2>
	@endif

@endsection