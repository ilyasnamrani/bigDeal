<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(auth()->user()->annonces);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:150',
            'description' => 'nullable|string|max:400',
            'categorie_id' => 'required|exists:categories,id', // ⚡ Vérifie que l'ID existe bien
            'ville' => 'nullable|string|max:20',
            'etat'=> 'required|in:occasion,neuf',
            'status'=> 'required|in:disponible,vendue',
            'region' => 'nullable|string|max:20',
            'image'=>'image|mimes:png,jpg,jpeg',
            'galerie' => 'nullable|array', // doit être un tableau
            'galerie.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'prix' => 'nullable|numeric|min:100',
            //'categorie' => 'required|in:Électronique,Sports,Maison,Vêtements,Chaussures',

        ]);

          if($request->hasFile('image')){
          $data['image']=$request->file('image')->store('pictures','public');
         }
         if ($request->hasFile('galerie')) {
            $paths = [];
               foreach ($request->file('galerie') as $file) {
                  $paths[] = $file->store('pictures', 'public');
        }
         $data['galerie'] = json_encode($paths);
        }
         $data['user_id']=$request->user()->id;
        $annonce = auth()->user()->annonces()->create($data);
        return response()->json($annonce,201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Annonce $annonce)
{
    // Validation
    $validated = $request->validate([
        'titre' => ['required', 'string', 'max:150'],
        'categorie_id' => 'required|exists:categories,id', // ⚡ Vérifie que l'ID existe bien
        'description' => ['nullable', 'string', 'max:255'],
        'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
        'prix' => ['required', 'numeric','min:100'],
        'ville' => 'nullable|string|max:20',
        'etat'=> 'required|in:occasion,neuf',
        'status'=> 'required|in:disponible,vendue',
        'region' => 'nullable|string|max:20',
        'galerie' => 'nullable|array', // doit être un tableau
        'galerie.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        'prix' => 'nullable|numeric|min:100',

    ]);

    // Gérer l'image si présente
             if ($request->hasFile('image')) {
                     $validated['image'] = $request->file('image')->store('pictures','public');
            }

          if($request->hasFile('image')){
          $data['image']=$request->file('image')->store('pictures','public');
         }
         if ($request->hasFile('galerie')) {
            $paths = [];
               foreach ($request->file('galerie') as $file) {
                  $paths[] = $file->store('pictures', 'public');
        }
         $data['galerie'] = json_encode($paths);
        }

    // Vérifier que l'utilisateur est le propriétaire (optionnel mais recommandé)
    if ($annonce->user_id !== auth()->user()->id) {
        return response()->json(['message' => 'Non autorisé'], 403);
    }

    // Mettre à jour l'annonce
    $annonce->update($validated);

    return response()->json([
        'message' => 'Annonce est modifiée avec succès',
        'annonce' => $annonce
    ]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Annonce $annonce)
    {
        $annonce->delete();
        return response()->json([
            'message'=> 'Annonce supprimée avec succès',
        ]);
    }
}
