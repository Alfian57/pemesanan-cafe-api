<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreCategoryRequest;
use App\Http\Requests\API\V1\UpdateCategoryRequest;
use App\Http\Resources\API\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'filter[name]' => ['nullable', 'string'],
            'sort' => ['nullable', 'string', 'in:name,-name'],
            'page[number]' => ['nullable', 'integer', 'min:1'],
            'page[size]' => ['nullable', 'integer', 'min:1'],
        ]);

        $categories = QueryBuilder::for(Category::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['name'])
            ->jsonPaginate();

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return CategoryResource::make($category)
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('menus');

        return CategoryResource::make($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return CategoryResource::make($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
        ]);
    }
}
