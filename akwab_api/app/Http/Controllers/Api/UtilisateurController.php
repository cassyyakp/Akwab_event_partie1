<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUtilisateurRequest;
use App\Http\Requests\UpdateUtilisateurRequest;
use App\Http\Resources\UtilisateurResource;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UtilisateurController extends Controller
{
    public function index()
    {
        $utilisateurs = Cache::remember('utilisateurs', 60, function () {
            return Utilisateur::all();
        });
        return response()->json([
            'success' => true,
            'data'    => UtilisateurResource::collection($utilisateurs),
        ]);
    }

    public function profil(Request $request)
    {
        return response()->json([
            'success' => true,
            'data'    => new UtilisateurResource($request->user()),
        ]);
    }

    public function show($id)
    {
        $utilisateur = Cache::remember("utilisateur_{$id}", 60, function () use ($id) {
            return Utilisateur::find($id);
        });
        if (!$utilisateur) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }
        return response()->json(['success' => true, 'data' => new UtilisateurResource($utilisateur)]);
    }

    public function store(StoreUtilisateurRequest $request)
    {
        $data = $request->validated();
        $data['mot_de_passe'] = Hash::make($data['mot_de_passe']);
        $data['id_role'] = 2;

        $utilisateur = Utilisateur::create($data);
        Cache::forget('utilisateurs');

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur créé',
            'data'    => new UtilisateurResource($utilisateur),
        ], 201);
    }

    

    public function update(UpdateUtilisateurRequest $request, $id)
    {
        $utilisateur = Utilisateur::find($id);
        if (!$utilisateur) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }
        $utilisateur->update($request->validated());
        Cache::forget('utilisateurs');
        Cache::forget("utilisateur_{$id}");
        return response()->json([
            'success' => true,
            'message' => 'Utilisateur mis à jour',
            'data'    => new UtilisateurResource($utilisateur),
        ]);
    }

    public function destroy($id)
    {
        $utilisateur = Utilisateur::find($id);
        if (!$utilisateur) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé'], 404);
        }
        $utilisateur->delete();
        Cache::forget('utilisateurs');
        Cache::forget("utilisateur_{$id}");
        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé',
        ]);
    }
}
