<!DOCTYPE html>
<html>
    <body>
        <h1>user data edit form</h1>
        <a href="{{route('user')}}">Back</a>
        <form method="POST" action="{{ route('user.edit_save', $data->user_id) }}">{{ csrf_field() }}
        {{method_field('PUT')}}
        <label>Username</label>
        <br>
        <input type="text" name="username" value="{{$data->username}}">
        <br><br>
        <label>Name</label>
        <br>
        <input type="text" name="name" value="{{$data->name}}">
        <br><br>
        <label>Level ID</label>
        <br>
        <input type="number" name="level_id" value="{{$data->level_id}}">
        <br><br>
        <input type="submit" class="btn btn-success" value="Changes save">
        </form>
    </body>
</html>