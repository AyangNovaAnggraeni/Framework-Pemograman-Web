<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $data = Product::all();
        // Membuat query builder baru untuk model Product
        $query = Product::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%')
                    ->orWhere('information', 'like', '%' . $search . '%')
                    ->orWhere('producer', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan Unit
        if ($request->filled('filter_unit')) {
            $query->where('unit', $request->filter_unit);
        }

        // Filter berdasarkan Type
        if ($request->filled('filter_type')) {
            $query->where('type', $request->filter_type);
        }

        // Filter berdasarkan Producer
        if ($request->filled('filter_producer')) {
            $query->where('producer', $request->filter_producer);
        }

        // Sorting
        $sort = $request->get('sort', 'id'); // default: urutkan berdasarkan nama produk
        $direction = $request->get('direction', 'asc'); // default: ascending

        // daftar kolom yang boleh disort biar aman
        $allowedSorts = ['id', 'unit', 'type', 'information', 'qty', 'producer', 'product_name'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'product_name';
        }

        $query->orderBy($sort, $direction);

        // Urutkan hasil berdasarkan nama produk (A–Z)
        // $query->orderBy('product_name', 'asc');

        // Pagination
        $data = $query->paginate(10)->appends([
            'search' => $request->search,
            'filter_type' => $request->filter_type,
            'filter_producer' => $request->filter_producer,
            'filter_unit' => $request->filter_unit,
            'sort' => $sort,
            'direction' => $direction
        ]);

        // Ambil data unik untuk dropdown
        $units = Product::select('unit')->distinct()->pluck('unit');
        $types = Product::select('type')->distinct()->pluck('type');
        $producers = Product::select('producer')->distinct()->pluck('producer');

        $data = $query->paginate(5)->appends(['search' => $request->search]);

        // return view('master-data.product-master.index-product', compact('data'));
        return view('master-data.product-master.index-product', compact('data', 'types', 'units', 'producers'));

        // return view('layouts-percobaan.app');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master-data.product-master.create-product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi input
        $validasi_data = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'information' => 'nullable|string',
            'qty' => 'required|integer',
            'producer' => 'required|string|max:255',
        ]);

        // simpan data ke database
        Product::create($validasi_data);

        // redirect atau tampilkan pesan sukses
        return redirect()->back()->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        return view(view: 'master-data.product-master.detail-product', data: compact(var_name: 'product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $product = Product::findOrFail($id);
        return view('master-data.product-master.edit-product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validasi_data = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:50',
            'type' => 'required|string|max:50',
            'information' => 'nullable|string',
            'qty' => 'required|integer',
            'producer' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'product_name' => $request->product_name,
            'unit' => $request->unit,
            'type' => $request->type,
            'information' => $request->information,
            'qty' => $request->qty,
            'producer' => $request->producer,
        ]);

        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }
}
