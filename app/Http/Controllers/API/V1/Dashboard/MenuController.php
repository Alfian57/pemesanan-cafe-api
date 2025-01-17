<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreMenuRequest;
use App\Http\Requests\API\V1\UpdateMenuRequest;
use App\Http\Resources\API\V1\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'filter[name]' => ['nullable', 'string'],
            'filter[status]' => ['nullable', 'string', 'in:available,unavailable'],
            'sort' => ['nullable', 'string', 'in:name,-name,price,-price'],
            'page[number]' => ['nullable', 'integer', 'min:1'],
            'page[size]' => ['nullable', 'integer', 'min:1'],
        ]);

        $menus = QueryBuilder::for(Menu::class)
            ->allowedFilters(['name', 'status'])
            ->allowedSorts(['name', 'price'])
            ->jsonPaginate();

        return MenuResource::collection($menus);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['image'] = $request->file('image')->store('menus', 'public');
        $menu = Menu::create($validatedData);

        return MenuResource::make($menu)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $menu->load('categories');

        return MenuResource::make($menu);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($menu->image);
            $validatedData['image'] = $request->file('image')->store('menus', 'public');
        }
        $menu->update($validatedData);

        return MenuResource::make($menu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        Storage::disk('public')->delete($menu->image);
        $menu->delete();

        return response()->json([
            'message' => 'Menu deleted successfully',
        ]);
    }
}
