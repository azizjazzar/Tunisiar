<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompteAlimentation;

class CompteAlimentationController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Valider les données
            $validatedData = $request->validate([
                'client' => 'required|string',
                'solde' => 'nullable|numeric',
                'numBulletin' => 'required|string',
                'dateBulletin' => 'required|date',
                'montant' => 'required|numeric',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation pour le champ image
            ]);

            // Enregistrez les données dans la base de données
            $compteAlimentation = new CompteAlimentation();
            $compteAlimentation->client = $validatedData['client'];
            $compteAlimentation->solde = $validatedData['solde'] + $validatedData['montant']; // Ajouter le montant au solde actuel
            $compteAlimentation->num_bulletin = $validatedData['numBulletin'];
            $compteAlimentation->date_bulletin = $validatedData['dateBulletin'];
            $compteAlimentation->debit =$validatedData['montant']; // Ajuster le débit à 0 car aucun débit n'est enregistré lors de l'ajout de montant
            $compteAlimentation->credit = 0; // Initialiser la colonne credit à 0
            $compteAlimentation->description = $validatedData['description'];
            
            // Gérer le téléchargement du fichier de l'image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->storeAs('images', $imageName); // Stockez l'image dans le répertoire "images"
                $compteAlimentation->image = $imageName; // Enregistrez le nom du fichier dans la base de données
            }

            $compteAlimentation->save();

            // Retourner une réponse JSON indiquant que la transaction a été enregistrée avec succès
            return response()->json(['message' => 'Transaction enregistrée avec succès'], 201);
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une réponse JSON avec le message d'erreur de l'exception
            return response()->json(['message' => 'Une erreur est survenue lors de l\'enregistrement de la transaction. Veuillez réessayer plus tard.', 'error' => $e->getMessage()], 500);
        }
    }

    public function index()
    {
        $comptes = CompteAlimentation::select('id', 'client', 'solde', 'num_bulletin', 'date_bulletin', 'debit', 'credit', 'created_at')->get();
        return response()->json($comptes);
    }

    public function updateBalanceAndRecordCredit(Request $request)
    {
        $request->validate([
            'client' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        // Appeler la méthode du modèle pour mettre à jour le solde et enregistrer le crédit
        $compte = new CompteAlimentation();
        $compte->decreaseBalanceAndRecordCredit($request->client, $request->amount);

        return response()->json(['message' => 'Solde mis à jour avec succès et crédit enregistré']);
    }


    public function getSolde($client)
{
    // Récupérer la dernière transaction du client depuis la table CompteAlimentation
    $lastTransaction = CompteAlimentation::where('client', $client)
        ->orderBy('updated_at', 'desc') // Triez par date de mise à jour décroissante pour obtenir la dernière transaction en premier
        ->first();

    // Vérifiez si une transaction a été trouvée
    if ($lastTransaction) {
        // Récupérer le solde de la dernière transaction
        $solde = $lastTransaction->solde;

        // Retourner le solde sous forme de réponse JSON
        return response()->json(['solde' => $solde]);
    } else {
        // Si aucune transaction n'a été trouvée, retournez un solde nul ou un message d'erreur
        return response()->json(['error' => 'Aucune transaction trouvée pour ce client'], 404);
    }
}


}
