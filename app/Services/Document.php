<?php

namespace App\Services;

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class Document
{
    public function createDocx(array $data): \Illuminate\Http\JsonResponse
    {
        // Set custom temporary directory for PhpWord
        $tempDir = storage_path('tmp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        \PhpOffice\PhpWord\Settings::setTempDir($tempDir);

        $phpWord = new PhpWord();
        $phpWord->addFontStyle('pStyle', ['size' => 10, 'name' => 'Arial']);
        $phpWord->addFontStyle('headerStyle', ['bold' => true, 'bgColor' => 'f2f2f2']);
        $phpWord->addTitleStyle(1, ['size' => 10, 'bold' => true, 'name' => 'Arial']);

        // Define table style arrays
        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '999999',
            'cellMargin' => 50,
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
        ];
        $firstRowStyle = ['bgColor' => 'f2f2f2'];
        $cellStyle = ['valign' => 'center'];
        $fontStyle = ['bold' => true];
        $phpWord->addTableStyle('tableStyle', $tableStyle, $firstRowStyle);

        // Create a new section
        $section = $phpWord->addSection();

        // Add content
        $section->addTitle('Дата создания: ' .\Carbon::now(), 1);
        $section->addTitle('Заголовок: ' . $data['title'], 1);
        $section->addText('Регион: ' . $data['author'], 'pStyle');
        $section->addTextBreak();
        $section->addText('Описание: ' . $data['description'], 'pStyle');

        // Add table
        $table = $section->addTable('tableStyle');
        $table->addRow();
        $table->addCell(2000, $cellStyle)->addText('Первая колонка', $fontStyle);
        $table->addCell(2000, $cellStyle)->addText('Вторая колонка', $fontStyle);
        $table->addCell(2000, $cellStyle)->addText('Третья колонка', $fontStyle);
        $table->addCell(2000, $cellStyle)->addText('Четвертая колонка', $fontStyle);

        for ($i = 1; $i <= 3; $i++) {
            $table->addRow();
            for ($j = 1; $j <= 4; $j++) {
                $table->addCell(2000, $cellStyle)->addText('Значение ' . (($i - 1) * 4 + $j));
            }
        }

        // Save the document
        $filePath = public_path('documents/document.docx');
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);

        // Return the download link
        $downloadLink = url('documents/document.docx');
        return response()->json(['download_link' => $downloadLink]);
    }
}
