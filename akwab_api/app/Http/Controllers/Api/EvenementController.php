<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvenementRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Http\Requests\UpdateEvenementRequest;
use App\Http\Resources\EvenementResource;
use App\Models\Evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class EvenementController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->input('page', 1);

        return Cache::remember("evenements.tous.page.{$page}", 3600, function () {
            $evenements = Evenement::with('categorie')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return EvenementResource::collection($evenements)->response()->getData(true);
        });
    }

    public function store(StoreEvenementRequest $request)
    {

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('image'));
            $image->scale(width: 1280);
            $filename = uniqid() . '.webp';
            $path = 'evenements/' . $filename;
            $webp = $image->toWebp(quality: 80)->toString();
            Storage::disk('public')->put($path, $webp);
            $data['image'] = $path;
        }

        $evenement = Evenement::create($data);
        $this->invalidateListeCache();

        return response()->json([
            'success' => true,
            'evenement' => new EvenementResource($evenement),
            'message' => 'Événement créé avec succès'
        ], 201);
    }

    public function show(string $id)
    {
        $evenement = Cache::remember("evenement.{$id}", 3600, function () use ($id) {
            return Evenement::with('categorie')->findOrFail($id);
        });

        return new EvenementResource($evenement);
    }

    public function update(UpdateEvenementRequest $request, string $id)
    {
        $evenement = Evenement::findOrFail($id);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($evenement->image) {
                Storage::disk('public')->delete($evenement->image);
            }
            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->file('image'));
            $image->scale(width: 1280);
            $filename = uniqid() . '.webp';
            $path = 'evenements/' . $filename;
            $webp = $image->toWebp(quality: 80)->toString();
            Storage::disk('public')->put($path, $webp);
            $data['image'] = $path;
        }

        $evenement->update($data);

        Cache::forget("evenement.{$id}");
        $this->invalidateListeCache();

        return response()->json([
            'success' => true,
            'evenement' => new EvenementResource($evenement->fresh()),
            'message' => 'Événement mis à jour avec succès'
        ], 200);
    }

    public function destroy(string $id)
    {
        $evenement = Evenement::findOrFail($id);

        if ($evenement->image) {
            Storage::disk('public')->delete($evenement->image);
        }

        $evenement->delete();

        Cache::forget("evenement.{$id}");
        $this->invalidateListeCache();

        return response()->json([
            'success' => true,
            'message' => 'Événement supprimé avec succès'
        ]);
    }

    private function invalidateListeCache(): void
    {
        DB::table('cache')
            ->where('key', 'LIKE', '%evenements.tous.page.%')
            ->delete();
    }
}
