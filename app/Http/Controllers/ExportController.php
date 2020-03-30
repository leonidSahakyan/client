<?php

namespace App\Http\Controllers;

use App\Clients;
use App\Services\Calculator;
use PDF;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;

class ExportController extends Controller
{
    public function exportWord(int $id, Calculator $calculator)
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

        $params = array(
            'amount' => (int)$client->amount,
            'term'   => (int)$client->term,
            'rate'   => (float)$client->rate,
            'amortization_period'   => (int)$client->amortization_period,
            'iad'   => $client->iad,
            'start_date'   => $client->start_date,
            'payment_type'   => (int)$client->payment_type,
        );

        $calc = $calculator->calculate($params);

        if ($client->payment_type === 1){
            $totalMonthly = (int)$client->term * (int)$calc;
        }   else{
            $totalMonthly=  (int)$client->amortization_period * (int)$calc;
        }

        $html =  view('export.word',[
            'client' => $client,
            'settings' => $settings,
            'monthlyPayment' => $calc,
            'totalMonthly' => $totalMonthly,
        ])->render();

            Html::addHtml($section, $html, false, false,
                array(
                    'lineHeight' => 15,
                    'margin' => 50000
                )
            );

        IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = storage_path('/app/public/').sha1('') . '.docx';
        $phpWord->save($fileName);
        return response()->download($fileName);
    }

    public function calculatorPDF(Request $request)
    {
        $content = $request->get('content');
        $pdf = PDF::loadView('export.calculatorPDF', ['content' => $content]);
        $fileName = storage_path('/app/public/').'mortgage_'.date('YmdHis').'.pdf';
        $pdf->save($fileName);
        return $pdf->download('mortgage_' . date('YmdHis') . '.pdf');
    }
}
