@extends('main')

@section('content')
    
	<div id = "Resident Form">
        <h4>Resident Preferences</h4><br>
        <h5>Your Preference: Room {{ $room }} with {{ $attending }}</h5>
        <form method="POST" action="../../submit" onsubmit='return validate()'>
		<div class="form-group">
                
                <label>Select your Milestone:</label><br>

                <select name="milestones" id="milestones">
                        <option value="PC1">PC1 - Patient Care 1</option>
                        <option value="PC2">PC2 - Patient Care 2</option>
                        <option value="PC3">PC3 - Patient Care 3</option>
                        <option value="PC4">PC4 - Patient Care 4</option>
                        <option value="PC5">PC5 - Patient Care 5</option>
                        <option value="PC6">PC6 - Patient Care 6</option>
                        <option value="PC7">PC7 - Patient Care 7</option>
                        <option value="PC8">PC8 - Patient Care 8</option>
                        <option value="PC9">PC9 - Patient Care 9</option>
                        <option value="PC10">PC10 - Patient Care 10</option>
                        <option value="MK1">MK1 - Medical Knowledge</option>
                        <option value="SBP1">SBP1 - Systems-based Practice 1</option>
                        <option value="SBP2">SBP2 - Systems-based Practice 2</option>
                        <option value="PBLI1">PBLI1 - Practice-based Learning and Improvement 1</option>
                        <option value="PBLI2">PBLI2 - Practice-based Learning and Improvement 2</option>
                        <option value="PBLI3">PBLI3 - Practice-based Learning and Improvement 3</option>
                        <option value="PBLI4">PBLI4 - Practice-based Learning and Improvement 4</option>
                        <option value="PRO1">PRO1 - Professionalism 1</option>
                        <option value="PRO2">PRO2 - Professionalism 2</option>
                        <option value="PRO3">PRO3 - Professionalism 3</option>
                        <option value="PRO4">PRO4 - Professionalism 4</option>
                        <option value="PRO5">PRO5 - Professionalism 5</option>
                        <option value="ICS1">ICS1 - Interpersonal and Communication Skills 1</option>
                        <option value="ICS2">ICS2 - Interpersonal and Communication Skills 2</option>
                        <option value="ICS3">ICS3 - Interpersonal and Communication Skills 3</option>
                </select>
                    
                <br>
						    
                <label>What is your educational objective for this OR today?</label><br>

                <input type="hidden" name="schedule_id" value="{{ $id }}">
                <input type="hidden" name="choice" value="{{ $choice }}">
                
                <textarea rows="3" name="objectives" id="objectives" class="form-control"></textarea><br>
                  
                <br>
                
                <input align = "right" type='submit' class='btn btn-md btn-success'>

		</div>
                </form>
                
                <script language='javascript'>
                        function validate () {
                                if(document.getElementById('milstones').value=="") {
                                        alert("Please complete all fields!");
                                        return false;
                                }
                                if(document.getElementById('objectives').value=="") {
                                        alert("Please complete all fields!");
                                        return false;
                                }
                                return true;
                        }
                </script>
	</div>
@endsection