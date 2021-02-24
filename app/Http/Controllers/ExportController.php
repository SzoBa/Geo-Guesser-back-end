<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{

    public function export (Request $request) {
        $spreadsheet = new Spreadsheet();
        $myScoresSheet = new Worksheet($spreadsheet, 'My scores');
        $spreadsheet->addSheet($myScoresSheet, 0);
        $spreadsheet->removeSheetByIndex(1);

        $this->setColumnTitles($myScoresSheet);
        $this->setColumnAutoWidth($myScoresSheet);

        $dataToExport = $this->getUserData($request);

        foreach ($dataToExport as $index => $row) {
            $myScoresSheet->fromArray((array)$row, NULL, 'A' . ($index + 2));
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('scores.xlsx');
        $file = public_path() . DIRECTORY_SEPARATOR . 'scores.xlsx';
        $headers = ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            "Access-Control-Allow-Origin" => "*",
            "Accept-Language" => "*"];
        return response()->download($file, 'scores.xlsx', $headers)->deleteFileAfterSend(true);
    }


    private function getUserData(Request $request): Collection
    {
        $userId = $request->user()->id;
        $userScores = DB::table('users')
            ->join('highscores', 'user_id', '=', 'users.id', 'left')
            ->select('highscores.score as score', 'highscores.map_id as mapid',
                'highscores.created_at as score_created', 'users.id as userid', 'users.name as username')
            ->where('users.id', $userId)
            ->orderBy('score', 'DESC');

        return DB::table('maps')
            ->joinSub($userScores, 'data', function ($join) {
                $join->on('maps.id', '=', 'data.mapid');
            })
            ->select('username', 'name as mapname', 'score', 'score_created')
            ->orderBy('mapname', 'ASC')
            ->orderBy('score', 'DESC')
            ->get();
    }

    private function setColumnTitles(Worksheet $userScores): void
    {
        $titles = ['Username', 'Map name', 'Score', 'Date'];
        $userScores->fromArray($titles, NULL, 'A1');
    }

    private function setColumnAutoWidth(Worksheet $userScores): void
    {
        $columns = ['A', 'B', 'C', 'D'];
        foreach ($columns as $column) {
            $userScores->getColumnDimension($column)->setAutoSize(true);
        }
    }
}
