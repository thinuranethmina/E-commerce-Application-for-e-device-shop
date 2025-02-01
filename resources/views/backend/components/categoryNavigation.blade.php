@if (isset($view) && $view == 'disabled')
    <div class="category-navigation">
        <ul class="categories" id="categories">
            @foreach ($categories as $category)
                <li>
                    <input type="checkbox" id="category-{{ $category->id }}" class="category form-check-input"
                        {{ isset($product) ? ($product->subCategory->category->id == $category->id ? 'checked' : '') : '' }}
                        disabled>
                    <label for="category-{{ $category->id }}">{{ $category->name }}</label>
                    <ul class="subcategories">
                        @foreach ($category->subcategories as $subcategory)
                            <li>
                                <label for="subcategory-{{ $subcategory->id }}">
                                    <input type="checkbox" id="subcategory-{{ $subcategory->id }}" name="sub_category_id"
                                        class="subcategory form-check-input"
                                        data-category="category-{{ $category->id }}" value="{{ $subcategory->id }}"
                                        {{ isset($product) ? ($product->sub_category_id == $subcategory->id ? 'checked' : '') : '' }}
                                        disabled>
                                    {{ $subcategory->name }}</label>
                            </li>
                        @endforeach

                        @if ($category->subcategories->count() == 0)
                            <li>
                                No Related Sub Category
                            </li>
                        @endif
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <div class="category-navigation">
        <ul class="categories" id="categories">
            @foreach ($categories as $category)
                <li>
                    <input type="checkbox" id="category-{{ $category->id }}" class="category form-check-input"
                        {{ isset($product) ? ($product->subCategory->category->id == $category->id ? 'checked' : '') : '' }}>
                    <label for="category-{{ $category->id }}">{{ $category->name }}</label>
                    <ul class="subcategories">
                        @foreach ($category->subcategories as $subcategory)
                            <li>
                                <label for="subcategory-{{ $subcategory->id }}">
                                    <input type="checkbox" id="subcategory-{{ $subcategory->id }}"
                                        name="sub_category_id" class="subcategory form-check-input"
                                        data-category="category-{{ $category->id }}" value="{{ $subcategory->id }}"
                                        {{ isset($product) ? ($product->sub_category_id == $subcategory->id ? 'checked' : '') : '' }}>
                                    {{ $subcategory->name }}</label>
                            </li>
                        @endforeach

                        @if ($category->subcategories->count() == 0)
                            <li>
                                No Related Sub Category
                            </li>
                        @endif
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>

@endif
