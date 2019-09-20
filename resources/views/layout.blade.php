<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Compass</title>

    <link href='{{ mix('app.css', 'vendor/compass') }}' rel='stylesheet' type='text/css'>
</head>
<body>
    <div id="compass" class="min-h-screen bg-white antialiased md:flex md:flex-col md:h-screen">
        <alert v-if="alert.mode"
            :mode="alert.mode"
            :type="alert.type"
            :message="alert.message"
            :auto-close="alert.autoClose"></alert>

        <site-header></site-header>

        <div class="md:flex-1 md:flex md:overflow-y-hidden">
            <sidebar-menu></sidebar-menu>

            <main class="md:flex-1 md:overflow-x-hidden">
                <router-view :key="$route.path"></router-view>
            </main>
        </div>
    </div>

    {{-- Global Laravel Compass Object --}}
    <script>
        window.Compass = @json($compassScriptVariables);
    </script>
    <script src="{{ mix('app.js', 'vendor/compass') }}"></script>
</body>
</html>
