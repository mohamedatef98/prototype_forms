<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Form;

class FormController extends Controller
{
    public function index(){
        return Form::where('user_id', auth()->user()->id)->get();
    }

    public function view(Form $form){
        return $form;
    }

    public function store(Request $request){

        $form = new Form;

        $form->name = $request->input('name');

        $form->description = $request->input('description');

        $form->user_id = auth()->user()->id;

        $form->form = json_encode($request->input('form'));

        $form->save();

        return response('{"done": true}', 200);
    }

    public function update(Form $form, Request $request){
        $form->name = $request->input('name');

        $form->description = $request->input('description');

        $form->form = json_encode($request->input('form'));

        $form->save();

        return response('{"done": true}', 200);
    }

    public function destroy(Form $form){
        $form->delete();
    }
}
