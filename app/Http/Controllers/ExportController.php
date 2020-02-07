<?php

namespace App\Http\Controllers;

use App\Clients;
use PDF;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;

class ExportController extends Controller
{
    public function exportWord(int $id)
    {
        $phpWord = new PhpWord();

        $sectionStyle = array(
            'marginTop' => 400,
            'marginLeft' => 600,
            'marginBottom' => 400,
            'marginRight' => 600,

        );

        $section = $phpWord->addSection();
        $section->setStyle($sectionStyle);

        $client = Clients::find($id);
        $settings = unserialize($client->settings);


        $html =  view('export.word',[
            'client' => $client,
            'settings' => $settings
        ])->render();

            Html::addHtml($section, $html, false, false,
                array(
                    'lineHeight' => 15,
                    'margin' => 50000
                )
            );

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');

        $fileName = sha1('') . '.docx';

        $phpWord->save(storage_path("$fileName"));
        return response()->download(storage_path("$fileName"));
    }

    public function calculatorPDF(Request $request)
    {
        $content = $request->get('content');
        $pdf = PDF::loadView('export.calculatorPDF', ['content' => $content]);
        $pdf->save(storage_path('mortgage_' . date('YmdHis') . '.pdf'));
        return $pdf->download('mortgage_' . date('YmdHis') . '.pdf');
    }
}
