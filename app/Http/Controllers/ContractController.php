<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contract;
use Exception;
class ContractController extends Controller
{
    /**
     * Store a newly created contract in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'clientType' => 'required|string',
                'list' => 'required|string',
                'libelle' => 'required|string',
                'contractStartDate' => 'required|date',
                'contractEndDate' => 'required|date',
                'minimumGuaranteed' => 'required|numeric',
                'travelStartDate' => 'required|date',
                'travelEndDate' => 'required|date',
                'isActive' => 'required|boolean',
                'activateInternetFees' => 'nullable|boolean',
                'modifyFeesAmount' => 'nullable|numeric',
                'TKXL' => 'nullable|boolean',
                'payLater' => 'nullable|boolean',
                'payLaterTimeLimit' => 'nullable|string',
                'minTimeBeforeFlightCC' => 'nullable|numeric',
                'minTimeBeforeFlightBalance' => 'nullable|numeric',
                'stampInvoice' => 'nullable|boolean',
                'additionalClientFees' => 'nullable|numeric',
                'discount' => 'nullable|boolean',
            ]);
    
            // Create a new contract instance
            $contract = new Contract();
    
            // Assign validated data to the contract properties
            $contract->fill($validatedData);
    
            // Save the contract to the database
            $contract->save();
    
            // Return a success response
            return response()->json(['message' => 'Contrat créé avec succès'], 201);
        } catch (\Exception $e) {
            // Return an error response with the specific error message
            return response()->json(['error' => 'Erreur lors de la création du contrat : ' . $e->getMessage()], 500);
        }
    }
    


    public function index()
    {
        $contracts = Contract::all(); // Récupérer tous les contrats depuis la base de données
        return response()->json($contracts); 
    }

    public function destroy($id)
{
    try {
        $contract = Contract::findOrFail($id);
        $contract->delete();
        return response()->json(['message' => 'Contrat deleted successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to delete contrat'], 500);
    }
}

public function show($id)
{
    // Récupérer le contrat par son ID
    $contract = Contract::find($id);

    if (!$contract) {
        return response()->json(['error' => 'Contract not found'], 404);
    }

    // Retourner les détails du contrat
    return response()->json($contract);
}


public function update(Request $request, $id)
{
    $contract = Contract::findOrFail($id);
    $contract->update($request->all());
    return response()->json($contract);
}


}
