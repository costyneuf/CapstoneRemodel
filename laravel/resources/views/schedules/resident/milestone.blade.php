@extends('main')

@section('content')
    
	<div id = "Resident Form">
        <h4>Resident Preferences</h4><br>
        <h5>Your Preference: Room {{ $room }} with {{ $attending }}</h5>
        <form method="POST" action="../../submit">
		    <div class="form-group">
                
                <label>Select your Milestone:</label><br>

                <input type="radio" name="milestones" value="PC1">PC1 - Patient Care 1<br><br>
                <input type="radio" name="milestones" value="PC2">PC2 - Patient Care 2<br><br>
                <input type="radio" name="milestones" value="PC3">PC3 - Patient Care 3<br><br>
                <input type="radio" name="milestones" value="PC4">PC4 - Patient Care 4<br><br>
                <input type="radio" name="milestones" value="PC5">PC5 - Patient Care 5<br><br>
                <input type="radio" name="milestones" value="PC6">PC6 - Patient Care 6<br><br>
                <input type="radio" name="milestones" value="PC7">PC7 - Patient Care 7<br><br>
                <input type="radio" name="milestones" value="PC8">PC8 - Patient Care 8<br><br>
                <input type="radio" name="milestones" value="PC9">PC9 - Patient Care 9<br><br>
                <input type="radio" name="milestones" value="PC10">PC10 - Patient Care 10<br><br>
                <input type="radio" name="milestones" value="MK1">MK1 - Medical Knowledge<br><br>
                <input type="radio" name="milestones" value="SBP1">SBP1 - Systems-based Practice 1<br><br>
                <input type="radio" name="milestones" value="SBP2">SBP2 - Systems-based Practice 2<br><br>
                <input type="radio" name="milestones" value="PBLI1">PBLI1 - Practice-based Learning and Improvement 1<br><br>
                <input type="radio" name="milestones" value="PBLI2">PBLI2 - Practice-based Learning and Improvement 2<br><br>
                <input type="radio" name="milestones" value="PBLI3">PBLI3 - Practice-based Learning and Improvement 3<br><br>
                <input type="radio" name="milestones" value="PBLI4">PBLI4 - Practice-based Learning and Improvement 4<br><br>
                <input type="radio" name="milestones" value="PRO1">PRO1 - Professionalism 1<br><br>
                <input type="radio" name="milestones" value="PRO2">PRO2 - Professionalism 2<br><br>
                <input type="radio" name="milestones" value="PRO3">PRO3 - Professionalism 3<br><br>
                <input type="radio" name="milestones" value="PRO4">PRO4 - Professionalism 4<br><br>
                <input type="radio" name="milestones" value="PRO5">PRO5 - Professionalism 5<br><br>
                <input type="radio" name="milestones" value="ICS1">ICS1 - Interpersonal and Communication Skills 1<br><br>
                <input type="radio" name="milestones" value="ICS2">ICS2 - Interpersonal and Communication Skills 2<br><br>
                <input type="radio" name="milestones" value="ICS3">ICS3 - Interpersonal and Communication Skills 3<br><br>
                <input type="radio" name="milestones" value="NA" checked="true">Not Available<br><br>
                    
                <br>
						    
                <label>What is your educational objective for this OR today?</label><br>

                <input type="hidden" name="option_id" value="{{ $id__ }}">
                
                <textarea rows="3" name="objectives" class="form-control"></textarea><br>
                  
                <br>
                
                <input align = "right" type='submit' class='btn btn-md btn-success'>

			</div>
		</form>
	</div>
@endsection