<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getAll();
        return view('categories.index', compact('categories'));
    }

    public function show($id)
    {
        $category = $this->categoryRepository->getById($id);
        return view('categories.show', compact('category'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'description']);
        $category = $this->categoryRepository->create($data);
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $category = $this->categoryRepository->getById($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'description']);
        $category = $this->categoryRepository->update($id, $data);
        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        $this->categoryRepository->delete($id);
        return redirect()->route('categories.index');
    }
}

