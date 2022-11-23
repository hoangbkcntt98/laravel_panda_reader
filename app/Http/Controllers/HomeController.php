<?php

namespace App\Http\Controllers;

use App\Models\Vocabulary;
use App\Trait\GoogleExtension;
use Exception;
use Illuminate\Http\Request;

use Google\Service\Sheets;

class HomeController extends Controller
{
    use GoogleExtension;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function getSheet(Request $request)
    {
        $client = $this->getUserClient();
        $service = new Sheets($client);
        $spreadsheetId = env('VOCAB_SHEET_ID');
        $range = '単語!A2:H374';
        $sheet_data = $service->spreadsheets_values->get($spreadsheetId, $range);
        $sheet_data = $sheet_data['values'];
        $columns = [
            'no' => 0,
            'chapter_no' => 1,
            'chapter_name' => 2,
            'word' => 3,
            'reading' => 4,
            'meaning' => 5,
            'sentence' => 6,
            'related_kanji' => 7,
        ];
        Vocabulary::whereNotNull('id')->delete();
        foreach ($sheet_data as $row) {

            Vocabulary::create([
                'no' => $row[$columns['no']],
                'chapter_no' => $row[$columns['chapter_no']],
                'chapter_name' => $row[$columns['chapter_name']],
                'word' => $row[$columns['word']],
                'reading' => $row[$columns['reading']],
                'meaning' => $row[$columns['meaning']],
                'sentence' => $row[$columns['sentence']],
                'related_kanji' => $row[$columns['related_kanji']] ?? ''
            ]);
        }
        return response()->json($sheet_data);
    }
}
