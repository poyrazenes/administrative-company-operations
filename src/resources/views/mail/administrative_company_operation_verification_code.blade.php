<!DOCTYPE html>
<html>
<body>
Code to verification: <h1>{{ $code }}</h1>
<br><br>
Project: <strong>{{ config('app.name') }}</strong>
<br><br>
Environment: <strong>{{ app()->environment() }}</strong>
</body>
</html>
