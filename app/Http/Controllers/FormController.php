<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

    public function print(Form $form){

        $submissions = $form->submissions;
        $allKeys = array();

        for($i = 0; $i < $submissions->count(); ++$i){

            $submission = $submissions[$i];
            $data = json_decode($submission->data, true);
            $keys = array_keys($data);

            for($j = 0; $j < count($keys); ++$j){

                if(! in_array($keys[$j], $allKeys)){
                    $allKeys[] = $keys[$j];
                }
            }
        }


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValueByColumnAndRow(1, 1, 'id');
        $i = 0;
        while($i < count($allKeys)){
            $sheet->setCellValueByColumnAndRow($i + 2, 1, $allKeys[$i]);
            $i++;
        }
        $sheet->setCellValueByColumnAndRow($i + 2, 1, 'created_at');

        for($i = 0; $i < $submissions->count(); ++$i){
            $submission = $submissions[$i];
            $sheet->setCellValueByColumnAndRow(1, $i + 2, $submission->id);
            $data = json_decode($submission->data, true);
            $j = 0;
            while($j < count($allKeys)) {
                $sheet->setCellValueByColumnAndRow($j + 2,
                                    $i + 2,
                                    isset($data[$allKeys[$j]]) ? $data[$allKeys[$j]] : "");
                $j++;
            }
            $sheet->setCellValueByColumnAndRow($j + 1, $i + 2, $submission->created_at);
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'name-of-the-generated-file';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
