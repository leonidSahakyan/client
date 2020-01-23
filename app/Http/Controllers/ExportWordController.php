<?php


namespace App\Http\Controllers;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;

class ExportWordController extends Controller
{

    public function index()
    {
        $phpWord = new PhpWord();

//        return view('export.word');
        $html = view('export.word')->render();
        $section = $phpWord->addSection();

        Html::addHtml($section, $html, false);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = 'hello.docx';

        $objWriter->save(storage_path("$fileName"));

        return response()->download(storage_path("$fileName"));

    }
}
