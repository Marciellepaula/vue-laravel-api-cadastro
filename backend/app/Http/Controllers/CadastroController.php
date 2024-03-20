<?php

namespace App\Http\Controllers;

use App\Models\Cadastro;
use App\Models\CadastroPessoa;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CadastroController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */


    public function index()
    {

        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $cadastro = CadastroPessoa::with('upload')->get();

        foreach ($cadastro as $item) {
            foreach ($item->upload as $upload) {
                $upload->path = $upload->path ? url("storage/{$upload->path}") : null;
            }
        }

        return response()->json(['mensagen' => 'works', $cadastro]);
    }


    public function store(Request $request)
    {

        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $request->validate([
            'nome' => 'required|string',
            'email' => 'required|email',
            'cpf' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif',
            'path.*' => 'required|file|mimes:pdf'
        ]);


        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photoPath = $request->file('photo')->store('photos', 'public');

            $cadastro = CadastroPessoa::create([
                'nome' => $request->nome,
                'email' => $request->email,
                'cpf' => $request->cpf,
                'photo' => $photoPath,
            ]);

            $randomBytes = random_bytes(8);
            $password = $randomBytes;

            User::create([
                'name' => $cadastro->nome,
                'email' => $cadastro->email,
                'password' => $password
            ]);

            if ($request->hasFile('path')) {
                $files = $request->file('path');
                foreach ($files as $file) {
                    $filePath = $file->store('path', 'public');
                    Upload::create([
                        'cadastro_pessoa_id' => $cadastro->id,
                        'path' => $filePath,
                    ]);
                }
            }

            return response()->json(['message' => 'sucess register'], 200);
        }
        return response()->json(['message' => 'Failed to register'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $cadastro = CadastroPessoa::with('upload')->find($id);

        if (!$cadastro) {
            return response()->json(['error' => 'Cadastro not found'], 404);
        }
        $cadastro->toArray();
        return response()->json(['data' => $cadastro], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cadastro = CadastroPessoa::with('upload')->find($id);

        if (!$cadastro) {
            return response()->json(['message' => 'person not found'], 404);
        }

        // Eliminar o arquivo existente, se houver
        if ($cadastro->photo) {
            Storage::delete($cadastro->photo);
        }

        foreach ($cadastro->upload as $upload) {
            Storage::delete($upload->path);
            $upload->delete();
        }
        if ($request->has('photo')) {
            // Decode the base64 encoded image data
            $imageData = $request->input('photo');
            $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

            // Generate a unique filename
            $filename = 'photo_' . time() . '.jpg'; // You may want to adjust the filename as needed

            // Store the decoded image data
            Storage::disk('public')->put('photos/' . $filename, $decodedImage);

            // Update the 'photo' field in the database with the path to the stored image
            $cadastro->photo = 'photos/' . $filename;
        }

        if ($request->has('uploads')) {
            foreach ($request->input('uploads') as $file) {
                $filePath = $file->store('path');
                $decodedPdf = base64_decode(preg_replace('#^data:application/pdf;base64,#', '', $file));
                $filename = 'file_' . time() . '.pdf';
                Storage::disk('public')->put('path/' . $filename, $decodedPdf);

                $upload = new Upload();
                $upload->path = $filePath;

                // Assuming $cadastro is an instance of another model with a relationship named 'upload'
                $cadastro->upload()->save($upload); // save the upload relationship
            }
        }

        // Salvar as alterações no modelo
        $cadastro->save();
        $cadastro->update($request->only('nome', 'email', 'cpf'));

        return response()->json(['message' => 'Person updated', $request->all()], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cadastro = CadastroPessoa::find($id);   // destroy find id and 

        if (!$cadastro) {
            return response()->json(['error' => 'cadastro not found'], 404);
        }

        $cadastro->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
