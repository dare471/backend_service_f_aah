<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientNote;
use Illuminate\Http\Request;

class ClientNoteController extends Controller
{
   
    public function index(Request $request)
    {
        $contacts = ClientNote::where('id', $request->clientId)->get();
        return response()->json($contacts);
    }
    
    public function store(Request $request)
    {
        // Валидация входящих данных
        $validatedData = $request->validate([
            'clientId' => 'required|integer',
            'createdBy' => 'required|int',
            'description' => 'required|string',
            'answer' => 'required|string'
            // Добавьте другие поля и правила, если необходимо
        ]);

        // Создание нового ресурса с валидированными данными
        $contact = ClientNote::create($validatedData);

        // Отправка ответа с данными нового ресурса и статус-кодом 201
        return response()->json($contact, 201);
    }

    public function show(Request $request)
    {
        $contact = ClientNote::findOrFail($request->id);
        return response()->json($contact);
    }
   
    public function update(Request $request, $id)
    {
        $contact = ClientNote::findOrFail($id);
        $contact->update($request->all());
        return response()->json($contact);
    }
   
    public function destroy(Request $request)
    {
        ClientNote::findOrFail($request->id)->delete();
        return response()->json(null, 204); // 204 - код статуса для успешного выполнения без возвращения тела ответа
    }    
}
