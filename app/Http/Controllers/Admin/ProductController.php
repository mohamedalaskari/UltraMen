<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('sort_order')->orderBy('name_en')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name_en')->get(['slug', 'name_en', 'name_ar']);
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en'           => 'required|string|max:255',
            'name_ar'           => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:products,slug',
            'category'          => 'required|string|max:255|exists:categories,slug',
            'subtitle_en'       => 'nullable|string|max:255',
            'subtitle_ar'       => 'nullable|string|max:255',
            'price'             => 'required|numeric|min:0',
            'original_price'    => 'nullable|numeric|gt:price',
            'badge'             => 'nullable|string|max:50',
            'description_en'    => 'required|string',
            'description_ar'    => 'required|string',
            'sort_order'        => 'nullable|integer|min:0',
            'image'             => 'required|image|max:4096',
            'gallery_images.*'  => 'nullable|image|max:4096',
            'labels'            => 'nullable|array',
            'sizes_data'        => 'nullable|string',
            'finishes_data'     => 'nullable|string',
            'trust_data'        => 'nullable|string',
            'accordions_data'   => 'nullable|string',
        ], [
            'original_price.gt' => 'Original price must be higher than the regular price.',
        ]);

        $data['image'] = $request->file('image')->store('products', 'public');

        $galleryPaths = array_slice($this->storeGalleryFiles($request), 0, 6);

        $data['gallery']         = array_map(fn($path) => ['image' => $path], $galleryPaths);
        $data['secondary_image'] = $galleryPaths[0] ?? null;
        $data['labels']          = $request->input('labels', []);
        $data['sizes']           = $this->parseJson($request->input('sizes_data'), []);
        $data['finishes']        = $this->parseJson($request->input('finishes_data'), []);
        $data['trust']           = $this->parseJson($request->input('trust_data'), []);
        $data['accordions']      = $this->parseJson($request->input('accordions_data'), []);
        $data['sort_order']      = $request->input('sort_order', 0);

        unset($data['gallery_images'], $data['sizes_data'], $data['finishes_data'], $data['trust_data'], $data['accordions_data']);

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$data['name_en']}\" created successfully.");
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name_en')->get(['slug', 'name_en', 'name_ar']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name_en'           => 'required|string|max:255',
            'name_ar'           => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:products,slug,' . $product->id,
            'category'          => 'required|string|max:255|exists:categories,slug',
            'subtitle_en'       => 'nullable|string|max:255',
            'subtitle_ar'       => 'nullable|string|max:255',
            'price'             => 'required|numeric|min:0',
            'original_price'    => 'nullable|numeric|gt:price',
            'badge'             => 'nullable|string|max:50',
            'description_en'    => 'required|string',
            'description_ar'    => 'required|string',
            'sort_order'        => 'nullable|integer|min:0',
            'image'             => 'nullable|image|max:4096',
            'gallery_images.*'  => 'nullable|image|max:4096',
            'kept_gallery'      => 'nullable|array',
            'labels'            => 'nullable|array',
            'sizes_data'        => 'nullable|string',
            'finishes_data'     => 'nullable|string',
            'trust_data'        => 'nullable|string',
            'accordions_data'   => 'nullable|string',
        ], [
            'original_price.gt' => 'Original price must be higher than the regular price.',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        } else {
            unset($data['image']);
        }

        $keptGallery          = $request->input('kept_gallery', []);
        $currentGalleryPaths  = collect($product->gallery ?? [])->pluck('image')->filter()->all();
        $removedGalleryPaths  = array_diff($currentGalleryPaths, $keptGallery);
        foreach ($removedGalleryPaths as $removedPath) {
            Storage::disk('public')->delete($removedPath);
        }

        $newGalleryPaths = $this->storeGalleryFiles($request);
        $finalGallery    = array_slice(array_merge($keptGallery, $newGalleryPaths), 0, 6);

        $data['gallery']         = array_map(fn($path) => ['image' => $path], $finalGallery);
        $data['secondary_image'] = $finalGallery[0] ?? null;
        $data['labels']          = $request->input('labels', []);
        $data['sizes']           = $this->parseJson($request->input('sizes_data'), []);
        $data['finishes']        = $this->parseJson($request->input('finishes_data'), []);
        $data['trust']           = $this->parseJson($request->input('trust_data'), []);
        $data['accordions']      = $this->parseJson($request->input('accordions_data'), []);

        unset($data['gallery_images'], $data['kept_gallery'], $data['sizes_data'], $data['finishes_data'], $data['trust_data'], $data['accordions_data']);

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$data['name_en']}\" updated successfully.");
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        foreach ($product->gallery ?? [] as $item) {
            if (!empty($item['image'])) {
                Storage::disk('public')->delete($item['image']);
            }
        }

        $name = $product->name_en;
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$name}\" deleted.");
    }

    private function storeGalleryFiles(Request $request): array
    {
        $paths = [];
        foreach ($request->file('gallery_images', []) as $file) {
            if ($file) {
                $paths[] = $file->store('products', 'public');
            }
        }
        return $paths;
    }

    private function parseJson(?string $json, mixed $default): mixed
    {
        if (!$json || trim($json) === '') return $default;
        $decoded = json_decode($json, true);
        return json_last_error() === JSON_ERROR_NONE ? $decoded : $default;
    }
}
