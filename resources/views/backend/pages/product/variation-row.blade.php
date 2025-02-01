<div class="row mb-2">
    <div class="col pe-0">
        <select name="product_variation[{{ $index }}][variationName][{{ $index2 }}]"
            onchange="getVariationValue(this)" class="form-select variationName">
            <option value="">Select Variation
            </option>
            @foreach ($variations as $variation)
                <option value="{{ $variation->id }}">{{ $variation->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col pe-0">
        <select name="product_variation[{{ $index }}][variationValue][{{ $index2 }}]"
            class="form-select variationValue">
        </select>
    </div>
    <div class="col-auto">
        <button type="button" class="btn btn-dark h-100" onclick="removeVariationValue(this)">
            <span class="fi fi-rr-minus-circle d-flex"></span>
        </button>
    </div>
</div>
