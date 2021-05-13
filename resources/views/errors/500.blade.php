{{-- @extends('errors::minimal') --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
    <style>
        #outer {
            width: 100%;
            text-align: center;
            padding-top: 50px;
        }

        #inner {
            display: inline-block;
            width: 50%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 18pt;
        }

        .button {
            background-color: #008CBA;
            /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }

        .center {
        margin: auto;
        width: 50%;
        padding: 10px;
        }
    </style>
</head>

<body>
    <div id="outer">
        <div id="inner">
            <img src="{{ asset('assets/5002.gif') }}" width="100%" />
            <p>
                UPPS!!! paso algo raro.
            </p>
            <p>
                <a href="{{ url()->previous() }}" class="button">REGRESAR</a>
            </p>

        </div>
    </div>
</body>

</html>
{{-- @section('title', __('Server Error')) --}}
{{-- @section('code', '500') --}}
{{-- @section('message', __('Server Error')) --}}