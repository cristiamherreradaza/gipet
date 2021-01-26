<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Factura</title>
	<style type="text/css">
		@media print {
			#btnImprimir {
				display: none;
			}
		}

		#botonImpresion {
			background: #17aa56;
			color: #fff;
			border-radius: 7px;
			/*box-shadow: 0 5px #119e4d;*/
			padding: 15px;
		}

		#botonRegresa {
			background: #009efb;
			color: #fff;
			border-radius: 7px;
			/*box-shadow: 0 5px #119e4d;*/
			padding: 15px;
		}

		body {
			font-family: Arial, Helvetica, sans-serif;
		}

		#fondo {
			/*background-image: url("{{ asset('assets/images/factura_szone.jpg') }}");*/
			/* width: 892px; */
			/* height: 514px; */
		}

		#tablaProductos {
			font-size: 8pt;
			position: absolute;
			top: 230px;
			left: 0px;
			/* width: 718px; */
		}

		#codigoControlQr {
			font-size: 8pt;
			/* position: relative; */
			/*top: 230px;
			left: 0px;*/
			/* width: 718px; */
		}


		/*estilos para tablas de datos*/
		table.datos {
			/*font-size: 13px;*/
			/*line-height:14px;*/
			/* width: 1000; */
			border-collapse: collapse;
			background-color: #fff;
		}

		.datos th {
			height: 10px;
			background-color: #abd4ed;
			color: #000;
		}

		.datos td {
			height: 12px;
		}

		.datos th,
		.datos td {
			border: 1px solid #ddd;
			padding: 2px;
			text-align: center;
		}

		.datos tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		#literalTotal {
			font-size: 8pt;
		}

		#datosEmpresaNit {
			/* font-weight: bold; */
			font-size: 10pt;
			position: absolute;
			top: 0px;
			left: 595px;
			padding: 10px;
			border: 1px solid black;
		}

		#datosEmpresaFactura {
			/* font-weight: bold; */
			font-size: 10pt;
			position: absolute;
			top: 180px;
			left: 0px;
			padding: 5px;
			/*border: 1px solid black;*/
			width: 891px;
		}

		#txtOriginal {
			font-weight: bold;
			font-size: 12pt;
			position: absolute;
			top: 85px;
			left: 670px;
			width: 150px;
			text-align: center;
		}

		#txtActividad {
			/* font-weight: bold; */
			font-size: 6pt;
			position: absolute;
			top: 110px;
			left: 600px;
			width: 280px;
			text-align: left;
		}

		#txtFactura {
			font-weight: bold;
			font-size: 19pt;
			position: absolute;
			top: 140px;
			left: 350px;
			width: 150px;
			text-align: center;
		}

		#logo {
			position: absolute;
			top: 20px;
			left: 20px;
		}

		#direccionEmpresa {
			font-weight: bold;
			font-size: 6pt;
			position: absolute;
			top: 85px;
			left: 20px;
			width: 150px;
			text-align: center;
		}
	</style>
	<script src="{{ asset('js/NumeroALetras.js') }}"></script>
	<script src="{{ asset('dist/js/qrcode.min.js') }}"></script>
</head>

<body>
@php
	function fechaCastellano ($fecha) {
	$fecha = substr($fecha, 0, 10);
	$numeroDia = date('d', strtotime($fecha));
	$dia = date('l', strtotime($fecha));
	$mes = date('F', strtotime($fecha));
	$anio = date('Y', strtotime($fecha));
	$dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
	$dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
	$nombredia = str_replace($dias_EN, $dias_ES, $dia);
	$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre",
	"Noviembre", "Diciembre");
	$meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
	"November", "December");
	$nombreMes = str_replace($meses_EN, $meses_ES, $mes);
	return $numeroDia." de ".$nombreMes." de ".$anio;
	}
