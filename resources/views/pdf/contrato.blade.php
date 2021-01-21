<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boletin de Calificaciones</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        * {
            font-family: Verdana, Arial, sans-serif;
            font-size: 8pt;
        }

        table.contenidos {
            /*font-size: 13px;*/
            /* line-height:14px; */
            /* width: 100%; */
            /* border-collapse: collapse; */
            background-color: #fff;
            position: absolute;
            top: 425px;
            left: 150px;
            padding: 20px;
            border: 1px solid black;
            -moz-border-radius:10px;
            -webkit-border-radius:10px;
            border-radius:10px
        }
        .contenidos th {
            height: 20px;
            background-color: #616362;
            color: #fff;
        }
        .contenidos td {
            /* height: 10px; */
        }
        .contenidos th, .contenidos td {
            /* border-bottom: 1px solid #ddd; */
            /* padding: 5px; */
            text-align: left;
        }

    </style>
    <!-- <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet"> -->
</head>
<body>
    <main>
        <table class="contenidos" width="500px">
            <tr>
                <td colspan="4"><div style="text-align: center; font-size: 18pt; padding-bottom: 20px; font-weight: bold;">KARDEX PERSONAL</div></td>
            </tr>
            <tr>
                <td><b>Carrera:</b></td>
                <td>Contaduria General</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><b>Curso:</b></td>
                <td>Primero</td>
                <td><b>Turno:</b></td>
                <td>Manana</td>
            </tr>
            <tr>
                <td colspan="4"><div style="text-align: center; font-size: 12pt; padding: 10 0 6 0;">DATOS PERSONALES</div></td>
            </tr>
            <tr>
                <td><b>Apellidos:</b></td>
                <td>{{ $persona->apellido_paterno }} {{ $persona->apellido_materno }}</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td><b>Nombres:</b></td>
                <td>{{ $persona->nombres }}</td>
                <td><b>Sexo</b>:</td>
                <td>M</td>
            </tr>

            <tr>
                <td><b>Fecha Nacimiento: </b></td>
                <td>{{ $persona->fecha_nacimiento }}</td>
                <td>Carnet:</td>
                <td>{{ $persona->cedula }}</td>
            </tr>

            <tr>
                <td><b>Direccion:</b></td>
                <td>{{ $persona->direccion }} </td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td><b>Telefono Fijo: </b></td>
                <td>{{ $persona->numero_fijo }}</td>
                <td><b>Celular:</b></td>
                <td>{{ $persona->numero_celular }}</td>
            </tr>

            <tr>
                <td><b>Correo Electronico: </b></td>
                <td>{{ $persona->email }}</td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="4"><div style="text-align: center; font-size: 12pt; padding: 10 0 6 0;">REFERENCIAS</div></td>
            </tr>
            <tr>
                <td><b>Familiar:</b></td>
                <td>{{ $persona->nombre_madre }}</td>
                <td><b>Telf:</b></td>
                <td>{{ $persona->celular_madre }}</td>
            </tr>

            <tr>
                <td><b>Laboral:</b></td>
                <td>{{ $persona->empresa }}</td>
                <td><b>Telf:</b>:</td>
                <td>{{ $persona->numero_empresa }}</td>
            </tr>
        </table>
    </main>
</body>
</html>