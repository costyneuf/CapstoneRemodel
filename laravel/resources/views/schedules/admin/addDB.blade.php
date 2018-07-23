@if ($message != null)
    <html>
        <head>
            <title>REMODEL</title>
            <?php
                $url = "/laravel/public/admin/schedules";              
            ?>
            <meta http-equiv="refresh" content="0; URL={{ $url }}">
            <meta name="keywords" content="automatic redirection">
        </head>
        <body>
            <h4>{{ $message }}</h4>
            <p>
                If your browser does not automatically go there within a few seconds, 
                you may want to go to <a href="{{ $url }}">the destination</a> manually.
            </p>
        </body>
    </html>
@else
    @extends('main')
    @section('content')

        <form method="POST" action="addDB">
            <div class="form-group">    
                
                <input type="hidden" name="date" value="{{ $date }}">
                
                <label>Location:</label>
                <input type="text" name="location" required>
                <br>

                <label>Room:</label>
                <input type="text" name="room" required>                
                <br>

                <label>Case Procedure 1:</label>
                <input type="text" name="case_procedure_1" required>
                <label> Code:</label>
                <input type="number" name="case_procedure_1_code" min="10000" max="99999" required>
                <br>
                <label>Case Procedure 2:</label>
                <input type="text" name="case_procedure_2">
                <label> Code:</label>
                <input type="number" name="case_procedure_2_code" min="10000" max="99999">
                <br>
                <label>Case Procedure 3:</label>
                <input type="text" name="case_procedure_3">
                <label> Code:</label>
                <input type="number" name="case_procedure_3_code" min="10000" max="99999">
                <br>
                <label>Case Procedure 4:</label>
                <input type="text" name="case_procedure_4">
                <label> Code:</label>
                <input type="number" name="case_procedure_4_code" min="10000" max="99999">
                <br>
                <label>Case Procedure 5:</label>
                <input type="text" name="case_procedure_5">
                <label> Code:</label>
                <input type="number" name="case_procedure_5_code" min="10000" max="99999">
                <br>

                <label>Lead Surgeon:</label>
                <input type="text" name="lead_surgeon" required>
                <label> Code:</label>
                <input type="number" name="lead_surgeon_code" min="100000" max="999999" required>
                <br>

                <label>Patient Class:</label>
                <input type="text" name="patient_class" required>
                <br>

                <label>Start Time:</label>
                <input type="time" name="start_time" required>
                <label> End Time:</label>
                <input type="time" name="end_time" required>
                <br>
                        
                <input align = "right" type='submit' class='btn btn-md btn-success'>

            </div>
        </form>
    @endsection
@endif