<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreTableRequest;
use App\Http\Requests\API\V1\UpdateMenuRequest;
use App\Http\Resources\API\V1\TableResource;
use App\Models\Table;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @unauthenticated
     */
    public function index(Request $request)
    {
        $request->validate([
            'filter[name]' => ['nullable', 'string'],
            'sort' => ['nullable', 'string', 'in:name,-name,capacity,-capacity'],
            'page[number]' => ['nullable', 'integer', 'min:1'],
            'page[size]' => ['nullable', 'integer', 'min:1'],
        ]);

        $tables = QueryBuilder::for(Table::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['name', 'capacity'])
            ->jsonPaginate();

        return TableResource::collection($tables);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTableRequest $request)
    {
        $table = Table::create($request->validated());

        return TableResource::make($table)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Table $table)
    {
        $table->update($request->validated());

        return TableResource::make($table);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return response()->json([
            'message' => 'Table deleted successfully',
        ]);
    }
}
