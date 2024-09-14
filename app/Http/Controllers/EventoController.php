<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redireact;
use Illuminate\Support\Facades\Validator;


class EventoController extends Controller
{
    //mostar tela adiminstrativa
    public function MostrarHome(){
        return view('homeadm');
    }

    //tela de cadastro de eventos
    public function MostrarCadastroEvento(){
        return view('cadastrarevento');
    }

    //salvar registros na tabela eventos
    public function CadastrarEventos(Request $request){
        $registros = $request->validator([
            'nomeEvento'=>'string|required',
            'dataEvento'=>'date|required',
            'localEvento'=>'string|required',
            'imgEvento'=>'string|required'
        ]);

        Evento::create($registros);
        return Redirect::route('home-adm');
    }

    //apagar registros na tabela eventos
    public function destroy(Evento $id){
        $id->delete();
        return Redirect::route('home-adm');
    }

    //alter registros na tabelas eventos
    public function update(Evento $id, Request $request){
        $registros = $request->validator([
            'nomeEvento'=>'string|required',
            'dataEvento'=>'date|required',
            'localEvento'=>'string|required',
            'imgEvento'=>'string|required'
        ]);

        $id->fill($registros);
        $id->save();

        return Redireact::route('home-adm');
    }

    //mostrar evento por codigo
    public function MostrarEventoCodigo(Evento $id){
        return view('altera-evento', ['registroseventos'->$id]);
    }

    //buscar eventos pelo nome
    public function MostrarEventoNome(Request $request){
        $registros = Evento::query();
        $registros->when($request->nomeEvento,function($query, $valor){
            $query->when('nomeEvento','like','%',$valor,'%');
        });
    }
}
