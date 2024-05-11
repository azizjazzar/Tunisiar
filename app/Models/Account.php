<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'user_id',
        'client',
        'montant',
        'num_bulletin',
        'date_bulletin',
        'debit',
        'credit',
        'description',
        'image',
    ];

    // Méthode pour mettre à jour le solde et enregistrer le crédit
    public static function decreaseBalanceAndRecordCredit($client, $amount)
    {
        // Implémentez ici la logique pour mettre à jour le solde du compte et enregistrer le crédit
        // Par exemple :
        $account = self::where('client', $client)->first();
        if ($account) {
            $account->montant -= $amount;
            $account->credit += $amount;
            $account->save();
        }
    }
}
