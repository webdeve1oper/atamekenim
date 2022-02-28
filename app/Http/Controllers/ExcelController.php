<?php

namespace App\Http\Controllers;

use App\Help;
use App\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends Controller
{
    public function export(){
        $aliases = [
            'Отклонить'=>['fond_status'=>'cancel','admin_status'=>'cancel', 'status_kh'=>'not_approved'],
            'Одобрить и отправить фондам'=>['fond_status'=>'wait','admin_status'=>'finished', 'status_kh'=>'approved'],
            'Отправить модератору КХ'=>['fond_status'=>'moderate','admin_status'=>'finished', 'status_kh'=>'possible'],
            'Доработка - документы'=>['fond_status'=>'moderate','admin_status'=>'edit', 'status_kh'=>'not_approved'],
            'Доработка - описание'=>['fond_status'=>'moderate','admin_status'=>'edit', 'status_kh'=>'not_approved'],
            'Доработка - контактные данные'=>['fond_status'=>'moderate','admin_status'=>'edit', 'status_kh'=>'not_approved'],
        ];
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spread_sheet = $reader->load(public_path('export.xlsx'));
        $worksheet = $spread_sheet->getActiveSheet();
        $rows = [];
        foreach ($worksheet->getRowIterator() AS $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
            $cells = [];
            foreach ($cellIterator as $cell) {
                $cells[] = $cell->getValue();
            }
            $rows[] = $cells;
        }
        unset($rows[0]);
        foreach ($rows as $row){
            if(isset($aliases[$row[1]])){
                $help = Help::find($row[0]);
                if($help){
                    if($help->fond_status == 'wait' && $row[1] == 'Отправить модератору КХ'){
                        $help->status_kh = 'possible';
                        $help->save();
                    }else{
                        $help->update($aliases[$row[1]]);
                    }
                    if($row[1] == 'Доработка - документы'){
                        History::create(['admin_id'=>1, 'help_id'=>$help->id, 'status'=>'edit', 'desc'=>'Доработка - документы']);
                    }
                    if($row[1] == 'Доработка - описание'){
                        History::create(['admin_id'=>1, 'help_id'=>$help->id, 'status'=>'edit', 'desc'=>'Доработка - описание']);
                    }
                    if($row[1] == 'Доработка - контактные данные'){
                        History::create(['admin_id'=>1, 'help_id'=>$help->id, 'status'=>'edit', 'desc'=>'Доработка - контактные данные']);
                    }
                }
            }
        }
        return $rows;
    }
}
