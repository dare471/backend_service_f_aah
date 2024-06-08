<?php
namespace App\Http\Controllers\user\document;

use App\Http\Controllers\Controller;
use App\Services\Document;
use Illuminate\Http\Request;

class GenerateDocument extends Controller
{
    protected $createDocument;

    public function  __construct(Document $createDocument)
    {
        $this->createDocument = $createDocument;
    }
    public function createDocs(Request $request)
    {
        $data = $request->only(['title', 'description', 'author']);
        $response = $this->createDocument->createDocx($data);
        return $response;
    }

    public function createPDF(Request $request)
    {
        $data = $this->createDocument->createPDF($request);
        return $data;
    }
}
