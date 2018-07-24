@extends('schedules.resident.schedule_basic')

@section('table_generator')
	@if(!is_null($schedule_data))
		<table class="table table-striped table-bordered" id="sched_table">
			<tr>
				<th onclick="sortTable(1)">No.</th>
				<th onclick="sortTable(1)">Room</th>
				<th onclick="sortTable(2)">Case Procedures</th>
				<th onclick="sortTable(3)">Lead Surgeon</th>
				<th onclick="sortTable(4)">Patient Class</th>
				<th onclick="sortTable(5)">Start Time</th>
				<th onclick="sortTable(6)">End Time</th>
				@if ($flag != null)
					<th onclick="sortTable(7)">Assignment</th>
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
		<script>
			function sortTable(n) {
			  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
			  table = document.getElementById("sched_table");
			  switching = true;
			  dir = "asc"; 
			  
			  while (switching) {
				switching = false;
				rows = table.getElementsByTagName("TR");
				for (i = 1; i < (rows.length - 1); i++) {
				  shouldSwitch = false;
				  x = rows[i].getElementsByTagName("TD")[n];
				  y = rows[i + 1].getElementsByTagName("TD")[n];
				  if (dir == "asc") {
					if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
					  shouldSwitch= true;
					  break;
					}
				  } else if (dir == "desc") {
					if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
					  shouldSwitch = true;
					  break;
					}
				  }
				}
				if (shouldSwitch) {
				  rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
				  switching = true;
				  
				  switchcount ++;      
				} else {
				  if (switchcount == 0 && dir == "asc") {
					dir = "desc";
					switching = true;
				  }
				}
			  }
			}
		</script>
	@else
		<h2>Error loading table!</h2>
	@endif

@endsection