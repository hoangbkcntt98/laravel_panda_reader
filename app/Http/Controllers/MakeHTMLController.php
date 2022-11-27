<?php

namespace App\Http\Controllers;

use App\Models\Adverb;
use App\Models\Grammar;
use App\Models\Kanji;
use App\Models\Vocabulary;
use App\Models\WordFormation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeHTMLController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.review_html',[
            'style' => sprintf('template/%s/style.css', "vocabulary")
        ]);
    }

    public function getModel($type)
    {

        $query = null;
        switch ($type) {
            case 'vocabulary':
                $query = Vocabulary::class;
                break;
            case 'adverb':
                $query = Adverb::class;
                break;
            case 'grammar':
                $query = Grammar::class;
                break;
            case 'word_formation':
                $query = WordFormation::class;
                break;
            case 'kanji':
                $query = Kanji::class;
                break;
            default:
                $query = Vocabulary::class;
                break;
        }
        return $query;
    }

    public function make(Request $request)
    {
        $material = $request->get('route');
        $style = sprintf('template/%s/style.css', $material);
        $template = sprintf('template/%s/template.html', $material);
        $template = File::get($template);
        $body = '';
        $model = $this->getModel($material);
        $query = $model::query();
        $from = $request->get('from');
        $to = $request->get('to');
        if($from){
            $query->where('no', ">", intval($from));
        }
        if($to){
            $query->where('no', "<=", intval($to)+1);
        }
        if($from && $to){
            if($from > $to)
            {
                return 'Invalid Value: From > To';
            }
        }
        $query->orderBy('no');
        $items = $query->get();
        $display_columns = $model::getTableColumns();
        foreach ($items as $item) {
            $content = $template;
            if($item->no==0) continue;
            foreach ($display_columns as $column) {
                $replace_text = $item->{$column};
                $need_replace = "{{{$column}}}";
            
                if(Str::contains($content, $need_replace)){
                    $content = Str::replace($need_replace, $replace_text, $content);
                }

            }
            $body.=$content;
        }
        return view('pages.review_html',[
            'body' => $body,
            'style' => $style
        ]);
    }
}
