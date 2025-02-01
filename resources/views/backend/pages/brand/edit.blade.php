<form class="ajaxForm" action="{{ route('admin.brand.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <div class="w-100 d-flex justify-content-start">
            <span>Edit Brand</span>
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
                            'height' => '80px',
                            'maxHeight' => '80px',
                            'name' => 'image',
                            'cover' => false,
                            'type' => 'box',
                            'bgColor' => 'white',
                            'src' => asset($item->icon),
                        ];
                    @endphp
                    @include('backend.components.image-chooser', $data)
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
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Active" {{ $item->status == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $item->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn close-btn" onclick="closeModal();">Close</button>
        <button type="submit" class="btn save-btn">Save</button>
    </div>

</form>
