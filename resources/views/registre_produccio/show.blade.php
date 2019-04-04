@extends('layouts.app')

@section('content')

<div class="container">
  <table class="table table-striped">
    <thead class="thead-dark">
        <tr class="row">
            <th class="col">REGISTRE DE PRODUCCIÓ</th>
        </tr>
    </thead>

    <tbody>
        <tr class="row">
          <td class="font-weight-bold col-sm-3">REFERENCIA:</td>
          <td class="col">{{ $registreProduccio['id_registre_entrada']}}</td>
        </tr>
        <tr class="row">
            <td class="font-weight-bold col-sm-3">SUBREFERENCIA:</td>
            <td class="col">{{ $registreProduccio['subreferencia']}}</td>
        </tr>
        <tr class="row">
          <td class="font-weight-bold col-sm-3">DATA ENTREGA:</td>
          <td class="col">{{ $registreProduccio['data_entrega']}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">SETMANA:</td>
          <td class="col">{{ $registreProduccio['setmana']}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">TÍTOL:</td>
          <td class="col">{{ $registreProduccio['titol']}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">TÍTOL TRADUÏT:</td>
          <td class="col">{{ $registreProduccio['titol_traduit']}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">QC VO:</td>
          <td class="col">{{ $registreProduccio['qc_vo'] == 0 ? 'No Fet' : 'Fet'}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">QC ME:</td>
          <td class="col">{{ $registreProduccio['qc_me'] == 0 ? 'No Fet' : 'Fet'}}</td>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">PPP:</td>
          <td class="col">{{ $registreProduccio['ppp'] == 0 ? 'No Fet' : 'Fet'}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">TRADUCTOR:</td>
          <td class="col">{{ array_key_exists("traductor", $empleats) ? $empleats["traductor"]->nom_empleat.' '.$empleats["traductor"]->cognom1_empleat.' '.$empleats["traductor"]->cognom2_empleat : ''}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">DATA TRADUCTOR:</td>
          <td class="col">{{ $registreProduccio['data_traductor']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">AJUSTADOR:</td>
          <td class="col">{{ array_key_exists("ajustador", $empleats) ? $empleats["ajustador"]->nom_empleat.' '.$empleats["ajustador"]->cognom1_empleat.' '.$empleats["ajustador"]->cognom2_empleat : ''}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">DATA AJUSTADOR:</td>
          <td class="col">{{ $registreProduccio['data_ajustador']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">LINGÜISTA:</td>
          <td class="col">{{ array_key_exists("linguista", $empleats) ? $empleats["linguista"]->nom_empleat.' '.$empleats["linguista"]->cognom1_empleat.' '.$empleats["linguista"]->cognom2_empleat : ''}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">DATA LINGÜISTA:</td>
          <td class="col">{{ $registreProduccio['data_linguista']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">DIRECTOR:</td>
          <td class="col">{{ array_key_exists("director", $empleats) ? $empleats["director"]->nom_empleat.' '.$empleats["director"]->cognom1_empleat.' '.$empleats["director"]->cognom2_empleat : ''}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">CASTING:</td>
          <td class="col">{{ $registreProduccio['casting'] == 0 ? 'No Fet' : 'Fet'}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">PROPOSTES:</td>
          <td class="col">{{ $registreProduccio['propostes'] == 0 ? 'No Fet' : 'Fet'}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">INSERTS:</td>
          <td class="col">{{ $registreProduccio['inserts']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">ESTADILLO:</td>
          <td class="col">{{ $registreProduccio['estadillo'] == 0 ? 'No Fet' : 'Fet'}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">VEC:</td>
          <td class="col">{{ $registreProduccio['vec'] == 0 ? 'No Fet' : 'Fet'}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">CONVOS:</td>
          <td class="col">{{ $registreProduccio['convos'] == 0 ? 'No Fet' : 'Fet'}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">INICI SALA:</td>
          <td class="col">{{ $registreProduccio['inici_sala']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">PPS:</td>
          <td class="col">{{ $registreProduccio['pps'] == 0 ? 'No Fet' : 'Fet'}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">FIANL SALA:</td>
          <td class="col">{{ $registreProduccio['final_sala']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">TÉCNIC MIX:</td>
          <td class="col">{{ array_key_exists("tecnic_mix", $empleats) ? $empleats["tecnic_mix"]->nom_empleat.' '.$empleats["tecnic_mix"]->cognom1_empleat.' '.$empleats["tecnic_mix"]->cognom2_empleat : ''}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">DATA TÉCNIC MIX:</td>
          <td class="col">{{ $registreProduccio['data_tecnic_mix']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">RETAKES:</td>
          <td class="col">{{ $registreProduccio['retakes']}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">QC MIX:</td>
          <td class="col">{{ $registreProduccio['qc_mix'] == 0 ? 'No Fet' : 'Fet'}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">PPE:</td>
          <td class="col">{{ $registreProduccio['ppe'] == 0 ? 'No Fet' : 'Fet'}}</td>
        </tr>
        </tr><tr class="row">
          <td class="font-weight-bold col-sm-3">ESTAT:</td>
          <td class="col">{{ $registreProduccio['estat']}}</td>
        </tr>
        
        
        
        
    </tbody>
  </table>
</div>
    <a href="{{ url('/registreProduccio') }}" class="btn btn-primary">
      <span class="fas fa-angle-double-left"></span>
      TORNAR
    </a>
@stop