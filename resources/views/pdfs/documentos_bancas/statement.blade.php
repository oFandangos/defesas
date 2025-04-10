@inject('pessoa','Uspdev\Replicado\Pessoa')

@extends('laravel-fflch-pdf::main')
@section('other_styles')
<style type="text/css">
    .data_hoje{
        margin-left: 10cm; margin-bottom:0.8cm;
    }
    .conteudo{
        margin: 1cm
    }
    .boxSuplente {
        border: 1px solid; padding: 4px;
    }
    .boxPassagem {
        border: 1px solid; padding: 4px; text-align: justify;
    }
    .oficioSuplente{
        text-align: justify;
    }
    .rodapeFFLCH{
        padding-top:3cm; text-align: center;
    }
    p.recuo {
        text-indent: 0.5em;
        direction: rtl;
    }
    .moremargin {
        margin-bottom: 0.15cm;
    }
    .importante {
        border:1px solid; margin-top:0.3cm; margin-bottom:0.3cm; width: 15cm; font-size:12px; margin-left:0.5cm;
    }
    .negrito {
        font-weight: bolder;
    }
    .justificar{
        text-align: justify;
    }
    table{
        border-collapse: collapse;
        border: 0px solid #000;
    }
    table th, table td {
        border: 0px solid #000;
    }
    tr, td {
        border: 1px #000 solid; padding: 1
    }
    body{
        margin-top: 0.2em; margin-left: 1.8em; font-family: DejaVu Sans, sans-serif; font-size: 12px;
    }
    #footer{
        text-align:center;
    }
</style>
@endsection('other_styles')

@section('content')
  <h1 align="center"> STATEMENT OF PARTICIPATION </h1>
  <br><br><br>
  <p class="recuo justificar" style="line-height: 190%;">
    {!!$configs->statement!!}
  </p><br>
  @foreach($professores as $docente)
    <div class="col">
      <b>{{ $docente['nompesttd'] ?? 'Professor não cadastrado' }}</b>
      <b>{{ $docente['setor']['sglclgund'] }} {{ ($docente['tipvin'] == 'SERVIDOR') ? ' - USP' : ''  }}</b>
    </div>
  @endforeach
  <br><br>
  <div align="right">
    @php(setlocale(LC_TIME, 'pt_BR','pt_BR.utf-8','portuguese'))
    Graduate Studies Services of University of São Paulo, {{Carbon\Carbon::parse($agendamento['data_horario'])->format('F jS\, Y')}}
  </div><br>
@endsection('content')

@section('footer')
    {!! $configs->footer !!}
@endsection('footer')
