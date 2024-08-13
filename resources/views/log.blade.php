
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>



<table id="example" class="display" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Message</th>
            <th>Fixture_id</th>
            <th>fixture_date</th>
            <th>Created_at</th>
        </tr>
    </thead>
    <tbody>
        @foreach($logs as $log)
        <tr>
            <td>{{$log->id}}</td>
            <td>{{$log->message}}</td>
            <td>{{$log->fixture_id}}</td>
            <td>{{$log->fixture_date}}</td>
            <td>{{$log->created_at}}</td>

        </tr>
        @endforeach
    </tbody>

</table>

<script>
    new DataTable('#example');
</script>