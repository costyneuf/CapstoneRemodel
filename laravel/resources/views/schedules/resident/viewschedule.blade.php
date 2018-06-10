@extends('main')

@section('content')
    <h3>Date: {{ $mon }}/{{ $day }}/{{ $year }}</h3>
    <br><br><br>
    <table class="table table-striped table-bordered" id="sched_table">
        <tr>
            <th>Location</th>
            <th>Room</th>
            <th>Case Procedures</th>
            <th>Lead Surgeon</th>
            <th>Patient Class</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        @for($i = 0; $i < count($schedule_data); $i++)
            <tr>
 
            </tr>            
        @endfor
    </table>
@endsection('content')