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
    public static function calculator($amount, $rate, $term, $amortization_term, $type){

//        if ($type === 1){
            return round( ($amount * ($rate / 100) / 12) / (1 - (1 / (pow((1 + ($rate / 100) / 12), $term)))),-2);
//        }else{
//            $previousBalance = $amount;
//            $paymentBalance = $amount / $term;
//
//            for ($i = 1; $i <= $term; $i++) {
//                $paymentPercent = ($previousBalance * ($rate / 100) / 12);
//                return round($paymentPercent + $paymentBalance,-2);
//            }
//        }
    }


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

        $calculator = self::calculator($client->amount, $client->rate, $client->term, $client->amortization_term, $client->payment_type);
//        dump($settings);
//        dump( (int)$calculator);
//        die;

        $html =  view('export.word',[
            'client' => $client,
            'settings' => $settings,
            'monthlyPayment' => (int)$calculator,
        ])->render();

            Html::addHtml($section, $html, false, false,
                array(
                    'lineHeight' => 15,
                    'margin' => 50000
                )
            );

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = storage_path('/app/public/').sha1('') . '.docx';
        $phpWord->save($fileName);
        return response()->download($fileName);
    }

    public function calculatorPDF(Request $request)
    {
        $content = $request->get('content');
        $pdf = PDF::loadView('export.calculatorPDF', ['content' => $content]);
        $pdf->save(storage_path('mortgage_' . date('YmdHis') . '.pdf'));
        return $pdf->download('mortgage_' . date('YmdHis') . '.pdf');
    }
}
