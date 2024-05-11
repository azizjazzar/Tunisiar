<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comptes = Account::select('id', 'client', 'montant', 'num_bulletin', 'date_bulletin', 'debit', 'credit', 'created_at')->get();
        return response()->json($comptes);
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
        try {
            // Valider les données
            $validatedData = $request->validate([
                'client' => 'required|string',
                'montant' => 'nullable|numeric',
                'numBulletin' => 'required|string',
                'dateBulletin' => 'required|date',
                'nouvmontant' => 'required|numeric',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation pour le champ image
            ]);

            // Enregistrez les données dans la base de données
            $compteAlimentation = new Account();
            $compteAlimentation->client = $validatedData['client'];
            $compteAlimentation->montant = $validatedData['montant'] + $validatedData['nouvmontant']; // Ajouter le nouvmontant au montant actuel
            $compteAlimentation->num_bulletin = $validatedData['numBulletin'];
            $compteAlimentation->date_bulletin = $validatedData['dateBulletin'];
            $compteAlimentation->debit =$validatedData['nouvmontant']; // Ajuster le débit à 0 car aucun débit n'est enregistré lors de l'ajout de nouvmontant
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

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        $user = $account->user;
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }

    public function getmontant($client)
    {
        // Récupérer la dernière transaction du client depuis la table Account
        $lastTransaction = Account::where('client', $client)
            ->orderBy('updated_at', 'desc') // Triez par date de mise à jour décroissante pour obtenir la dernière transaction en premier
            ->first();
    
        // Vérifiez si une transaction a été trouvée
        if ($lastTransaction) {
            // Récupérer le montant de la dernière transaction
            $montant = $lastTransaction->montant;
    
            // Retourner le montant sous forme de réponse JSON
            return response()->json(['montant' => $montant]);
        } else {
            // Si aucune transaction n'a été trouvée, retournez un montant nul ou un message d'erreur
            return response()->json(['error' => 'Aucune transaction trouvée pour ce client'], 404);
        }
    }

    public function updateBalanceAndRecordCredit(Request $request)
    {
        $request->validate([
            'client' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        // Appeler la méthode du modèle pour mettre à jour le montant et enregistrer le crédit
        $compte = new Account();
        $compte->decreaseBalanceAndRecordCredit($request->client, $request->amount);

        return response()->json(['message' => 'montant mis à jour avec succès et crédit enregistré']);
    }



}
