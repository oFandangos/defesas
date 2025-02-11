@inject('pessoa','Uspdev\Replicado\Pessoa')

@extends('pdfs.fflch')
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
    @foreach($professores as $professor)
        <div align="right">
            @php(setlocale(LC_TIME, 'pt_BR','pt_BR.utf-8','portuguese'))
            São Paulo, {{ strftime('%d de %B de %Y', strtotime('today')) }}
        </div><br><br>

        Ilmo(a). Sr(a). {{$agendamento->dadosProfessor($professor->codpes)['nome'] ?? 'Professor não cadastrado'}}<br>
        {{$agendamento->dadosProfessor($professor->codpes)->endereco ?? ' '}}, {{$agendamento->dadosProfessor($professor->codpes)->bairro ?? ' '}} <br>
        CEP:{{$agendamento->dadosProfessor($professor->codpes)->cep ?? ' '}} - {{$agendamento->dadosProfessor($professor->codpes)->cidade ?? ' '}}/{{$agendamento->dadosProfessor($professor->codpes)->estado ?? ' '}}
        <br> telefone: {{$agendamento->dadosProfessor($professor->codpes)->telefone ?? ' '}}
        <br>e-mail: {{$agendamento->dadosProfessor($professor->codpes)->email ?? ' '}}
        <br>

        <div class="boxSuplente">
            <div class="moremargin">Assunto: Banca Examinadora de <b>{{$agendamento->nivel}}</b></div> 
            <div class="moremargin">Candidato(a): <b>{{$agendamento->nome}}</b> </div>
            <div class="moremargin">Área: <b>{{$agendamento->nome_area}}</b> </div>
            <div class="moremargin">Orientador(a) Prof(a). Dr(a). {{ $agendamento->nome_orientador ?? $pessoa::dump($agendamento->orientador)['nompes']}} @if($agendamento->co_orientador) e {{$agendamento->nome_co_orientador ?? $agendamento->dadosProfessor($agendamento->co_orientador)->nome}} @endif</div>
            <div class="moremargin">Título do Trabalho: <i>{{$agendamento->titulo}} </i></div>
        </div>

        <br>
        <div class="oficioSuplente">Sr(a). Prof(a). {{$agendamento->dadosProfessor($professor->codpes)->nome ?? 'Professor não cadastrado'}} </div>

        <div style="text-align:justify;">
            {!! $configs->oficio_suplente !!}
        </div>
        <div style="margin-top:2cm;" align="center"> 
            Atenciosamente,<br>  
            <b>
                {{Auth::user()->name}} @if($pessoa::cracha(Auth::user()->codpes)) - Defesas de Mestrado e Doutorado da {{$pessoa::cracha(Auth::user()->codpes)['nomorg']}}/USP @endif 
            </b>
        </div> 
        <p class="page-break"></p> 
    @endforeach
@endsection('content')

@section('footer')
    {!! $configs->rodape_oficios !!}
@endsection('footer')