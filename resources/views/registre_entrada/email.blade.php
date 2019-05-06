<!DOCTYPE html>
<!--
No utilizar bootstrap. Mail no los detecta las exportaciones.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<style>
            table.customTable {
              width: 100%;
              background-color: #FFFFFF;
              border-collapse: collapse;
              border-width: 2px;
              border-color: #7EA8F8;
              border-style: solid;
              color: #000000;
            }

            table.customTable td, table.customTable th {
              border-width: 2px;
              border-color: #7EA8F8;
              border-style: solid;
              padding: 5px;
            }

            table.customTable thead {
              background-color: #79AAF2;
            }
    </style>
    </head>
    <body>

	    <table class="customTable" >
	        <thead>
	            <tr>
	                <th colspan="2">Registre d'Entrada</th>
	            </tr>
	        </thead>

	        <tbody>
                    <tr>
                        <td  style="font-weight: bold; width: 25%">REFERENCIA:</td>
                        <td>{{ $registreEntrada['id_registre_entrada']}}</td>
                    </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">TÍTOL:</td>
	                <td>{{ $registreEntrada['titol']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">OT:</td>
	                <td>{{ $registreEntrada['ot']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">OC:</td>
	                <td>{{ $registreEntrada['OC']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">PRIMERA ENTREGA:</td>
	                <td>{{ $registreEntrada['sortida']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">CLIENT:</td>
	                <td>{{ $client['nom_client']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">SERVEI:</td>
	                <td>{{ $servei['nom_servei']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">IDIOMA:</td>
	                <td>{{ $idioma['idioma']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">TIPUS:</td>
	                <td>{{ $media['nom_media']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">MINUTS TOTALS:</td>
	                <td>{{ $registreEntrada['minuts']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">NÚMERO D'EPISODIS:</td>
	                <td>{{ $registreEntrada['total_episodis']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">EPISODIS SETMANALS:</td>
	                <td>{{ $registreEntrada['episodis_setmanals']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">ENTREGUES SETMANALS:</td>
	                <td>{{ $registreEntrada['entregues_setmanals']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">ESTAT:</td>
	                <td>{{ $registreEntrada['estat']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">DATA DE CREACIÓ:</td>
	                <td>{{ $registreEntrada['created_at']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">ÚLTIMA ACTUALITZACIÓ:</td>
	                <td>{{ $registreEntrada['updated_at']}}</td>
	            </tr>
	        </tbody>
	    </table>
    </body>
</html>