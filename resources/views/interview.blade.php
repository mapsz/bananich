<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bananich</title>
  <script src="{{ mix('js/adminApp.js') }}" defer></script>
</head>
<body>
  <div id="app"><interview user="{{$id ?? ''}}"></interview></div>
  
</body>
</html>