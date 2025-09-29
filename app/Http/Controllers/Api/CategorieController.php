<?php

namespace App\Http\Controllers\Api;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::all();
        return($categories) ;

    }
     public function annoncesParCategorie()
   {
    $categories = Categorie::with('annonces')->get();

    return response()->json($categories);
  }


//    public function triAnnoncesParDate(Request $request)
//   {
//     $categorieId = $request->input('categorie_id');

//     if (!$categorieId) {
//         return response()->json([
//             'message' => 'Veuillez fournir l\'ID de la catégorie.'
//         ], 422);
//     }

//     $categorie = Categorie::with(['annonces' => function ($query) {
//         $query->orderBy('created_at', 'desc');
//     }])->find($categorieId);

//     if (!$categorie) {
//         return response()->json([
//             'message' => 'Catégorie non trouvée.'
//         ], 404);
//     }

//     return response()->json($categorie);
// }




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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
