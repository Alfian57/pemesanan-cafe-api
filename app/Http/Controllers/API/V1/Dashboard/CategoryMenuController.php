<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class CategoryMenuController extends Controller
{
    /**
     * Summary of addCategoryToMenu
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCategoryToMenu(Request $request, Menu $menu, Category $category)
    {
        $menu->categories()->attach($category->id);

        return response()->json(['message' => 'Category added to menu']);
    }

    /**
     * Summary of removeCategoryFromMenu
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeCategoryFromMenu(Menu $menu, Category $category)
    {
        $menu->categories()->detach($category->id);

        return response()->json(['message' => 'Category removed from menu']);
    }
}
