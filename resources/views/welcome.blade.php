<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>TempDity – DHT22 Sensor Monitoring</title>

        <!-- Icon & Tailwind -->
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css"
        />
        <link
            rel="stylesheet"
            href="https://cdn.datatables.net/2.1.8/tailwindcss/dataTables.tailwindcss.min.css"
        />

        <!-- DataTables + Tailwind -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Hilangkan spinner di Chrome, Edge, Opera */
            input[type='number']::-webkit-outer-spin-button,
            input[type='number']::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Hilangkan spinner di Firefox */
            input[type='number'] {
                -moz-appearance: textfield;
            }
        </style>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

    <body class="bg-linear-to-br from-gray-800 via-gray-900 to-black h-max">
        @include('main')

        {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    </body>
</html>
