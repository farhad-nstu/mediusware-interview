<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);
        $variants = Variant::all();
        $fromPrice = '';
        $toPrice = '';
        $filterVariant = '';
        $title = '';

        // $products = DB::table('products')
        //             ->join('product_variant_prices', 'product_variant_prices.product_id', '=', 'products.id')
        //             ->leftjoin('product_variants as variant1', 'product_variant_prices.product_variant_one', '=', 'variant1.id')
        //             ->leftjoin('product_variants as variant2', 'product_variant_prices.product_variant_two', '=', 'variant2.id')
        //             ->leftjoin('product_variants as variant3', 'product_variant_prices.product_variant_three', '=', 'variant3.id')
        //             ->select('products.*', 'product_variant_prices.*', 'variant1.variant as v1', 'variant2.variant as v2', 'variant3.variant as v3')
        //                           // ->where(['product_variant_prices.product_id' => $product->id])
        //             ->groupBy('products.title')
        //             ->get();

        return view('products.index', compact('products', 'variants', 'fromPrice', 'toPrice', 'filterVariant', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function filter_product(Request $request)
    {
        // dd($request->all());
        $date = date('Y-m-d', strtotime($request->date));
        $fromPrice = $request->price_from;
        $toPrice = $request->price_to;
        $filterVariant = $request->variant;
        $title = $request->title;
        // dd($date);
        $products = Product::orderBy('id', 'desc')->where('created_at', '<=', $date)->where('title', 'like', "%".$request->title."%")->paginate(10);
        $variants = Variant::all();

        // $products = db::table('products')
        //                         ->union('product_variant_prices')
        //                           ->leftjoin('product_variants as variant1', 'product_variant_prices.product_variant_one', '=', 'variant1.id')
        //                           ->leftjoin('product_variants as variant2', 'product_variant_prices.product_variant_two', '=', 'variant2.id')
        //                           ->leftjoin('product_variants as variant3', 'product_variant_prices.product_variant_three', '=', 'variant3.id')
        //                           ->select('products.*', 'product_variant_prices.*', 'variant1.variant as v1', 'variant2.variant as v2', 'variant3.variant as v3')
        //                           // ->where(['product_variant_prices.product_id' => $product->id])
        //                           ->groupBy('products.title')
        //                           ->get();

        // $products = DB::table('products')
        //         // ->leftJoin('country', 'resort.country', '=', 'country.id')
        //         // ->leftJoin('states', 'resort.state', '=', 'states.id')
        //         // ->leftJoin('city', 'resort.city', '=', 'city.id')
        //         // ->join('product_variant_prices', 'product_variant_prices.product_id', '=', 'products.id')
        //         ->select('products.*', DB::raw("(SELECT 'product_variant_prices.*', 'variant1.variant as v1', 'variant2.variant as v2', 'variant3.variant as v3' from product_variant_prices LEFT JOIN product_variants as variant1 on variant1.id=product_variant_prices.product_variant_one LEFT JOIN product_variants as variant2 on variant2.id=product_variant_prices.product_variant_two LEFT JOIN product_variants as variant3 on variant3.id=product_variant_prices.product_variant_three WHERE product_variant_prices.product_id=products.id)"))->groupBy('products.id')
        //        ->get();

        // dd($products);

        return view('products.index', compact('products', 'variants', 'fromPrice', 'toPrice', 'filterVariant', 'title'));
    }
}
