<form class="ajaxForm" action="{{ route('admin.review.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <div class="w-100 d-flex justify-content-start">
            <span>Edit Review</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-12">
                <div class="form-group">
                    <label for="product_id" class="form-label">Product</label>
                    <select class="form-select" name="product_id" id="product_id">
                        @foreach ($products as $key => $value)
                            <option value="{{ $value->id }}" {{ $item->product_id == $value->id ? 'selected' : '' }}>
                                {{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" value="{{ $item->name }}"
                        class="form-control">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" id="email" name="email" value="{{ $item->email }}"
                        class="form-control">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="form-group">
                    <label for="rating" class="form-label">Rate</label>
                    <select class="form-select" name="rating" id="rating">
                        <option value="1" {{ $item->rating == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ $item->rating == '2' ? 'selected' : '' }}>2</option>
                        <option value="3" {{ $item->rating == '3' ? 'selected' : '' }}>3</option>
                        <option value="4" {{ $item->rating == '4' ? 'selected' : '' }}>4</option>
                        <option value="5" {{ $item->rating == '5' ? 'selected' : '' }}>5</option>
                    </select>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Active" {{ $item->status == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $item->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="comment" class="form-label">Comment</label>
                    <textarea class="form-control" name="comment" id="comment" rows="4">{{ $item->comment }}</textarea>
                </div>
            </div>


        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn close-btn" onclick="closeModal();">Close</button>
        <button type="submit" class="btn save-btn">Save</button>
    </div>

</form>
