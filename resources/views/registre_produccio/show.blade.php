@extends('layouts.app')

@section('content')

<div class="container">
  <table class="table table-striped">
    <thead class="thead-dark">
        <tr class="row">
            <th class="col">Registre de producció</th>
        </tr>
    </thead>

    <tbody>
        <tr class="row">
            <td class="font-weight-bold col-sm-3">Subreferencia:</td>
            <td class="col">{{ $registreProduccio['subreferencia']}}</td>
        </tr>
        <tr class="row">
          <td class="font-weight-bold col-sm-3">Id registre entrada:</td>
          <td class="col">{{ $registreProduccio['id_registre_entrada']}}</td>
        </tr>
        <tr class="row">
          <td class="font-weight-bold col-sm-3">Data entrega:</td>
          <td class="col">{{ $registreProduccio['data_entrega']}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Setmana:</td>
          <td class="col">{{ $registreProduccio['setmana']}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Títol:</td>
          <td class="col">{{ $registreProduccio['titol']}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Títol traduït:</td>
          <td class="col">{{ $registreProduccio['titol_traduit']}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">QC VO:</td>
          <td class="col">{{ $registreProduccio['qc_vo']}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">QC ME:</td>
          <td class="col">{{ $registreProduccio['qc_me']}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">PPP:</td>
          <td class="col">{{ $registreProduccio['ppp']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Traductor:</td>
          <td class="col">{{ array_key_exists("traductor", $empleats) ? $empleats["traductor"]->nom_empleat.' '.$empleats["traductor"]->cognom1_empleat.' '.$empleats["traductor"]->cognom2_empleat : ''}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Data traductor:</td>
          <td class="col">{{ $registreProduccio['data_traductor']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Ajustador:</td>
          <td class="col">{{ array_key_exists("ajustador", $empleats) ? $empleats["ajustador"]->nom_empleat.' '.$empleats["ajustador"]->cognom1_empleat.' '.$empleats["ajustador"]->cognom2_empleat : ''}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Data ajustador:</td>
          <td class="col">{{ $registreProduccio['data_ajustador']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Lingüista:</td>
          <td class="col">{{ array_key_exists("linguista", $empleats) ? $empleats["linguista"]->nom_empleat.' '.$empleats["linguista"]->cognom1_empleat.' '.$empleats["linguista"]->cognom2_empleat : ''}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Data lingüista:</td>
          <td class="col">{{ $registreProduccio['data_linguista']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Director:</td>
          <td class="col">{{ array_key_exists("director", $empleats) ? $empleats["director"]->nom_empleat.' '.$empleats["director"]->cognom1_empleat.' '.$empleats["director"]->cognom2_empleat : ''}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Casting:</td>
          <td class="col">{{ $registreProduccio['casting']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Propostes:</td>
          <td class="col">{{ $registreProduccio['propostes']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Subtítol:</td>
          <td class="col">{{ $registreProduccio['subtitol']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Inserts:</td>
          <td class="col">{{ $registreProduccio['inserts']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Estadillo:</td>
          <td class="col">{{ $registreProduccio['estadillo']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">VEC:</td>
          <td class="col">{{ $registreProduccio['vec']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Convos:</td>
          <td class="col">{{ $registreProduccio['convos']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Inici sala:</td>
          <td class="col">{{ $registreProduccio['inici_sala']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Técnic mix:</td>
          <td class="col">{{ array_key_exists("tecnic_mix", $empleats) ? $empleats["tecnic_mix"]->nom_empleat.' '.$empleats["tecnic_mix"]->cognom1_empleat.' '.$empleats["tecnic_mix"]->cognom2_empleat : ''}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Data técnic mix:</td>
          <td class="col">{{ $registreProduccio['data_tecnic_mix']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">retakes:</td>
          <td class="col">{{ $registreProduccio['retakes']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">QC mix:</td>
          <td class="col">{{ $registreProduccio['qc_mix']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">PPE:</td>
          <td class="col">{{ $registreProduccio['ppe']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">Estat:</td>
          <td class="col">{{ $registreProduccio['estat']}}</td>
        </tr>
        
        
        
        
    </tbody>
  </table>
</div>
@stop