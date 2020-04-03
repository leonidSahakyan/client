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
            $term = $client->term;
            $totalMonthly = (int)$client->term * (int)$calc;
        }   else{
            $totalMonthly=  (int)$client->amortization_period * (int)$calc;
            $term = $client->amortization_period;
        }


        $settings = self::clientSettings($client);
        $totalPayment = ($settings['appraisal'] + $client->amount + $totalMonthly);
        $tcc = $totalPayment - ($client->amount- ($settings['totalSum'] - $settings['appraisal']));
        $apr = ($tcc/$client->amount/($term/12*365)*365*100 );

        $html =  view('export.word',[
            'client' => $client,
            'settings' => $settings,
            'monthlyPayment' => $calc,
            'totalMonthly' => $totalMonthly,
            'totalPayment' => $totalPayment,
            'tcc' => $tcc,
            'apr' => $apr,
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


    public static function clientSettings($client){
        $settings = unserialize($client->settings);
        $fees = [];
        foreach ($settings as $key => $val) {
            $fees[$key] = intval($val['fee']);
        }
        $fees['totalSum'] = array_sum($fees);

       return $fees;
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
