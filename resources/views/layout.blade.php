<!DOCTYPE html>
<html lang="en" class="bg-white antialiased">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Compass</title>

    <link href='{{ mix('app.css', 'vendor/compass') }}' rel='stylesheet' type='text/css'>
</head>
<body>
    {{-- Global Laravel Compass Object --}}
    <script>
        window.Compass = @json($compassScriptVariables);
    </script>
</body>
</html>
