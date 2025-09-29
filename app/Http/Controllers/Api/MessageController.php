<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Annonce;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index(Annonce $annonce)
 {
    // Récupère tous les messages liés à l'annonce
    $messages = $annonce->messages; // ✅ propriété magique après avoir défini la relation

    return response()->json($messages);
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
   public function store(Request $request, Annonce $annonce)
  {
    $validated = $request->validate([
        'contenu' => 'required|string|max:2000',
        'image'   => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('pictures', 'public');
    }

    // Associer le message à l'annonce et à l'utilisateur connecté
    $message = $annonce->messages()->create([
        'user_id'  => auth()->id(),
        'contenu'  => $validated['contenu'],
        'image'    => $validated['image'] ?? null,
    ]);

    return response()->json($message, 201);
   }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, Message $message)
    {
        $validated = $request->validate([
            'contenu' => 'required|string|max:2000',
            'image' => 'nullable|image|mimes:png,jpg,jpeg'
        ]);

         if($request->hasFile('image')){
          $validated['image']=$request->file('image')->store('pictures','public');
         }
         if ($message->user_id !== auth()->user()->id) {
        return response()->json(['message' => 'Non autorisé'], 403);
        }

         $message->update($validated);

        return response()->json([
            'message' => 'Votre message a été modifié',
            'updated_message' => $message,

        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return response()->json([
            'message'=>'le message est supprimé avec seccès',
        ]);
    }
}
