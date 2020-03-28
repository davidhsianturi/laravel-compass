<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Compass - {{ config('app.name') }}</title>

    <link href="{{ mix('app.css', 'vendor/compass') }}" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="compass" class="min-h-screen bg-white antialiased lg:flex lg:flex-col lg:h-screen">
        <alert v-if="alert.mode"
            :mode="alert.mode"
            :type="alert.type"
            :message="alert.message"
            :auto-close="alert.autoClose"
            :confirmation-cancel="alert.confirmationCancel"
            :confirmation-proceed="alert.confirmationProceed"></alert>

        <spotlight v-if="spotlight.open"></spotlight>

        <site-header></site-header>

        <div class="lg:flex-1 lg:flex lg:overflow-y-hidden">
            <sidebar-menu></sidebar-menu>

            <main class="lg:flex-1 lg:overflow-x-hidden">
                @if (! $assetsAreCurrent)
                    <div class="bg-blue-100 text-blue-900 px-4 py-3 mb-3" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="fill-current h-6 w-6 text-blue-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">The published Compass assets are not up-to-date with the installed version.</p>
                                <p class="text-sm">To update, run: <code class="ml-2">php artisan compass:publish</code></p>
                            </div>
                        </div>
                    </div>
                @endif

                <router-view :key="$route.path"></router-view>
            </main>
        </div>
    </div>

    {{-- Global Laravel Compass Object --}}
    <script>
        window.Compass = @json($compassScriptVariables);
    </script>
    <script src="{{ mix('manifest.js', 'vendor/compass') }}"></script>
    <script src="{{ mix('vendor.js', 'vendor/compass') }}"></script>
    <script src="{{ mix('app.js', 'vendor/compass') }}"></script>
</body>
</html>
