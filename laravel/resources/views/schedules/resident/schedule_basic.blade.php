@extends('main')

@section('content')
    <h3>Date: {{ $mon }}/{{ $day }}/{{ $year }}</h3>
    <br><br><br>
    <br><br><br>
    
	<div id="filter">
        <h5>Filter Schedule</h5> 
        
        <br>
        
    	<!-- <!--category filter
    	<select id="categories">
            <option value="none">-Category-</option>
            <option value="none">-Admin needs to set-</option>
        </select> -->
        
    	<!--//doctor filter-->
    	<select id="doctors">
            <option value="none">-Doctors-</option>
    	</select>
    	<!--//start after filter-->
    	<select id="start_after">
    	    <option value="none">-Start After-</option>
            @for($i=0; $i<12; $i++)
                @if($i==0)
                    <option value="12 am">12 AM</option>
                @else
                    <option value="' ,$i, ' am">{{$i}} AM</option>
                @endif
            @endfor
            @for($i=0; $i<12; $i++)
                @if($i==0)
                    <option value="12 pm">12 PM</option>
                @else
                    <option value="',$i,' pm">{{$i}} PM</option>
                @endif
            @endfor
    	</select>

    	<!--//end before filter-->
    	<select id="end_before">
            <option value="none">-End Before-</option>
            @for($i=0; $i<12; $i++)
                @if($i==0)
                    <option value="12 am">12 AM</option>
                @else
                    <option value="',$i,' am">{{$i}} AM</option>
                @endif
            @endfor
            @for($i=0; $i<12; $i++)
                @if($i==0)
                    <option value="12 pm">12 PM</option>
                @else
                    <option value="',$i,' pm">{{$i}} PM</option>
                @endif
            @endfor
        </select>
        
    	<button type="button" class="btn btn-primary" onclick="">Filter</button>
	</div>

	<br><br>

	<div class = "container">
	    @yield('table_generator')
    </div>
    
    <script type="text/javascript">
        
        var tab, docList;
        var docs = [];
        tab = document.getElementById("sched_table");
        docList = document.getElementById("doctors");
        
        // Get all unique doctor names and sort by alphabetical order
        for(var i = 0; i < tab.rows.length; i++){
            if(i != 0){
                var element = tab.rows[i].cells[4].innerHTML;
                if(!docs.includes(element)){
                    docs.push(element);
                }
            }
        }
        docs.sort();
       
        // Create options for select
        for(var i = 0; i < docs.length; i++){
            var option = document.createElement("option");
            option.value = docs[i];
            option.text = docs[i];
            docList.appendChild(option);
        }
        
    </script>

    <!--Preference JS -->
    <script type="text/javascript">
        // Store username, selected data id, preferences into database.
        function storePreference(id)
        {

        }


        // Generate a warning box if selection has been made
        function checkPreference()
        {

        }

    </script>
    
@endsection('content')