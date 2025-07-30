<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\MasterData\CategoryRequest;
use App\Models\MasterData\Category;
use App\Models\User;
use App\Services\MasterData\CategoryService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{

    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Factory|View
    {
        $categories = Category::orderByDesc('id')->get();
        return view('backEnd.masterData.category.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request): RedirectResponse
    {
        return $this->categoryService->save($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
         if(!$category){
            return response()->json([
                'status'  => false,
                'message' => 'Data Not Found',
            ], JsonResponse::HTTP_OK);
        }

        $rekomendasi = $category->recomendation;
       
        return response()->json([
            'status'  => true,
            'message' => 'Data Berhasil',
            'data'  => ['category' => $category, 'rekomendasi' => $rekomendasi],
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category): RedirectResponse
    {
         return $this->categoryService->save($request, $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category): JsonResponse
    {
         $response = $this->categoryService->delete($category);

        if(!$response){
             return response()->json([
                'status'  => false,
                'message' => 'Failed Delete',
            ], JsonResponse::HTTP_OK);
        }

           return response()->json([
                'status'  => true,
                'message' => 'Success Delete',
            ], JsonResponse::HTTP_OK);
    }
}
