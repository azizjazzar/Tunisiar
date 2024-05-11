<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_type' => 'required',
            'officeId' => 'required',
            'currency' => 'required',
            'corporate_code' => 'required',
            'mission_code' => 'required',
            'username' => 'required',
            'tax_identification_number' => 'required',
            'owner' => 'required',
            'address' => 'required',
            'phoneNumber1' => 'required',
            'phoneNumber2' => 'required',
            'fax' => 'required',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|min:9',
            'state' => 'required',
            'logo_path' => 'required',
        ]);

        // Vérifier si la validation a échoué
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages(),]);
        } else {
            // Créer un nouvel utilisateur
            $user = User::create([
                'client_type' => $request->client_type,
                'officeId' => $request->officeId,
                'currency' => $request->currency,
                'corporate_code' => $request->corporate_code,
                'mission_code' => $request->mission_code,
                'username' => $request->username,
                'tax_identification_number' => $request->tax_identification_number,
                'owner' => $request->owner,
                'address' => $request->address,
                'phoneNumber1' => $request->phoneNumber1,
                'phoneNumber2' => $request->phoneNumber2,
                'fax' => $request->fax,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'state' => $request->state,
                'logo_path' => $request->logo_path,
                // Ajoutez d'autres champs utilisateur si nécessaire
            ]);

            // Générer un jeton pour l'utilisateur
            $token = $user->createToken($user->email . 'Token')->plainTextToken;


            // Retourner la réponse avec les détails de l'utilisateur, le jeton et un message de succès
            return response()->json([

                'message' => 'Utilisateur créé avec succès',
                'token' => $token,


            ]);
        }
    }
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }

    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|max:191',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'validation_errors' => $validator->messages(),
        ]);
    } else {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'L\'adresse email ou le mot de passe est invalide.',
            ]);
        } else {
            $token = $user->createToken($user->email . 'Token')->plainTextToken;
            
            // Récupérer le nom de l'organisation
            $username = $user->username;

            // Retourner la réponse avec les détails de l'utilisateur, le jeton et le nom de l'organisation
            return response()->json([
                'iduser'=>$user,
                'message' => 'logged avec succès',
                'token' => $token,
                'username' => $username,
            ]);
        }
    }
}

    


    public function update(Request $request, $id)
{
    // Récupérer l'utilisateur à mettre à jour
    $user = User::findOrFail($id);

    // Valider les données de la requête
    $validator = Validator::make($request->all(), [
        'client_type' => 'required',
        'officeId' => 'required',
        'currency' => 'required',
        'corporate_code' => 'required',
        'mission_code' => 'required',
        'username' => 'required',
        'tax_identification_number' => 'required',
        'owner' => 'required',
        'address' => 'required',
        'phoneNumber1' => 'required',
        'phoneNumber2' => 'required',
        'email' => 'required|email|max:191|unique:users,email,'.$id,
        'state' => 'required',
        'logo_path' => 'required',
    ]);

    // Si la validation échoue, retourner les erreurs
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->messages()]);
    }

    // Mettre à jour les champs de l'utilisateur
    $user->update([
        'client_type' => $request->client_type,
        'officeId' => $request->officeId,
        'currency' => $request->currency,
        'corporate_code' => $request->corporate_code,
        'mission_code' => $request->mission_code,
        'username' => $request->username,
        'tax_identification_number' => $request->tax_identification_number,
        'owner' => $request->owner,
        'address' => $request->address,
        'phoneNumber1' => $request->phoneNumber1,
        'phoneNumber2' => $request->phoneNumber2,
        'fax' => $request->fax,
        'email' => $request->email,
        'state' => $request->state,
        'logo_path' => $request->logo_path,
    ]);

    // Vérifier si un nouveau mot de passe est fourni
    if ($request->has('password')) {
        // Hasher le nouveau mot de passe et mettre à jour l'utilisateur
        $user->password = Hash::make($request->password);
        $user->save();
    }

    // Retourner un message de succès
    return response()->json([
        'status'=>200,
        'user'=>$user ,
        'message' => 'Utilisateur mis à jour avec succès']);
}
public function show($id)
{
    $user = User::with('account')->findOrFail($id);   
    return response()->json($user);
}

public function getUserCount()
{
    $userCount = User::count();
    return response()->json(['count' => $userCount]); 
}



    public function logout(Request $request)
{
    $request->user()->tokens()->delete();

    return response()->json(['message' => 'Déconnexion réussie']);
}

public function getClientData()
{
    try {
        // Récupérer les types de clients distincts depuis la base de données
        $clientData = User::select('client_type')->distinct()->get()->pluck('client_type')->toArray();

        // Envoyer les données sous forme de réponse JSON
        return response()->json($clientData);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la récupération des données du type de client : ' . $e->getMessage()], 500);
    }
}


}
