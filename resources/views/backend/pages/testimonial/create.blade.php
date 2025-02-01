<form class="ajaxForm" action="{{ route('admin.testimonial.store') }}" method="POST">
    @csrf

    <div class="modal-header">
        <div class="w-100 d-flex justify-content-start">
            <span>Create Testimonial</span>
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
                        ];
                    @endphp
                    @include('backend.components.image-chooser', $data)
                </div>
            </div>

            <div class="col-xl-6">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="form-group">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" id="location" name="location" class="form-control">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="form-group">
                    <label for="rating" class="form-label">Rate</label>
                    <select class="form-select" name="rating" id="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="comment" class="form-label">Comment</label>
                    <textarea class="form-control" name="comment" id="comment" rows="4"></textarea>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn close-btn" onclick="closeModal();">Close</button>
        <button type="submit" class="btn save-btn">Save</button>
    </div>

</form>
