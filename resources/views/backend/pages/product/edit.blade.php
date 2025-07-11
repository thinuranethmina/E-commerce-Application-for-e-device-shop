@extends('backend.app')
@section('page', 'Products')
@section('content')
    <div class="row">
        @includeFirst(['backend.components.breadcrumb'])
    </div>
    <form class="ajaxForm" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data"
        method="POST">
        @csrf
        @method('PUT')

        @php
            $hasVariation = count($product->attributes()) >= 1 ? true : false;
        @endphp

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <h4 class="mb-3 header-title">Main Details</h4>
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="name">Product Name<span
                                            class="required">*</span></label>
                                    <small class="charcounter" data-for="name">(0/250)</small>
                                </div>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $product->name }}" data-counter="250">
                            </div>

                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="slug">Product Slug<span
                                            class="required">*</span></label>
                                    <small class="charcounter" data-for="slug">(0/250)</small>
                                </div>
                                <input type="text" name="slug" id="slug" class="form-control"
                                    value="{{ $product->slug }}" data-counter="250">
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const inputs = document.querySelectorAll('[data-counter]');

                                    inputs.forEach(input => {
                                        const maxLength = parseInt(input.getAttribute('data-counter'), 10);
                                        const charCounter = document.querySelector(`.charcounter[data-for="${input.id}"]`);

                                        input.addEventListener('input', function() {
                                            if (input.value.length > maxLength) {
                                                input.value = input.value.substring(0,
                                                    maxLength); // Truncate excess characters
                                            }
                                            const currentLength = input.value.length;
                                            charCounter.textContent = `(${currentLength}/${maxLength})`;
                                        });
                                    });
                                });
                            </script>

                            <div class="form-group">
                                <label class="form-label" for="description">Product Description<span
                                        class="required">*</span></label>
                                <textarea class="form-control" name="description" id="editor" rows="4"></textarea>
                            </div>

                            <script>
                                let productContent = '{!! $product->description !!}';
                            </script>

                            <div class="form-group">
                                <label class="form-label" for="warranty">Warranty Period</label>
                                <input type="text" name="warranty_period" id="warranty_period"
                                    class="form-control"value="{{ $product->warranty_period }}">
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="warranty">Warranty Info</label>
                                <textarea name="warranty_info" class="form-control" rows="3">{{ $product->warranty_info }}</textarea>
                            </div>

                            <div class="row {{ $hasVariation ? 'd-none' : '' }}" id="productBaseDetails">
                                <div class="form-group">
                                    <label class="form-label" for="price">Price<span class="required">*</span></label>
                                    <input type="number" name="price" id="price"
                                        value="{{ !$hasVariation ? $product->variations[0]->price : '' }}"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="stock">Stock<span
                                                class="required">*</span></label>
                                    </div>
                                    <input type="text" name="stock" id="" class="form-control"
                                        value="{{ !$hasVariation ? $product->variations[0]->stock : '' }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="status">Status<span class="required">*</span></label>
                                <select class="form-control" name="status" id="status">
                                    <option value="Active" {{ $product->status == 'Active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="Inactive" {{ $product->status == 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="has_variations" id="has_variations" value="1"
                                    class="form-check-input" {{ $hasVariation ? 'checked' : '' }}>
                                <label for="has_variations">
                                    Has Variations
                                </label>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card {{ $hasVariation ? '' : 'd-none' }}" id="productVariationCard">
                    <div class="card-body">
                        <div class="col-lg-12" id="productVariationContainer">
                            <div class="d-flex justify-content-between">
                                <h4 class="mb-3 header-title">Product Variations</h4>
                                <button type="button" class="btn btn-primary" onclick="addProductVariation(this);">Add
                                    Variation</button>
                            </div>

                            @foreach ($product->variations as $key => $variation)
                                <div class="row">
                                    @if (!$loop->first)
                                        <div class="col-12">
                                            <hr>
                                            <button class="btn btn-danger float-end" type="button"
                                                onclick="removeVariationValue(this);"><span
                                                    class="fi fi-rr-cross-circle d-flex"></span></button>
                                        </div>
                                    @endif
                                    <div class="col-12">

                                        <div class="form-group">
                                            <label class="form-label" for="">Price<span
                                                    class="required">*</span></label>
                                            <input type="number" name="product_variation[{{ $variation->id }}][price]"
                                                id="product_base_price" class="form-control"
                                                value="{{ $variation->price }}">
                                        </div>

                                        <div class="form-group">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="">Stock<span
                                                        class="required">*</span></label>
                                            </div>
                                            <input type="number" name="product_variation[{{ $variation->id }}][stock]"
                                                id="" class="form-control" value="{{ $variation->stock }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-12 variationContainer">

                                                @forelse ($variation->values as $value)
                                                    <div class="row mb-2">
                                                        <div class="col pe-0">
                                                            <select
                                                                name="product_variation[{{ $variation->id }}][variationName][{{ $value->id }}]"
                                                                onchange="getVariationValue(this)"
                                                                class="form-select variationName">
                                                                @foreach ($variations as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ $value->variationValue->variations_id == $item->id ? 'selected' : '' }}>
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col pe-0">
                                                            <select
                                                                name="product_variation[{{ $variation->id }}][variationValue][{{ $value->id }}]"
                                                                class="form-select variationValue">
                                                                @foreach ($value->variationValue->allValues() as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        {{ $value->variation_value_id == $item->id ? 'selected' : '' }}>
                                                                        {{ $item->variable }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        @if ($loop->first)
                                                            <div class="col-auto">
                                                                <button type="button" class="btn btn-primary h-100"
                                                                    onclick="addVariationAttribute(this,{{ $variation->id }})">
                                                                    <span class="fi fi-rr-add d-flex"></span>
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="col-auto">
                                                                <button type="button" class="btn btn-dark h-100"
                                                                    onclick="removeVariationValue(this)">
                                                                    <span class="fi fi-rr-minus-circle d-flex"></span>
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @empty
                                                    <div class="row mb-2">
                                                        <div class="col pe-0">
                                                            <select
                                                                name="product_variation[{{ $variation->id }}][variationName][0]"
                                                                onchange="getVariationValue(this)"
                                                                class="form-select variationName">
                                                                <option value="">Select Variation</option>
                                                                @foreach ($variations as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col pe-0">
                                                            <select
                                                                name="product_variation[{{ $variation->id }}][variationValue][0]"
                                                                class="form-select variationValue">
                                                            </select>
                                                        </div>
                                                        <div class="col-auto">
                                                            <button type="button" class="btn btn-primary h-100"
                                                                onclick="addVariationAttribute(this,{{ $variation->id }})">
                                                                <span class="fi fi-rr-add d-flex"></span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endforelse


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="col-12" id="productVariationContainer">
                            <h4 class="mb-3 header-title">Gallery</h4>
                        </div>
                        <div class="col-12">
                            <div class="fileChooser rounded-border" ondragover="handleDragOver(event)"
                                ondragleave="handleDragLeave()" ondrop="handleDrop(event)">
                                <label id="fileChooserAlbumImages" for="albumImages">
                                    Drag & Drop your file or
                                    <span><u>Browse</u></span>
                                </label>
                                <div class="selectedImages" id="selectedAlbumImages"></div>
                                <input type="file" id="albumImages" name="gallery[]"
                                    onchange="previewImageChooser('albumImages', 'fileChooserAlbumImages');"
                                    accept="image/*" multiple />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <h4 class="mb-3 header-title">Thumbnail</h4>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            @php
                                $data = [
                                    'width' => '100%',
                                    'height' => '300px',
                                    'maxHeight' => '400px',
                                    'name' => 'thumbnail',
                                    'cover' => false,
                                    'type' => 'box',
                                    'bgColor' => 'white',
                                    'src' => '../../../' . $product->thumbnail,
                                ];
                            @endphp
                            @include('backend.components.image-chooser', $data)

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="mb-3 header-title">Publish</h4>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary w-100" value="save">
                                    <i class="fi fi-rr-disk"></i>
                                    Save
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary w-100" value="save_exit">
                                    <i class="fi fi-rr-exit"></i>
                                    Save and Exit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <h4 class="mb-3 header-title">Is Featured?</h4>
                            <div class="form-group">
                                <select class="form-control" name="is_featured" id="is_featured">
                                    <option value="0" {{ $product->is_featured == '0' ? 'selected' : '' }}>No
                                    </option>
                                    <option value="1" {{ $product->is_featured == '1' ? 'selected' : '' }}>Yes
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <h4 class="mb-3 header-title">Categories</h4>
                            @include('backend.components.categoryNavigation')
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">
                            <h4 class="mb-3 header-title">Brand</h4>
                            <div class="form-group">
                                <label class="form-label" for="brand_id">Product Brand<span
                                        class="required">*</span></label>
                                <select class="form-control" name="brand_id" id="brand_id">
                                    <option value="">No Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ $brand->id == $product->brand_id ? 'selected' : '' }}>{{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

    <script>
        document.getElementById('has_variations').addEventListener('change', function() {
            document.getElementById('productVariationCard').classList.toggle('d-none');
            document.getElementById('productBaseDetails').classList.toggle('d-none');
        })

        document.addEventListener("DOMContentLoaded", function() {

            @foreach ($product->galleries as $item)
                previewImageChooser('albumImages', 'fileChooserAlbumImages', '{{ $item->image }}',
                    'uploaded',
                    'edit', '../../../', {{ $loop->index }});
            @endforeach

            const categories = document.querySelectorAll(".category");
            const subcategories = document.querySelectorAll(".subcategory");

            subcategories.forEach((subcategory) => {
                subcategory.addEventListener("change", function() {
                    const parentCategoryId = subcategory.dataset.category;
                    const parentCategory = document.getElementById(parentCategoryId);

                    if (subcategory.checked) {
                        // Uncheck all categories and subcategories first
                        categories.forEach((cat) => (cat.checked = false));
                        subcategories.forEach((sub) => (sub.checked = false));

                        // Check the current subcategory and its parent category
                        subcategory.checked = true;
                        parentCategory.checked = true;
                    } else {
                        // If subcategory is unchecked, check if other subcategories under the same category are still checked
                        const siblingSubcategories = document.querySelectorAll(
                            `.subcategory[data-category="${parentCategoryId}"]`
                        );

                        const anySiblingChecked = Array.from(siblingSubcategories).some(
                            (sub) => sub.checked
                        );

                        // If no sibling subcategories are checked, uncheck the parent category
                        if (!anySiblingChecked) {
                            parentCategory.checked = false;
                        }
                    }
                });
            });

            categories.forEach((category) => {
                category.addEventListener("change", function() {
                    const relatedSubcategories = document.querySelectorAll(
                        `.subcategory[data-category="${category.id}"]`
                    );

                    if (category.checked) {
                        // Uncheck all other categories and subcategories
                        categories.forEach((cat) => {
                            if (cat !== category) cat.checked = false;
                        });
                        subcategories.forEach((sub) => (sub.checked = false));
                    } else {
                        // If the category is unchecked, uncheck all related subcategories
                        relatedSubcategories.forEach((sub) => (sub.checked = false));
                    }
                });
            });
        });
    </script>
@endsection
