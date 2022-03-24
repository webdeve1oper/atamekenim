<?php

namespace App\Http\Controllers;

use App\Help;
use App\History;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends Controller
{
    public $i = 1;
    public $spreadsheet;
    public $sheet;
    public $worked_out_headers = [
        'A' => 'Имя пользователя (user ID)',
        'B' => 'ID Заявки',
        'C' => 'Дата изменения статуса',
        'D' => 'Статус',
        'E' => 'Значения справочника Причина',
        'F' => 'Регион',
        'G' => 'Сфера',
    ];
    public $new_headers = [
        'A' => 'ID Заявки',
        'B' => 'Дата поступления заявки',
        'C' => 'Сфера',
        'D' => 'Регион',
    ];

    public function exportXls(Request $request){
        if($request->method() == 'GET'){
            return view('backend.admin.export_xls');
        }elseif($request->method() == 'POST'){
            ini_set('max_execution_time', 120);
            ini_set('memory_limit', '512M');
            $this->spreadsheet = new Spreadsheet();
            $this->sheet = $this->spreadsheet->getActiveSheet();
            $date_from = null;
            $date_to = null;
            $type = null;
//            $helps = Help::with('region', 'addHelpTypes', 'adminHistory');
//            $helps =  Help::select('helps.id as help_id',
//                'helps.created_at as help_create_date',
//                'helps.region_id',
//                'history.created_at as history_create_date',
//                'history.status as history_status',
//                'helps.admin_status',
//                'helps.fond_status',
//                'regions.title_ru as region_title',
//                'regions.region_id',
//                'users.id as user_id',
//                'admins.email as admin_email',
//                'admins.id as admin_id',
//                'add_help_types.id',
//                'history.desc as desc',
//                'add_help_types.name_ru as add_help_name'
//            );
//            $helps = $helps->join('help_addhelptypes', 'helps.id', '=', 'help_addhelptypes.help_id')
//                     ->leftJoin('add_help_types', 'add_help_types.id', '=', 'help_addhelptypes.add_help_id')
//                     ->leftJoin('regions', 'helps.region_id', '=', 'regions.region_id')
//                     ->leftJoin('users', 'helps.user_id', '=', 'users.id');
//            $helps = $helps->leftJoin('history', 'helps.id', '=', 'history.help_id')->leftJoin('admins', 'history.admin_id', '=', 'admins.id');

            if(isset($request->date_from)){
                $date_from = $request->date_from;
            }
            if(isset($request->date_to)){
                $date_to = $request->date_to;
            }
            if(isset($request->type)){
                $type = $request->type;
            }
            $this->sheet->setCellValue('A' . $this->i, 'Дата от ' .date('d.m.Y', strtotime($date_from)));
            $this->sheet->setCellValue('B' . $this->i, 'Дата до '. date('d.m.Y', strtotime($date_to)));

            if($type == 1){
                $helps = Help::with(['addHelpTypes', 'region']);

                if($date_from){
                    $helps = $helps->where('helps.created_at', '>=', $date_from.' 00:00:00');
                }
                if($date_to){
                    $helps = $helps->where('helps.created_at', '<=', $date_to . ' 23:59:59');
                }

            }else{
                $helps = History::with(['help.region', 'admin', 'help.addHelpTypes']);
                if($date_from){
                    $helps = $helps->where('created_at', '>=', $date_from.' 00:00:00');
                }
                if($date_to){
                    $helps = $helps->where('created_at', '<=', $date_to . ' 23:59:59');
                }

            }
            $helps = $helps->get();
//            dd($helps->take(10));

            if($type == 1){
                $this->sheet->setCellValue('C' . $this->i, 'Поступило: '.$helps->count());
                $this->nextRow();
                $this->nextRow();
                foreach ($this->new_headers as $alpha => $value){
                    $this->sheet->setCellValue($alpha . $this->i, $value);
                }
                $this->nextRow();
                foreach ($helps as $help) {
                    $this->sheet->setCellValue('A' . $this->i, $help->id);
                    $this->sheet->setCellValue('B' . $this->i, Carbon::parse($help->created_at)->format('d.m.Y'));
                    $addHelpTypes = '';
                    foreach ($help->addHelpTypes as $addHelpType){
                        $addHelpTypes .= $addHelpType->name_ru . ',';
                    }
                    $this->sheet->setCellValue('C' . $this->i, $addHelpTypes);
                    $this->sheet->setCellValue('D' . $this->i, $help->region->title_ru);
                    $this->nextRow();
                }
            }else{
                $this->sheet->setCellValue('C' . $this->i, 'Отработано');
                $this->nextRow();
                $this->nextRow();
                foreach ($this->worked_out_headers as $alpha => $value){
                    $this->sheet->setCellValue($alpha . $this->i, $value);
                }
                $this->nextRow();
                foreach ($helps as $help) {
                    $this->sheet->setCellValue('A' . $this->i, $help->admin->email. ' ('.$help->admin->id.')') ;
                    $this->sheet->setCellValue('B' . $this->i, $help->help->id);
                    $this->sheet->setCellValue('C' . $this->i, Carbon::parse($help->created_at)->format('d.m.Y H:i'));
                    $this->sheet->setCellValue('D' . $this->i, $this->getStatus($help->status));
                    $this->sheet->setCellValue('E' . $this->i, $help->desc);
                    $this->sheet->setCellValue('F' . $this->i, $help->help->region->title_ru);
                    $addHelpTypes = '';
                    foreach ($help->help->addHelpTypes as $addHelpType){
                        $addHelpTypes .= $addHelpType->name_ru . ',';
                    }
                    $this->sheet->setCellValue('G' . $this->i, $addHelpTypes);
                    $this->nextRow();

                }
            }



            $writer = new Xlsx($this->spreadsheet);
            $writer->save('./' . date('d-m-Y') . '.xlsx');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . urlencode(date('d-m-Y') . '.xlsx') . '"');
            $writer->save('php://output');

        }
    }

    public function getStatus($status){
        if($status == 'finished'){
            return 'Одобрено';
        }elseif($status == 'edit'){
            return 'Отправлено на доработку';
        }elseif($status == 'cancel'){
            return 'Отклонено';
        }elseif($status == 'kh') {
            return 'Одобрено';
        }
    }

    public function skipRow()
    {
        $this->i += 2;
    }

    public function nextRow()
    {
        $this->i += 1;
    }

    public function export(){
        error_reporting(E_ALL);
        ini_set('display_errors','On');
        $aliases = [
            'Отклонить'=>['fond_status'=>'cancel','admin_status'=>'cancel', 'status_kh'=>'not_approved'],
            'Одобрить и отправить фондам'=>['fond_status'=>'wait','admin_status'=>'finished', 'status_kh'=>'not_approved'],
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
//        unset($rows[0]);
//        foreach ($rows as $row){
//            if(isset($aliases[$row[1]])){
//                $help = Help::find($row[0]);
//                if($help){
//                    if($help->fond_status == 'wait' && $row[1] == 'Отправить модератору КХ'){
//                        $help->status_kh = 'possible';
//                        $help->save();
//                    }else{
//                        $help->update($aliases[$row[1]]);
//                    }
//                    if($row[1] == 'Доработка - документы'){
//                        History::create(['admin_id'=>1, 'help_id'=>$help->id, 'status'=>'edit', 'desc'=>'Фонд «Казакстан Халкына» внимательно изучил Вашу заявку, но, к сожалению, не может оценить ее соответствие концепции Фонда без подтверждения указанных Вами сведений. Пожалуйста, приложите отсканированные копии документов, подтверждающие указанные Вами сведения.']);
//                    }
//                    if($row[1] == 'Доработка - описание'){
//                        History::create(['admin_id'=>1, 'help_id'=>$help->id, 'status'=>'edit', 'desc'=>'Фонд «Казакстан Халкына» внимательно изучил Вашу заявку, но, к сожалению, не может оценить ее соответствие концепции Фонда, поскольку описание является неполным. Пожалуйста, дополните описание Вашей жизненной ситуации.']);
//                     }
//                    if($row[1] == 'Доработка - контактные данные'){
//                        History::create(['admin_id'=>1, 'help_id'=>$help->id, 'status'=>'edit', 'desc'=>'Пожалуйста, укажите ваши контактные данные.']);
//                    }
//                }
//            }
//        }
//        return $rows;
    }
}
