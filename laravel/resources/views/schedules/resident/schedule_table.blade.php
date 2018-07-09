@extends('schedules.resident.schedule_basic')

@section('table_generator')
	@if(!is_null($schedule_data))
		<table class="table table-striped table-bordered" id="sched_table">
			<tr>
				<th>No.</th>
				<th>Room</th>
				<th>Case Procedures</th>
				<th>Lead Surgeon</th>
				<th>Patient Class</th>
				<th>Start Time</th>
				<th>End Time</th>
				@if ($flag != null)
					<th>Assignment</th>
				@else
					<th>Preference</th>
					<th>Submit</th>
				@endif
			</tr>

			
			<?php 
				$count = 1;				
			?>
			@foreach ($schedule_data as $row)
				<tr>
				<?php			

					echo '<td>'.$count.'</td>';
					echo '<td align="left">'.$row['room'].'</td>';

					/**
					 * Display case procedures by list.
					 */
					echo '<td align="left">';

						$case_procedure = $row['case_procedure'];
						// echo $case_procedure."\n".stripos(substr($case_procedure, 0), '[');
						echo '<ol>';
						while ($case_procedure != false)
						{
							$ep = stripos(substr($case_procedure, 0), '[');
							echo '<li>'.substr($case_procedure, 0, $ep).'</li>';
							$case_procedure = substr($case_procedure, ($ep + App\Constant::OFFSET_PROCEDURE));
						}
						echo '</ol>';
					echo '</td>';

					echo '<td align="left" '.'id="'.$row['lead_surgeon'].'">'.substr($row['lead_surgeon'], 0, stripos($row['lead_surgeon'], '[')).'</td>';
					echo '<td align="left">'.$row['patient_class'].'</td>';
					echo '<td align="left">'.$row['start_time'].'</td>';
					echo '<td align="left">'.$row['end_time'].'</td>';
					$count = $count + 1;
				?>
				@if ($flag != null)
					@if ($row['resident'] != null)
						<td align="left">{{ $row['resident'] }}</td>
					@else
						<td align="left">TBD</td>
					@endif
				@else
					<td>
						<select class = "PreferenceSelector" id = "{{ $row['id'] }}_">
							<option disabled selected="selected" value= "default">Choose here</option>
							<option value= "1">First</option>
							<option value= "2">Second</option>
							<option value= "3">Third</option>
						</select>
					</td>
					<td>
							<input align = "center" type="button" value="Select" id="{{ $row['id'] }}" class='btn btn-md btn-success' onclick="storePreference(this.id);">						
					</td>
				@endif
				</tr>
			@endforeach



		</table>
		<!--'">-->
	@else
		<h2>Error loading table!</h2>
	@endif

@endsection