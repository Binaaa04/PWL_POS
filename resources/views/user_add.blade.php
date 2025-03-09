<!DOCTYPE html>
<html>
    <body>
        <h1>user data add form</h1>
        <a href="{{route('user')}}">Back</a>
        <form method="POST" action="{{ route('user.add_save') }}">{{ csrf_field() }}
        <label>Username</label>
        <br>
        <input type="text" name="username" placeholder="Input the username">
        <br><br>
        <label>Name</label>
        <br>
        <input type="text" name="name" placeholder="Input the name">
        <br><br>
        <label>Password</label>
        <br>
        <input type="password" name="password" placeholder="Input the password">
        <br><br>
        <label>Level ID</label>
        <br>
        <input type="number" name="level_id">
        <br><br>
        <input type="submit" class="btn btn-success" value="Save">
        </form>
    </body>
</html>