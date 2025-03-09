<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>

    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Name</th>
            <th>ID User Level</th>
            <th>Action</th>
        </tr>
        @foreach ($data as $d)
        <tr>
            <td>{{ $d->user_id }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->name }}</td>
            <td>{{ $d->level_id }}</td>
            <td><a href={{route('/user/edit',$d->user_id)}}>Edit</a>|<a href={{route('/user/delete',$d->user_id)}}>Delete</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
