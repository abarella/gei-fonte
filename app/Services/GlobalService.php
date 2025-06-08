<?php

namespace App\Services;

use App\Models\Produto\ProdutoAtividade;
use Illuminate\Support\Facades\DB;

/**
 * Uma especie de classe facade com todas as procedures necessária para o sistema
 *
 * @author Alberto Barella Junior <alberto@abjinfo.com.br>
 */
class GlobalService
{


    public static function populaTabelaEmissor()
    {

        $result = "";
        $dbh = DB::connection()->getPdo();

        $sql = "select id, descricao from tb_emissor";

        $sth = $dbh->prepare($sql);
        $sth->execute();
        $obj = $sth->fetchObject();

        if (!is_null($obj)) {
            $result = DB::select($sql);
        }

        $result = array_map(function ($value) {
            return (array) $value;
        }, $result);
        //dd($result);

        return $result;


    }

    public static function populaTabelaGrupo()
    {

        $result = "";
        $dbh = DB::connection()->getPdo();

        //$sql = "select id, id_emissor, descricao from tb_grupo";


        $sql = "select A.id, convert(varchar,B.id)+ ' - ' + B.descricao as Emissor, A.descricao, A.emails, A.cc, A.bcc
        from tb_grupo A
        inner join tb_emissor B on B.id = A.id_emissor ";


        $sth = $dbh->prepare($sql);
        $sth->execute();
        $obj = $sth->fetchObject();

        if (!is_null($obj)) {
            $result = DB::select($sql);
        }

        $result = array_map(function ($value) {
            return (array) $value;
        }, $result);
        //dd($result);

        return $result;


    }


    public static function retornaUsuariosCadastrados()
    {

        $result = "";
        $dbh = DB::connection()->getPdo();

        $sql = "set nocount on;EXEC [PORTAL_CORPORATIVO].[dbo].[sp_Permissao_Usuario] 'alberto.j-basis'";

        $sth = $dbh->prepare($sql);
        $sth->execute();
        $obj = $sth->fetchObject();

        if (!is_null($obj)) {
            $result = DB::select($sql);
        }

        $result = array_map(function ($value) {
            return (array) $value;
        }, $result);
        //dd($result);
        return $result;


    }


    public static function validaAcesso(string $usuario){


        $result = "";
        $dbh = DB::connection()->getPdo();

        $sql = "select * from tb_usuario_aplicacao
                inner join tb_aplicacao on tb_aplicacao.id =  tb_usuario_aplicacao.id_aplicacao
                where aplicacao = 'GEI'
                  and usuario = '" .$usuario . "'
        ";

        $sth = $dbh->prepare($sql);
        $sth->execute();
        $obj = $sth->fetchObject();

        if (!is_null($obj)) {
            $result = DB::select($sql);
        }

        $result = array_map(function ($value) {
            return (array) $value;
        }, $result);
        //dd($result);
        return $result;



    }



    public static function populaTabelaAssinatura()
    {

        $result = "";
        $dbh = DB::connection()->getPdo();

        //$sql = "select id, id_emissor, descricao from tb_grupo";


        $sql = "select A.id, A.assinatura
        from tb_assinatura A";



        $sth = $dbh->prepare($sql);
        $sth->execute();
        $obj = $sth->fetchObject();

        if (!is_null($obj)) {
            $result = DB::select($sql);
        }

        $result = array_map(function ($value) {
            return (array) $value;
        }, $result);
        //dd($result);

        return $result;


    }

    public static function populaTabelaAssunto()
    {

        $result = "";
        $dbh = DB::connection()->getPdo();

        //$sql = "select id, id_emissor, descricao from tb_grupo";


        $sql = "select id, assunto
        from tb_assunto ";



        $sth = $dbh->prepare($sql);
        $sth->execute();
        $obj = $sth->fetchObject();

        if (!is_null($obj)) {
            $result = DB::select($sql);
        }

        $result = array_map(function ($value) {
            return (array) $value;
        }, $result);
        //dd($result);

        return $result;


    }

    public static function populaTabelaAplicacao()
    {

        $result = "";
        $dbh = DB::connection()->getPdo();

        //$sql = "select id, id_emissor, descricao from tb_grupo";


        $sql = "select id, aplicacao
        from tb_aplicacao ";



        $sth = $dbh->prepare($sql);
        $sth->execute();
        $obj = $sth->fetchObject();

        if (!is_null($obj)) {
            $result = DB::select($sql);
        }

        $result = array_map(function ($value) {
            return (array) $value;
        }, $result);
        //dd($result);

        return $result;


    }

    public static function populaTabelaUsuarioPermissao()
    {

        $result = "";
        $dbh = DB::connection()->getPdo();

        //$sql = "select id, id_emissor, descricao from tb_grupo";


        $sql = "select A.id, convert(varchar,B.id)+ ' - ' + B.aplicacao as Aplicacao, A.usuario
        from tb_usuario_aplicacao A
        inner join tb_aplicacao B on B.id = A.id_aplicacao
         ";


        $sth = $dbh->prepare($sql);
        $sth->execute();
        $obj = $sth->fetchObject();

        if (!is_null($obj)) {
            $result = DB::select($sql);
        }

        $result = array_map(function ($value) {
            return (array) $value;
        }, $result);
        //dd($result);

        return $result;


    }


}
