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

        $html = view('export.word')->render();
        $section = $phpWord->addSection();
        $section->setStyle(array(['marginTop'=> 0.5]));

//        Html::addHtml($section, $html);

        $section->addText(date('M d, Y'),
            array('name' => 'Tahoma', 'size' => 10)
        );
        $section->addText("  A Borrower"
              ,
            array('name' => 'Tahoma', 'size' => 10, 'bold'=>true)
        );
        $section->addText(
            "  123 First Street"
              ,
            array('name' => 'Tahoma', 'size' => 10, 'bold'=>true)
        );
        $section->addText(
            " Vancouver, BC V1V-1V1 "
              ,
            array('name' => 'Tahoma', 'size' => 10, 'bold'=>true,array('marginTop'=> 45))
        );

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $fileName = md5('').'.docx';

        $objWriter->save(storage_path("$fileName"));

        return response()->download(storage_path("$fileName"));
    }
}
