<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompteAlimentation extends Model
{
    protected $table = 'comptealimentation'; 
    protected $fillable = [
        'client', 
        'montant', 
        'num_bulletin', 
        'date_bulletin', 
        'debit', 
        'credit', 
        'description', 
        'image'
    ];


    public function decreaseBalanceAndRecordCredit($client, $amount)
    {
        // Trouver la dernière transaction du client
        $lastTransaction = CompteAlimentation::where('client', $client)
            ->orderBy('updated_at', 'desc')
            ->first();
    
        // Vérifier si une transaction a été trouvée
        if ($lastTransaction) {
            // Diminuer le montant du client
            $lastTransaction->montant -= $amount;
    
            // Enregistrer le crédit
            $lastTransaction->credit += $amount;
    
            // Sauvegarder les modifications
            $lastTransaction->save();
    
            return $lastTransaction;
        } else {
            // Si aucune transaction n'a été trouvée, retourner une erreur
            throw new \Exception('Aucune transaction trouvée pour ce client');
        }
    }
    

}
