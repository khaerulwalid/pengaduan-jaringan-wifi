<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getAll()
    {
        return Category::all();
    }

    public function paginateCategories($perPage = 10)
    {
        return Category::paginate($perPage);
    }

    public function findById($id)
    {
        return Category::find($id);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($id, array $data)
    {
        $category = $this->findById($id);

        if ($category) {
            $category->update($data);
            return $category;
        }

        return null;
    }

    public function existsByNameExcept($name, $id)
    {
        return Category::where('name', $name)
            ->where('id', '!=', $id)
            ->exists();
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        return $category->delete();
    }
}
