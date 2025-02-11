@inject('pessoa','Uspdev\Replicado\Pessoa')
@inject('replicado','App\Utils\ReplicadoUtils')

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
        border:1px solid; margin-top:0.3cm; margin-bottom:0.3cm; width: 15cm; font-size:12px; margin-left:4em;
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

    <div align="right">
        São Paulo, {{date('F jS\, Y')}}
    </div><br>

    <div class="moremargin">Subject: @if($agendamento->nivel == 'Mestrado') <b>Master's</b> @else <b>Doctorate's</b> @endif Examination Committee</div> 
    <div class="moremargin">Candidate: <b>{{$agendamento->nome}}</b> </div>
    <div class="moremargin">Area: <b>{{$replicado->nomeAreaProgramaEmIngles($agendamento->area_programa)}}</b> </div>
    <div class="moremargin">Supervisor: {{ $agendamento->nome_orientador ?? $pessoa::dump($agendamento->orientador)['nompes']}} @if($agendamento->co_orientador) and {{$agendamento->nome_co_orientador ?? $agendamento->dadosProfessor($agendamento->co_orientador)->nome}} @endif</div>
    <div class="moremargin">Title of the thesis: <i>{{$agendamento->title ?? $agendamento->titulo}} </i></div>
    <div class="importante">
        {!! $configs->important !!}
    </div>
    <p>
        <i>Defense's date and time:  </i> <b> {{Carbon\Carbon::parse($agendamento->data_horario)->format('F jS\, Y \a\t g a')}} (Brasília's Time)</b> <br> 
        <i>Place:</i> <b> {{$agendamento->sala}} </b> - FFLCH Administration 
    </p>  
    <i>Composition of the examination committee:</i> 


        @foreach($professores as $componente)    
        <div class="col">
            {{$agendamento->dadosProfessor($componente->codpes)->nome ?? 'Professor não cadastrado'}} 
           <b>{{$agendamento->dadosProfessor($componente->codpes)->lotado ?? ' '}}</b>
        </div>
        @endforeach
	<div class="importante" align="center"> 
        {!! $configs->regiment !!}
    </div>

    <p align="center">
        Sincerely, 
		<br>
        <b> 
            {{Auth::user()->name}} @if($pessoa::cracha(Auth::user()->codpes)) - Defenses of Master and Doctorate {{$pessoa::cracha(Auth::user()->codpes)['nomorg']}}/USP @endif 
		</b>
    </p>
    <br>
    {{$agendamento->dadosProfessor($professor->codpes)['nome'] ?? 'Professor não cadastrado'}}<br>
    {{$agendamento->dadosProfessor($professor->codpes)->endereco ?? ' '}}, {{$agendamento->dadosProfessor($professor->codpes)->bairro ?? ' '}} <br>
    Post Code:{{$agendamento->dadosProfessor($professor->codpes)->cep ?? ' '}} - {{$agendamento->dadosProfessor($professor->codpes)->cidade ?? ' '}}/{{$agendamento->dadosProfessor($professor->codpes)->estado ?? ' '}}
    <br> Phone: {{$agendamento->dadosProfessor($professor->codpes)->telefone ?? ' '}}
    <br>Email: {{$agendamento->dadosProfessor($professor->codpes)->email ?? ' '}}
@endsection('content')

@section('footer')
    {!! $configs->footer !!}
@endsection('footer')