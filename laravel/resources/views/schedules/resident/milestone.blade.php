@extends('main')

@section('content')
	<script type="text/javascript">
		//window.onload = function () {
	    //	var url = document.location.href.replace(/%20/g,' ').replace(/%27/, '\''), params = url.split('?')[1].split('&'),data = {}, tmp;
		//    for (var i = 0, l = params.length; i < l; i++) {
		//         tmp = params[i].split('=');
		//         data[tmp[0]] = tmp[1];
		//    }
		    //window.alert(data);
    	//document.getElementById('firstRoom').innerHTML = data.firstPref;
    	//document.getElementById('firstDoc').innerHTML = data.firstDoc;
		//}
		function navigateHome() {
			//window.alert("Preferences Submitted!");
			document.location.href = "laravel/public/resident/";
		}
	</script>
	<div id = "Resident Form">
		<h4>Resident Preferences</h4>
		<form action="../../../">
		    <div class="form-group">
                <label for="YourPreference">Your Preference: Room {{ $room }} with {{ $attending }}</label>
                <select onchange = "changeDescription(this);" class="form-control" id="YourPreference">
                    <option selected="selected" disabled="">Select Milestone</option>
                    <option value = "F PC1">PC1 - Patient Care 1</option>
                    <option value = "F PC2">PC2 - Patient Care 2</option>
                    <option value = "F PC3">PC3 - Patient Care 3</option>
                    <option value = "F PC4">PC4 - Patient Care 4</option>
                    <option value = "F PC5">PC5 - Patient Care 5</option>
                    <option value = "F PC6">PC6 - Patient Care 6</option>
                    <option value = "F PC7">PC7 - Patient Care 7</option>
                    <option value = "F PC8">PC8 - Patient Care 8</option>
                    <option value = "F PC9">PC9 - Patient Care 9</option>
                    <option value = "F PC10">PC10 - Patient Care 10</option>
                    <option value = "F MK1">MK1 - Medical Knowledge</option>	      
                    <option value = "F SBP1">SBP1 - Systems-based Practice 1</option>
                    <option value = "F SBP2">SBP2 - Systems-based Practice 2</option>
                    <option value = "F PBLI1">PBLI1 - Practice-based Learning and Improvement 1</option>
                    <option value = "F PBLI2">PBLI2 - Practice-based Learning and Improvement 2</option>
                    <option value = "F PBLI3">PBLI3 - Practice-based Learning and Improvement 3</option>
                    <option value = "F PBLI4">PBLI4 - Practice-based Learning and Improvement 4</option>
                    <option value = "F PRO1">PRO1 - Professionalism 1</option>
                    <option value = "F PRO2">PRO2 - Professionalism 2</option>
                    <option value = "F PRO3">PRO3 - Professionalism 3</option>
                    <option value = "F PRO4">PRO4 - Professionalism 4</option>
                    <option value = "F PRO5">PRO5 - Professionalism 5</option>
                    <option value = "F ICS1">ICS1 - Interpersonal and Communication Skills 1</option>
                    <option value = "F ICS2">ICS2 - Interpersonal and Communication Skills 2</option>
                    <option value = "F ICS3">ICS3 - Interpersonal and Communication Skills 3</option>
                </select>
                    
                <br>
						    
			    <label for="Comments">Additional Comments</label>
	      		<textarea class="form-control" rows="3" id="Comments"></textarea>
                  
                <br>
                
                <input align = "right" type='submit' class='btn btn-md btn-success'>

			</div>
		</form>
	</div>
@endsection