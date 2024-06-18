<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $this->processPicture($request, $data);

        $this->productRepository->create($data);

        return response()->json(['message' => 'Product created successfully.'], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $this->processPicture($request, $data);

        $this->productRepository->update($id, $data);

        return response()->json(['message' => 'Product updated successfully.'], Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $product = $this->productRepository->getById($id);
        $this->deletePicture($product);

        $this->productRepository->delete($id);

        return response()->json(['message' => 'Product deleted successfully.'], Response::HTTP_OK);
    }

    private function processPicture(Request $request, &$data)
    {
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('pictures', 'public');
            $data['picture'] = $path;
        }
    }

    private function deletePicture($product)
    {
        if ($product->picture) {
            Storage::disk('public')->delete($product->picture);
        }
    }
}

