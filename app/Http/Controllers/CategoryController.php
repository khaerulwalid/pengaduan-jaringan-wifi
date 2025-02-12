<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\CreateCategoryRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;

        $this->middleware(function ($request, $next) {
            if (auth()->user()->role === 'customer') {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    // Menampilkan daftar kategori
    public function index()
    {
        $categories = $this->categoryService->getAllCategories(10);
        return view('categories.index', compact('categories'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('tickets.create', compact('categories'));
    }

    // Menyimpan kategori baru
    public function store(CreateCategoryRequest $request)
    {
        $result = $this->categoryService->createCategory($request->all());

        if (isset($result['error'])) {
            return redirect()->back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    // Menampilkan form edit kategori
    public function edit($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }

        return view('categories.edit', compact('category'));
    }

    // Update kategori
    public function update(UpdateCategoryRequest $request, $id)
    {
        $result = $this->categoryService->updateCategory($id, $request->validated());

        if (isset($result['error'])) {
            return redirect()->back()->withErrors($result['error'])->withInput();
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    // Hapus kategori
    public function destroy($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        if (!$category) {
            return redirect()->route('categories.index')->with('error', 'Category not found.');
        }
    
        try {
            $this->categoryService->deleteCategory($id);
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('categories.index')->with('error', 'Failed to delete category. It may be in use.');
        }
    }
}
