<?php

namespace App\Services\MasterData;

use App\Http\Requests\MasterData\CategoryRequest;
use App\Models\MasterData\Category;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    public function save(CategoryRequest $request, ?Category $category = null): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            $categoryData = $request->except('rekomendasi');
            $rekomendasiList = $data['rekomendasi'];

            if ($category) {
                $category->update($categoryData);
                $category->recomendation()->delete();
            } else {
                $category = Category::create($categoryData);
            }

            foreach ($rekomendasiList as $rekomendasiName) {
                $category->recomendation()->create([
                    'name' => $rekomendasiName,
                    'created_by' => Auth::id(),
                ]);
            }
           
            DB::commit();
            Log::channel('log-transaction')->info(($category->wasRecentlyCreated ? 'Jenis Pelanggaran Created!' : 'Jenis Pelanggaran Updated!'), ['User' =>  Auth::user()->name]);
            return redirect()->route('category.index')->with('success', 'Data berhasil ' . ($category->wasRecentlyCreated ? 'ditambahkan!' : 'diubah!')); 
        
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(Category $category): bool
    {
        DB::beginTransaction();
        try {
            $category->update(['deleted_at' => now(), 'deleted_by' => Auth::id()]);
            DB::commit();
            Log::channel('log-transaction')->info('Jenis Pelanggaran Delete Success!', ['User' =>  Auth::user()->name]);
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::channel('log-transaction')->info($e->getMessage(), ['User' =>  Auth::user()->name]);
            return false;
        }
    }
}
