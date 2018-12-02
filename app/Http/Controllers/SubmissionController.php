<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\{Form, Submission};

class SubmissionController extends Controller
{
    public function index(Form $form){
        return $form->submissions;
    }

    public function view(Submission $submission){
        return $submission;
    }

    public function store(Form $form, Request $request){
        $submission = new Submission;

        $submission->form_id = $form->id;

        $submission->data = json_encode($request->all());

        $submission->save();

        return response('{"done": true}', 200);
    }
}