@endphp
	<div id="fondo">

		<div id="logo"><img src="{{ asset('assets/imagenes/portal_uno_R.png') }}" width="200"></div>
			
			<table id="datosEmpresaNit" width="300">
				<tr>
					<th style="text-align: left;">NIT:</th>
					<td>178436029</td>
				</tr>
				<tr>
					<th style="text-align: left;">FACTURA N&deg;:</th>
					<td>35</td>
				</tr>
				<tr>
					<th style="text-align: left;">N&deg; AUTORIZACION:</th>
					<td>4568789311113331</td>
				</tr>
			</table>
			
			<table id="datosEmpresaFactura">
				<tr>
					<td style="text-align: left;"><b>Lugar y Fecha:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;La Paz,
						25 de Enero</span></td>
					<td><b>NIT/CI:<b /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Herrera</td>
				</tr>
				<tr>
					<td style="text-align: left;"><b>Se&ntilde;or(es):</b>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Herrera</td>
					<td></td>
				</tr>
			</table>
		<div id="tablaProductos">
		<table class="datos" width="892">
			<thead>
				<tr>
					<th style="padding-top: 5px;padding-bottom: 5px;">N&deg;</th>
					<th>CANTIDAD</th>
					<th>DESCRIPCION</th>
					<th>PRECIO UNITARIO</th>
					<th>SUBTOTAL</th>
				</tr>
			</thead>			
			<tbody>
                <tr>
                    <td width="25px">&nbsp;&nbsp;
                        1
                    </td>
                    <td style="text-align: right;" width="100px">1</td>
                    <td width="425px" style="text-align: left;">1 MENSUALIDAD</td>
                    <td style="text-align: right;" width="100px">200.00</td>
                    <td style="text-align: right;" width="100px"><b>200</b></td>
                </tr>

                <tr>
                    <td width="25px">&nbsp;&nbsp;
                        2
                    </td>
                    <td style="text-align: right;" width="100px">1</td>
                    <td width="425px" style="text-align: left;">2 MENSUALIDAD</td>
                    <td style="text-align: right;" width="100px">200.00</td>
                    <td style="text-align: right;" width="100px"><b>200</b></td>
                </tr>

                <tr>
                    <td width="25px">&nbsp;&nbsp;
                        3
                    </td>
                    <td style="text-align: right;" width="100px">1</td>
                    <td width="425px" style="text-align: left;">3 MENSUALIDAD</td>
                    <td style="text-align: right;" width="100px">200.00</td>
                    <td style="text-align: right;" width="100px"><b>200</b></td>
                </tr>

                <tr>
                    <td width="25px">&nbsp;&nbsp;
                        4
                    </td>
                    <td style="text-align: right;" width="100px">1</td>
                    <td width="425px" style="text-align: left;">4 MENSUALIDAD</td>
                    <td style="text-align: right;" width="100px">200.00</td>
                    <td style="text-align: right;" width="100px"><b>200</b></td>
                </tr>

                <tr>
                    <td width="25px">&nbsp;&nbsp;
                        5
                    </td>
                    <td style="text-align: right;" width="100px">1</td>
                    <td width="425px" style="text-align: left;">5 MENSUALIDAD</td>
                    <td style="text-align: right;" width="100px">200.00</td>
                    <td style="text-align: right;" width="100px"><b>200</b></td>
                </tr>
			</tbody>
			<tfoot>
				<td colspan="3" style="text-align: left;">SON: Seis cientos 100/00 BOLIVIANOS</td>
				<td style="background-color: #abd4ed;color: #000;">TOTAL Bs.</td>
				<td style="text-align: right;font-size: 9pt;font-weight: bold;">600.00</td>
			</tfoot>
			
		</table>
		<br />
			<table class="codigoControlQr" width="100%">
				<tr>
					<td>
						Codigo de Control: AB-F0-E2-21<br />
						Fecha limite de Emision: 21/05/2021
					</td>
					<td>
						<div id="qrcode"></div>
					</td>
				</tr>
			</table>
		<br />
		<center>
			"ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAIS. EL USO ILICITO DE ESTA SERA SANCIONADO DE ACUERDO A LEY"<br />
			<b>Ley N&deg; 453: El proveedor debera suministrar el servicio en las modalidades y terminos ofertados o
				convenidos.</b>
			<p>&nbsp;</p>
			<div id="btnImprimir">
				<input type="button" id="botonImpresion" value="IMPRIMIR" onClick="window.print()">
				<input type="button" id="botonRegresa" value="VOLVER" onClick="vuelveSistema()">
			</div>
		</center>
		</div>

		<div id="txtOriginal">ORIGINAL</div>
		<div id="txtActividad">Educacion Superior</div>
		<div id="txtFactura">FACTURA</div>
		<div id="direccionEmpresa">Av. Villazon Pje Bernardo Trigo No 447</div>
		
		</div>

	<script>
		
	</script>
	
</body>
</html>