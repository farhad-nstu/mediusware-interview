@php 
  use DB as db;
@endphp 

@extends('layouts.app')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Products</h1>
</div>


<div class="card">
  <form action="" method="get" class="card-header">
    <div class="form-row justify-content-between">
      <div class="col-md-2">
        <input type="text" name="title" placeholder="Product Title" class="form-control">
      </div>
      <div class="col-md-2">
        <select name="variant" id="" class="form-control">
          @foreach()
        </select>
      </div>

      <div class="col-md-3">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">Price Range</span>
          </div>
          <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control">
          <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
        </div>
      </div>
      <div class="col-md-2">
        <input type="date" name="date" placeholder="Date" class="form-control">
      </div>
      <div class="col-md-1">
        <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
      </div>
    </div>
  </form>

  <div class="card-body">
    <div class="table-response">
      <table class="table">
        <thead>
          <tr>
            <th width="3%">#</th>
            <th width="12%">Title</th>
            <th width="40%">Description</th>
            <th width="41%">Variant</th>
            <th width="10%">Action</th>
          </tr>
        </thead>

        <tbody>
          @foreach($products as $product)
            <tr>

              <td width="3%">{{ $loop->index+1 }}</td>
              <td width="12%">{{ $product->title }} <br> Created at : {{ date('F j, Y', strtotime($product->created_at)) }}</td>
              <td width="40%">{!! substr($product->description, 0, 200) !!}</td>
              <td width="41%">

                @php 
                  
                  $variantPrices = db::table('product_variant_prices')
                                  ->leftjoin('product_variants as variant1', 'product_variant_prices.product_variant_one', '=', 'variant1.id')
                                  ->leftjoin('product_variants as variant2', 'product_variant_prices.product_variant_two', '=', 'variant2.id')
                                  ->leftjoin('product_variants as variant3', 'product_variant_prices.product_variant_three', '=', 'variant3.id')
                                  ->select('product_variant_prices.*', 'variant1.variant as v1', 'variant2.variant as v2', 'variant3.variant as v3')
                                  ->where(['product_variant_prices.product_id' => $product->id])
                                  ->get();

                @endphp 

                @foreach($variantPrices as $variantPrice)
                  <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                  <dt class="col-sm-3 pb-0">
                    {{ $variantPrice->v1 }}/ {{ $variantPrice->v2 }}/ {{ $variantPrice->v3 }}
                  </dt>
                  <dd class="col-sm-9">
                    <dl class="row mb-0">
                      <dt class="col-sm-4 pb-0">Price : {{ number_format($variantPrice->price, 2) }}</dt>
                      <dd class="col-sm-8 pb-0">InStock : {{ number_format($variantPrice->stock, 2) }}</dd>
                    </dl>
                  </dd>
                  </dl>
                @endforeach

                <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
              </td>
              <td width="4%">
                <div class="btn-group btn-group-sm">
                  <a href="{{ route('product.edit', 1) }}" class="btn btn-success">Edit</a>
                </div>
              </td>
            </tr>
          @endforeach 

        </tbody>

      </table>
      {{ $porducts->links() }}
    </div>

  </div>

  <div class="card-footer">
    <div class="row justify-content-between">
      <div class="col-md-6">
        <p>Showing 1 to 10 out of 100</p>
      </div>
      <div class="col-md-2">

      </div>
    </div>
  </div>
</div>

@endsection
