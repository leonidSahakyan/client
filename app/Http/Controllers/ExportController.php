<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function calculator(Request $request){
        $content = $request->get('content');
        // Send data to the view using loadView function of PDF facade
        // Send data to the view using loadView function of PDF facade
        $pdf = PDF::loadView('export.calculatorPDF', ['content'=>$content]);
        // If you want to store the generated pdf to the server then you can use the store function
        $pdf->save(storage_path('mortgage_'.date('YmdHis').'.pdf'));
        // Finally, you can download the file using download function
        // Finally, you can download the file using download function
        return $pdf->download('mortgage_'.date('YmdHis').'.pdf');
    }
}
