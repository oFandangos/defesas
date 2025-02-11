<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Uspdev\Replicado\Posgraduacao;
use App\Utils\ReplicadoUtils;
use Uspdev\Replicado\DB;
use App\Models\Banca;
use App\Models\Docente;
use App\Models\Communication;
use Uspdev\Replicado\Pessoa;
use App\Models\User;

class Agendamento extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = ['id'];

    public static function tipodefesaOptions() {
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
        if(!$dados){ //talvez não seja mais tão necessário
            $pessoa = ReplicadoUtils::retornarPessoa($codpes);
            $dados = (object) $pessoa;
        }
        return $dados;
    }
    public static function retornarDadosProfessor($codpes){
        return Pessoa::dump($codpes); //usado para retornar o CPF
    }

    public function nomeUsuario($id){
        return User::where('id',$id)->first();
    }

    public static function endereco($codpes){
        return Pessoa::obterEndereco($codpes); //método já retorna o endereço completo
    }

    //Função para devolver valores de select status
    public static function statusApprovalOptions(){
        return [
            'Aprovado',
            'Reprovado'
        ];
    }

    public function docente() {
        return $this->hasOne(Docente::class, 'n_usp', 'orientador');
    }


    public function user(){
        return $this->hasOne(User::class,'id','user_id_biblioteca');
    }

    public function comunicacao(){
        return $this->hasOne(Communication::class,'agendamento_id','id');
    }

}
