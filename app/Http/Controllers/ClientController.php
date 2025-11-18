<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $clients = Client::with(['users', 'customFields'])->paginate(15);
        
        return ClientResource::collection($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request): ClientResource
    {
        $client = Client::create($request->validated());

        $client->load(['users', 'customFields']);

        return new ClientResource($client);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client): JsonResponse
    {
        $client->load(['users', 'customFields', 'invoices', 'products', 'domains', 'quotes', 'tickets']);

        $stats = $client->getStats();

        return response()->json([
            'result' => 'success',
            'client' => (new ClientResource($client))->resolve(),
            'stats' => $stats,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client): ClientResource
    {
        $client->update($request->validated());

        $client->load(['users', 'customFields']);

        return new ClientResource($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return response()->json([
            'result' => 'success',
            'message' => 'Client deleted successfully',
        ]);
    }
}
