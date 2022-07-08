<!DOCTYPE html>
<html lang="en-US" class="js no-touch csstransforms csstransforms3d csstransitions">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="/images/cropped-favicon-32x32.png" sizes="32x32" />
        <link rel="icon" href="/images/cropped-favicon-192x192.png" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="/images/cropped-favicon-180x180.png">
        <meta name="msapplication-TileImage" content="/images/cropped-favicon-270x270.png">

        <title>Kiddy - Children HTML Template</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <!-- Styles -->
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/dist/css/adminlte.min.css">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <!-- Scripts -->
        <script type='text/javascript' src='/js/jquery.js'></script>
        <script type='text/javascript' src='/js/jquery-migrate.min.js'></script>

        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
    {{ $slot }}
    </body>
</html>


