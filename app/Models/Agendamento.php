<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Uspdev\Replicado\Posgraduacao;
use App\Utils\ReplicadoUtils;
use App\Models\Banca;
use App\Models\Docente;
class Agendamento extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    //Função para devolver valores do select que eu tentei reproduzir
    public static function tipodefesaOptions(){
        return [
            'Presencial',
            'Hibrido',
            'Virtual'
        ];
    }

    public function bancas()
    {
        return $this->hasMany(Banca::class)->orderBy('presidente','desc')->orderBy('tipo', 'desc');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    //Função para formatar horário do agendamento
    public function formatDataHorario($agendamento){
        $agendamento->data = Carbon::parse($agendamento->data_horario)->format('d/m/Y');
        $agendamento->horario = Carbon::parse($agendamento->data_horario)->format('H:i');
        return $agendamento;
    }

    //Função para devolver valores de select
    public static function regimentoOptions(){
        return [
            'Antigo',
            'Novo'
        ];
    }

    //Função para devolver valores de select
    public static function nivelOptions(){
        return [
            'Mestrado',
            'Doutorado'
        ];
    }

    //Função para devolver valores de select
    public static function presidenteOptions(){
        return [
            'Sim',
            'Não'
        ];
    }

    //Função para devolver valores de select
    public static function tipoOptions(){
        return [
            'Titular',
            'Suplente'
        ];
    }

    //Função para devolver valores de select
    public static function programaOptions(){
        $programas = ReplicadoUtils::programasPosUnidade();
        foreach($programas as $programa){
            $programas_pos[] = [
                "codare" => $programa['codare'],
                "nomare" => $programa['nomare'],
            ];
        }
        return $programas_pos;
    }

    public static function devolverCodProgramas(){
        $programas = ReplicadoUtils::programasPosUnidade();
        foreach($programas as $programa){
            $cod_programas_pos[] = $programa['codare'];
        }
        return $cod_programas_pos;
    }

    //Função para devolver valores de select
    public static function orientadorvotanteOptions(){
        return [
            'Sim',
            'Não'
        ];
    }

    public static function dadosProfessor($codpes){
        $dados = Docente::where('n_usp', '=', $codpes)->first();
        if($dados != null){
            return $dados;
        }
        return new Docente;
    }

    public function nomeUsuario($id){
        return User::where('id',$id)->first()->name;
    }

    //Função para devolver valores de select status
    public static function statusApprovalOptions(){
        return [
            'Aprovado',
            'Reprovado'
        ];
    }
}
