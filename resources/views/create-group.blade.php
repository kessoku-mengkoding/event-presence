<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>

<body>
  <h1>Create Group</h1>
  <form action="/groups" method="POST">
    @csrf
    <label for="">Group Name:</label>
    <input type="text" name="name" id="">
    <br>
    <label for="">Group Description:</label>
    <input type="text" name="description" id="">
    <br>
    <button>Create</button>
  </form>
</body>

</html>
