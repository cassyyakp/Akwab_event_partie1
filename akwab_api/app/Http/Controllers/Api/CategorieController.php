<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Http\Resources\CategorieResource;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Cache::remember('categories.tous', 3600, function () {
            $categories = Categorie::all();
            return CategorieResource::collection($categories)->response()->getData(true);
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategorieRequest $request)
    {
        $categorie = Categorie::create($request->validated());

        Cache::forget('categories.tous');

        return response()->json([
            'success' => true,
            'categorie' => new CategorieResource($categorie),
            'message' => 'Catégorie créée avec succès'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categorie = Cache::remember("categorie.{$id}", 3600, function () use ($id) {
            return Categorie::where('id_categorie', $id)->firstOrFail();
        });

        return new CategorieResource($categorie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategorieRequest $request, string $id)
    {
        $categorie = Categorie::where('id_categorie', $id)->firstOrFail();
        $categorie->update($request->validated());

        Cache::forget("categorie.{$id}");
        Cache::forget('categories.tous');

        return response()->json([
            'success' => true,
            'categorie' => new CategorieResource($categorie->fresh()),
            'message' => 'Catégorie mise à jour avec succès'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categorie = Categorie::where('id_categorie', $id)->firstOrFail();
        $categorie->delete();

        Cache::forget("categorie.{$id}");
        Cache::forget('categories.tous');

        return response()->json([
            'success' => true,
            'message' => 'Catégorie espace supprimée avec succès'
        ], 200);
    }
}
