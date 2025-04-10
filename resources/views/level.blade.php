<!DOCTYPE html>
<html>
<head>
    <title>Data Level User</title>
</head>
<body>
    <h1>Level User</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID Level</th>
            <th>Level Code</th>
            <th>Level Name</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->level_id }}</td>
            <td>{{ $d->level_kode }}</td>
            <td>{{ $d->level_nama }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
