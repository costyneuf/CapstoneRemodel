@extends('main')

@section('content')

<table class="table table-striped table-bordered" id="users_table">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Operations</th>
        @foreach ($roles as $role)
            <tr>
                <td align="left">{{ $role['name'] }}</td>
                <td align="left">{{ $role['email'] }}</td>
                <td align="left">{{ $role['role'] }}</td>
                <td>
                    <input align="center" onclick = "deleteUsers(this.id);" value="Delete User" type="button" class='btn btn-md btn-success' id="{{ $role['email'] }}_{{ $role['role'] }}">
                </td>
            </tr>                             
        @endforeach

        <script type="text/javascript">                
            function deleteUsers(id)
            {
                var email = id.substr(0, id.indexOf('_'));
                var role = id.substr(id.indexOf('_')+1);

                // Update url to the confirmation page
                var current_url = window.location.href;
                var url = current_url.search('/deleteUser/') > -1 ? current_url.substr(0, current_url.search('/deleteUser/')) : current_url;
                url = url + "/deleteUser/" + role + "/" + email + "/false";
                window.location.href = url;
            }
    
        </script>
    </tr>
</table>
@endsection