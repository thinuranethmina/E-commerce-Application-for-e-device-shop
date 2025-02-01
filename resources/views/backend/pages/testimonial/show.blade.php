<div class="modal-header">
    <div class="w-100 d-flex justify-content-start">
        <span>View Testimonial</span>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row">

        <div class="col-12 text-center">
            <div class="form-group d-inline-block">

                @php
                    $data = [
                        'width' => '120px',
                        'height' => '120px',
                        'maxHeight' => '120px',
                        'name' => 'image',
                        'cover' => true,
                        'type' => 'circle',
                        'bgColor' => 'white',
                        'src' => $item->image ? asset($item->image) : asset('assets/global/images/default.png'),
                    ];
                @endphp
                @include('backend.components.image-chooser', $data)
            </div>
        </div>

        <div class="col-xl-6">
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" value="{{ $item->name }}" class="form-control"
                    disabled>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="form-group">
                <label for="location" class="form-label">Location</label>
                <input type="text" id="location" name="location" value="{{ $item->location }}" class="form-control"
                    disabled>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="form-group">
                <label for="rating" class="form-label">Rate</label>
                <select class="form-select" name="rating" id="rating" disabled>
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
                <select name="status" id="status" class="form-select" disabled>
                    <option value="Active" {{ $item->status == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $item->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control" name="comment" id="comment" rows="4" disabled>{{ $item->comment }}</textarea>
            </div>
        </div>

    </div>
</div>
