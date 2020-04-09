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

        $phpWord->setDefaultParagraphStyle(
            array(
                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),
                'spacing' => 120,
                'lineHeight' => 1.1,
            )
        );

        $sectionStyle = array(
            'marginTop' => 700,
            'marginLeft' => 700,
            'marginBottom' => 700,
            'marginRight' => 700,
        );

        $section = $phpWord->addSection();
        $section->setStyle($sectionStyle);
        $section2 = $phpWord->addSection($sectionStyle);

        $client = Clients::find($id);

        $params = array(
            'amount' => (int)$client->amount,
            'term'   => (int)$client->term,
            'rate'   => (float)$client->rate,
            'amortization_period'   => (int)$client->amortization_period,
            'iad'   => $client->iad,
            'start_date'   => $client->start_date,
            'payment_type'   => (int)$client->payment_type,
        );
        $balanceMaturityDate = 0;
        $calc = $calculator->calculate($params);

        if ($client->payment_type === 1){
            $term = $client->term;
            $totalMonthly = floatval($client->term) * $calc;
            $balanceMaturityDate = $client->amount;
        }   else{
            $totalMonthly=  (int)$client->amortization_period * $calc;
            $term = $client->amortization_period;
            $balanceMaturityDate = ($client->amount - ($client->term * $calc));
        }
        $totalMonthly = round($totalMonthly,-1,PHP_ROUND_HALF_EVEN);
        $property_security = unserialize($client->property_security);

        $settings = self::clientSettings($client);
        $totalPayment = ($settings['appraisal'] + $balanceMaturityDate + $totalMonthly);
        $tcc = $totalPayment - ($balanceMaturityDate - ($settings['totalSum'] - $settings['appraisal']));
        $apr = ($tcc/$client->amount/($term/12*365)*365*100 );

        $htmlFirst =  view('export.word',[
            'client' => $client,
            'settings' => $settings,
            'monthlyPayment' => number_format($calc,0),
            'totalMonthly' => $totalMonthly,
            'property_security' => $property_security,

        ])->render();

        $htmlSecond =  view('export.wordSecond',[
            'client' => $client,
            'settings' => $settings,
            'monthlyPayment' => number_format($calc,0),
            'totalMonthly' => $totalMonthly,
            'totalPayment' => $totalPayment,
            'tcc' => $tcc,
            'apr' => $apr,
            'balanceMaturityDate' => $balanceMaturityDate,
        ])->render();

       Html::addHtml($section, $htmlFirst,false,false);
       Html::addHtml($section2, $htmlSecond,false,false);

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
