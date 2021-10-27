@extends('layouts.app')

@section('content')
<div>
    <h1 class="page-header text-overflow">Add New</h1>
</div>
<div class="row">
	<div class="col-lg-8 col-lg-offset-2">
		<form class="form form-horizontal mar-top" action="{{route('product.store')}}" method="POST" enctype="multipart/form-data" id="choice_form"> 
			@csrf
			<input type="hidden" name="added_by" value="admin">
			<div class="panel">
				<div class="panel-heading bord-btm">
					<h3 class="panel-title">Product Information</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-lg-2 control-label">Product Name</label>
						<div class="col-lg-7">
							<input type="text" class="form-control" name="name" placeholder="Product Name" onchange="update_sku()" required>
						</div>
					</div>

				</div>
			</div>
			<div class="panel">
				<div class="panel-heading bord-btm">
					<h3 class="panel-title">Product Images</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-lg-2 control-label">Thumbnail Image <small>(290x300)</small></label>
						<div class="col-lg-7">
							<div id="thumbnail_img">

							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel">
				<div class="panel-heading bord-btm">
					<h3 class="panel-title">Product Variation</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<div class="col-lg-2">
							<input type="text" class="form-control" value="Colors" disabled>
						</div>
						<div class="col-lg-7">
							<input type="text" class="form-control color-var-select" name="colors[]" id="colors" multiple>
						</div>
						<div class="col-lg-2">
							<label class="switch" style="margin-top:5px;">
								<input value="1" type="checkbox" name="colors_active">
								<span class="slider round"></span>
							</label>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-2">
							<input type="text" class="form-control" value="Attributes" disabled>
						</div>
            <div class="col-lg-7">
              <select name="choice_attributes[]" id="choice_attributes" class="form-control demo-select2" multiple data-placeholder="Choose Attributes">
								@foreach (\App\Models\Variant::all() as $key => $attribute)
									<option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
								@endforeach
              </select>
            </div>
          </div>

					<div>
						<p>Choose the attributes of this product and then input values of each attribute</p>
						<br>
					</div>

					<div class="customer_choice_options" id="customer_choice_options">

					</div>

				</div>
			</div>
			<div class="panel">
				<div class="panel-heading bord-btm">
					<h3 class="panel-title">Product price + stock</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-lg-2 control-label">Unit price</label>
						<div class="col-lg-7">
							<input type="number" min="0" value="0" step="0.01" placeholder="Unit price" name="unit_price" class="form-control" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-lg-2 control-label">Purchase price</label>
						<div class="col-lg-7">
							<input type="number" min="0" value="0" step="0.01" placeholder="Purchase price" name="purchase_price" class="form-control" required>
						</div>
					</div>

					<div class="form-group" id="quantity">
						<label class="col-lg-2 control-label">Quantity</label>
						<div class="col-lg-7">
							<input type="number" min="0" value="0" step="1" placeholder="Quantity" name="current_stock" class="form-control" required>
						</div>
					</div>

					<br>
					<div class="sku_combination" id="sku_combination">

					</div>
				</div>
			</div>
			<div class="panel">
				<div class="panel-heading bord-btm">
					<h3 class="panel-title">Product Description</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-lg-2 control-label">Description</label>
						<div class="col-lg-9">
							<textarea class="editor" name="description"></textarea>
						</div>
					</div>
				</div>
			</div>

			<div class="mar-all text-right">
				<button type="submit" name="button" class="btn btn-info">Save</button>
			</div>

		</form>
	</div>
</div>


@endsection

@section('script')

<script type="text/javascript">
	function add_more_customer_choice_option(i, name){
		$('#customer_choice_options').append('<div class="form-group"><div class="col-lg-2"><input type="hidden" name="choice_no[]" value="'+i+'"><input type="text" class="form-control" name="choice[]" value="'+name+'" placeholder="Choice Title" readonly></div><div class="col-lg-7"><input type="text" class="form-control" name="choice_options_'+i+'[]" placeholder="Enter choice values" data-role="tagsinput" onchange="update_sku()"></div></div>');

		$("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
	}

	$('input[name="colors_active"]').on('change', function() {
	    if(!$('input[name="colors_active"]').is(':checked')){
			$('#colors').prop('disabled', true);
		}
		else{
			$('#colors').prop('disabled', false);
		}
		update_sku();
	});

	$('#colors').on('change', function() {
	    update_sku();
	});

	$('input[name="unit_price"]').on('keyup', function() {
	    update_sku();
	});

	$('input[name="name"]').on('keyup', function() {
	    update_sku();
	});

	function delete_row(em){
		$(em).closest('.form-group').remove();
		update_sku();
	}

	$(document).ready(function(){
	    // get_subcategories_by_category();
		$("#photos").spartanMultiImagePicker({
			fieldName:        'photos[]',
			maxCount:         10,
			rowHeight:        '200px',
			groupClassName:   'col-md-4 col-sm-4 col-xs-6',
			maxFileSize:      '',
			dropFileLabel : "Drop Here",
			onExtensionErr : function(index, file){
				console.log(index, file,  'extension err');
				alert('Please only input png or jpg type file')
			},
			onSizeErr : function(index, file){
				console.log(index, file,  'file size too big');
				alert('File size too big');
			}
		});
		$("#thumbnail_img").spartanMultiImagePicker({
			fieldName:        'thumbnail_img',
			maxCount:         1,
			rowHeight:        '200px',
			groupClassName:   'col-md-4 col-sm-4 col-xs-6',
			maxFileSize:      '',
			dropFileLabel : "Drop Here",
			onExtensionErr : function(index, file){
				console.log(index, file,  'extension err');
				alert('Please only input png or jpg type file')
			},
			onSizeErr : function(index, file){
				console.log(index, file,  'file size too big');
				alert('File size too big');
			}
		});
		$("#meta_photo").spartanMultiImagePicker({
			fieldName:        'meta_img',
			maxCount:         1,
			rowHeight:        '200px',
			groupClassName:   'col-md-4 col-sm-4 col-xs-6',
			maxFileSize:      '',
			dropFileLabel : "Drop Here",
			onExtensionErr : function(index, file){
				console.log(index, file,  'extension err');
				alert('Please only input png or jpg type file')
			},
			onSizeErr : function(index, file){
				console.log(index, file,  'file size too big');
				alert('File size too big');
			}
		});
	});

	// $('#category_id').on('change', function() {
	//     get_subcategories_by_category();
	// });

	// $('#subcategory_id').on('change', function() {
	//     get_subsubcategories_by_subcategory();
	// });

	// $('#subsubcategory_id').on('change', function() {
	//     // get_brands_by_subsubcategory();
	// 	//get_attributes_by_subsubcategory();
	// });

	$('#choice_attributes').on('change', function() {
		$('#customer_choice_options').html(null);
		$.each($("#choice_attributes option:selected"), function(){
			//console.log($(this).val());
            add_more_customer_choice_option($(this).val(), $(this).text());
        });
		update_sku();
	});


</script>

@endsection
