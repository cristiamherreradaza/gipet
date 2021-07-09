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

			#operario{
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
			top: 160px;
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
			top: 100px;
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

		#txtRecibo {
			font-weight: bold;
			font-size: 24pt;
			position: absolute;
			top: 40px;
			left: 580px;
			width: 350px;
			text-align: center;
		}

		#logo {
			position: absolute;
			top: 20px;
			left: 0px;
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
	
@endphp
	<div id="fondo">

		@php
			$recibo = App\Factura::find($cuotasPagadas[0]->factura_id);
		@endphp

		<div id="txtRecibo">RECIBO No. {{ str_pad($recibo->numero, 4, '0', STR_PAD_LEFT) }}</div>

		<div id="logo"><img src="{{ asset('assets/imagenes/portal_uno_R.png') }}" width="200"></div>
			
			<table id="datosEmpresaFactura">
				<tr>
					<td style="text-align: left;">
						<b>Lugar y Fecha:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						@php
							$utilidades = new App\librerias\Utilidades();
							$fechaEs = $utilidades->fechaCastellano($cuotasPagadas[0]->fecha);
						@endphp
						La Paz, {{ $fechaEs }}</td>
				</tr>
				<tr>
					<td style="text-align: left;"><b>Se&ntilde;or(es):</b>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						@if ($cuotasPagadas[0]->persona->apellido_paterno)
							{{ $cuotasPagadas[0]->persona->apellido_paterno }}&nbsp;
						@endif
						{{ $cuotasPagadas[0]->persona->apellido_materno }}&nbsp;
						{{ $cuotasPagadas[0]->persona->nombres }}</td>
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
				@php
					$total = 0;
				@endphp
				@foreach ($cuotasPagadas as $key => $c)
				@php
					$total += $c->importe;
				@endphp
					<tr>
						<td width="25px">&nbsp;&nbsp;
							{{ ++$key }}
						</td>
						<td style="text-align: right;" width="100px">1</td>
						<td width="425px" style="text-align: left;">
							@if ($c->servicio_id == 2)
							    {{ $c->mensualidad }}&#176; Mensualidad
							@else
							    {{ $c->servicio->nombre }}
							@endif
						</td>
						<td style="text-align: right;" width="100px">{{ $c->importe }}</td>
						<td style="text-align: right;" width="100px"><b>{{ $c->importe }}</b></td>
					</tr>	
				@endforeach
			</tbody>
			<tfoot>
				@php
					$utilidad = new App\librerias\NumeroALetras();
					$aLetras = $utilidad->toMoney($total);
				@endphp
				<td colspan="3" style="text-align: left;">Son: {{ $aLetras }}  100/00 Bolivianos</td>
				<td style="background-color: #abd4ed;color: #000;">TOTAL Bs.</td>
				<td style="text-align: right;font-size: 9pt;font-weight: bold;">{{ number_format($total, 2) }}</td>
			</tfoot>
			
		</table>
		Operario: {{ $cuotasPagadas[0]->user->apellido_paterno }} {{ $cuotasPagadas[0]->user->apellido_materno }} {{ $cuotasPagadas[0]->user->nombres }}<br />
		Fecha Hora: {{ $cuotasPagadas[0]->created_at }}
		<br />
			{{-- <table class="codigoControlQr" width="100%">
				<tr>
					<td>
						Codigo de Control: AB-F0-E2-21<br />
						Fecha limite de Emision: 21/05/2021
					</td>
					<td>
						<div id="qrcode"></div>
					</td>
				</tr>
			</table> --}}
		<br />
		<center>
			{{-- "ESTA FACTURA CONTRIBUYE AL DESARROLLO DEL PAIS. EL USO ILICITO DE ESTA SERA SANCIONADO DE ACUERDO A LEY"<br />
			<b>Ley N&deg; 453: El proveedor debera suministrar el servicio en las modalidades y terminos ofertados o
				convenidos.</b>
			<p>&nbsp;</p> --}}
			<div id="btnImprimir">
				<input type="button" id="botonImpresion" value="IMPRIMIR" onClick="window.print()">
				<input type="button" id="botonRegresa" value="VOLVER" onClick="vuelveSistema()">
			</div>
		</center>
		</div>
		
		</div>

	<script>
		function vuelveSistema()
		{
			location.href = "{{ url('Factura/formularioFacturacion') }}";	
		}
	</script>
	
</body>
</html>