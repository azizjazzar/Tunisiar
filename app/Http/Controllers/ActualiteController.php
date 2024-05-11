<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActualiteController extends Controller
{
    public function index()
    {
        // Récupérer toutes les actualités
        $actualites = Actualite::all();
        return response()->json($actualites);
    }

    public function store(Request $request)
    {
        // Validation des données du formulaire
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string', // Modifier 'title' en 'titre' et garder la règle 'required'
            'contenu' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Règle pour valider une image
        ]);
    
        // Vérifiez si la validation a échoué
        if ($validator->fails()) {
            // Retournez les erreurs avec un code de statut 422 (Unprocessable Entity)
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Traitement de l'image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/'.$imageName;
        } else {
            $imagePath = null;
        }
    
        // Création et enregistrement de l'actualité
        $actualite = new Actualite();
        $actualite->titre = $request->titre; // Modifier 'title' en 'titre'
        $actualite->contenu = $request->contenu; // Garder 'contenu' inchangé
        $actualite->image = $imagePath; // Stockage du chemin de l'image
        $actualite->save();
    
        return response()->json($actualite, 201);
    }
    

    public function destroy($id)
    {
        // Supprimer une actualité par son ID
        Actualite::findOrFail($id)->delete();
        return response()->json('Actualité supprimée avec succès');
    }
}
