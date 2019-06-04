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
	                <th colspan="2">Registre d'Entrada {{!empty($request) ? '- Modificat' : ''}}</th>
	            </tr>
	        </thead>

	        <tbody>
                    <tr>
                        <td  style="font-weight: bold; width: 25%">REFERENCIA:</td>
                        <td>{{ $registreEntrada->id_registre_entrada}}</td>
                    </tr>
	            <tr>

                        @if (!empty($request) && $request->titol != $registreEntrada->titol)
                            <td style="font-weight: bold; width: 25%; background-color: lawngreen;">TÍTOL:</td>
                            <td style="background-color: lawngreen;">{{ $request->titol}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">TÍTOL:</td>
                            <td>{{ $registreEntrada->titol}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->ot != $registreEntrada->ot)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">OT:</td>
                            <td style="background-color: lawngreen;">{{ $request->ot}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">OT:</td>
                            <td>{{ $registreEntrada->ot}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->OC != $registreEntrada->OC)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">OC:</td>
                            <td style="background-color: lawngreen;">{{ $request->OC}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">OC:</td>
                            <td>{{ $registreEntrada->OC}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->sortida != $registreEntrada->sortida)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">PRIMERA ENTREGA:</td>
                            <td style="background-color: lawngreen;">{{ $request->sortida}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">PRIMERA ENTREGA:</td>
                            <td>{{ $registreEntrada->sortida}}</td>
                        @endif
                    </tr>
                    <tr>
                        @if (!empty($request) && $request->usuari->alias_usuari != $registreEntrada->usuari->alias_usuari)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">RESPONSABLE:</td>
                            <td style="background-color: lawngreen;">{{ $request->usuari->alias_usuari}} {{$request->usuari->cognom1_usuari}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">RESPONSABLE:</td>
                            <td>{{ isset($registreEntrada->usuari) ? $registreEntrada->usuari->nom_cognom :  ''}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->client->nom_client != $registreEntrada->client->nom_client)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">CLIENT:</td>
                            <td style="background-color: lawngreen;">{{ $request->client->nom_client}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">CLIENT:</td>
                            <td>{{ $registreEntrada->client->nom_client}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->servei->nom_servei != $registreEntrada->servei->nom_servei)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">SERVEI:</td>
                            <td style="background-color: lawngreen;">{{ $request->servei->nom_servei}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">SERVEI:</td>
                            <td>{{ $registreEntrada->servei->nom_servei}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->idioma->idioma != $registreEntrada->idioma->idioma)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">IDIOMA:</td>
                            <td style="background-color: lawngreen;">{{ $request->idioma->idioma}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">IDIOMA:</td>
                            <td>{{ $registreEntrada->idioma->idioma}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->media->nom_media != $registreEntrada->media->nom_media)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">TIPUS:</td>
                            <td style="background-color: lawngreen;">{{ $request->media->nom_media}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">TIPUS:</td>
                            <td>{{ $registreEntrada->media->nom_media}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->minuts != $registreEntrada->minuts)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">MINUTS TOTALS:</td>
                            <td style="background-color: lawngreen;">{{ $request->minuts}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">MINUTS TOTALS:</td>
                            <td>{{ $registreEntrada->minuts}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->total_episodis != $registreEntrada->total_episodis)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">NÚMERO D'EPISODIS:</td>
                            <td style="background-color: lawngreen;">{{ $request->total_episodis}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">NÚMERO D'EPISODIS:</td>
                            <td>{{ $registreEntrada->total_episodis}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->episodis_setmanals != $registreEntrada->episodis_setmanals)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">EPISODIS SETMANALS:</td>
                            <td style="background-color: lawngreen;">{{ $request->episodis_setmanals}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">EPISODIS SETMANALS:</td>
                            <td>{{ $registreEntrada->episodis_setmanals}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->entregues_setmanals != $registreEntrada->entregues_setmanals)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">ENTREGUES SETMANALS:</td>
                            <td style="background-color: lawngreen;">{{ $request->entregues_setmanals}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">ENTREGUES SETMANALS:</td>
                            <td>{{ $registreEntrada->entregues_setmanals}}</td>
                        @endif
	            </tr>
	            <tr>
                        @if (!empty($request) && $request->estat != $registreEntrada->estat)
                            <td style="font-weight: bold; width: 25%;background-color: lawngreen;">ESTAT:</td>
                            <td style="background-color: lawngreen;">{{ $request->estat}}</td>
                        @else
                            <td style="font-weight: bold; width: 25%">ESTAT:</td>
                            <td>{{ $registreEntrada->estat}}</td>
                        @endif
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">DATA DE CREACIÓ:</td>
	                <td>{{ $registreEntrada['created_at']}}</td>
	            </tr>
	            <tr>
	                <td style="font-weight: bold; width: 25%">ÚLTIMA ACTUALITZACIÓ:</td>
                        @if (empty($request))
                            <td>{{ $registreEntrada->updated_at}}</td>
                        @else
                            <td>{{ $request->updated_at}}</td>
                        @endif
	            </tr>
	        </tbody>
	    </table>
    </body>
</html>