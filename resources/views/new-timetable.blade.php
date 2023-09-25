<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>

<body>
  timetable new
  <form action="/timetable" method="POST">
    @csrf
    @method('POST')
    <input type="text" name="group_id" hidden value="{{ $group_id }}" class="input">
    <label for="">Title</label>
    <input type="text" name="title" id="" class="input">
    <label for="">Description</label>
    <input type="text" name="description" id="" class="input">
    <label for="">Radius meter</label>
    <input type="text" name="radius_meter" id="" class="input">
    <label for="">Start</label>
    <input type="text" name="start_date" id="" class="input">
    <label for="">End</label>
    <input type="text" name="end_date" id="" class="input">
  </form>
</body>

</html>
