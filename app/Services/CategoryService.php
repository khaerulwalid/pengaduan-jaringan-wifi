<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Validator;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories($perPage = 10)
    {
        return $this->categoryRepository->paginateCategories($perPage);
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function createCategory(array $data)
    {
        return ['category' => $this->categoryRepository->create($data)];
    }

    public function updateCategory($id, array $data)
    {

        // Validasi jika nama kategori yang diinput sudah digunakan oleh kategori lain
        if ($this->categoryRepository->existsByNameExcept($data['name'], $id)) {
            return ['error' => 'The category name has already been taken.'];
        }

        $category = $this->categoryRepository->findById($id);

        if (!$category) {
            return ['error' => 'Category not found.'];
        }

        

        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }
}
