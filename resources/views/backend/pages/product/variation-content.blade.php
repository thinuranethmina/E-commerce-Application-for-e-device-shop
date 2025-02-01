<div class="row">
    <div class="col-12">
        <hr>
        <button class="btn btn-danger float-end" type="button" onclick="removeVariationValue(this);"><span
                class="fi fi-rr-cross-circle d-flex"></span></button>
    </div>
    <div class="col-12">

        <div class="form-group">
            <label class="form-label" for="product_base_price">Price<span class="required">*</span></label>
            <input type="text" name="product_variation[{{ $index }}][price]" id="product_base_price"
                class="form-control">
        </div>

        <div class="form-group">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="product_name">Stock<span class="required">*</span></label>
            </div>
            <input type="text" name="product_variation[{{ $index }}][stock]" id=""
                class="form-control">
        </div>

        <div class="row">
            <div class="col-12 variationContainer">

                <div class="row mb-2">
                    <div class="col pe-0">
                        <select name="product_variation[{{ $index }}][variationName][0]"
                            onchange="getVariationValue(this)" class="form-select variationName">
                            <option value="">Select Variation
                            </option>
                            @foreach ($variations as $variation)
                                <option value="{{ $variation->id }}">{{ $variation->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col pe-0">
                        <select name="product_variation[{{ $index }}][variationValue][0]"
                            class="form-select variationValue">
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-primary h-100"
                            onclick="addVariationAttribute(this,{{ $index }})">
                            <span class="fi fi-rr-add d-flex"></span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
