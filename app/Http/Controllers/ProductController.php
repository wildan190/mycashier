<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->getAll();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $this->processPicture($request, $data);

        $this->productRepository->create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = $this->productRepository->getById($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate($this->rules());
        $this->processPicture($request, $data);

        $this->productRepository->update($id, $data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = $this->productRepository->getById($id);
        $this->deletePicture($product);

        $this->productRepository->delete($id);
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    private function rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'product_stock' => 'required|integer|min:0',
            'status' => 'required|in:available,not_available',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    private function processPicture(Request $request, &$data)
    {
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('pictures', 'public');
            $data['picture'] = $path;
        }
    }

    private function deletePicture(Product $product)
    {
        if ($product->picture) {
            Storage::disk('public')->delete($product->picture);
        }
    }
}

