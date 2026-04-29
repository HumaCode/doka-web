<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\CategoryResource;
use App\Services\Master\Kategori\CategoryServiceInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.kategori.index');
    }

    /**
     * Get all categories with pagination for AJAX.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllPagination(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'status' => $request->status,
        ];

        $data = $this->categoryService->getCategories($request->per_page ?? 10, $filters);

        return $this->success(null, $data);
    }

    /**
     * Store a newly created category via AJAX.
     *
     * @param \App\Http\Requests\Master\Kategori\StoreKategoriRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(\App\Http\Requests\Master\Kategori\StoreKategoriRequest $request)
    {
        try {
            $this->categoryService->createCategory($request->validated());
            return $this->success('Kategori baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return $this->error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified category.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return $this->success(null, CategoryResource::make($category));
    }

    /**
     * Update the specified category via AJAX.
     *
     * @param \App\Http\Requests\Master\Kategori\UpdateKategoriRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(\App\Http\Requests\Master\Kategori\UpdateKategoriRequest $request, string $id)
    {
        try {
            $this->categoryService->updateCategory($id, $request->validated());
            return $this->success('Data kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return $this->error('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status of the specified category.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(string $id)
    {
        try {
            $category = $this->categoryService->toggleCategoryStatus($id);
            $statusText = $category->status === 'active' ? 'Aktif' : 'Nonaktif';
            
            return $this->success("Status kategori berhasil diubah menjadi {$statusText}.");
        } catch (\Exception $e) {
            return $this->error('Gagal mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(string $id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return $this->success('Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}
