<form class="ajaxForm" action="{{ route('admin.banner.store') }}" method="POST">
    @csrf

    <div class="modal-header">
        <div class="w-100 d-flex justify-content-start">
            <span>Create Banner</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-12 text-center">
                <div class="form-group d-inline-block">

                    @php
                        $data = [
                            'width' => '300px',
                            'height' => '300px',
                            'maxHeight' => '300px',
                            'name' => 'image',
                            'cover' => false,
                            'type' => 'box',
                            'bgColor' => 'white',
                        ];
                    @endphp
                    @include('backend.components.image-chooser', $data)
                </div>
            </div>

            <div class="col-xl-6">
                <div class="form-group">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" id="title" name="title" class="form-control">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="form-group">
                    <label for="url" class="form-label">URL</label>
                    <input type="text" id="url" name="url" class="form-control">
                </div>
            </div>

            <div class="col-xl-6">
                <div class="form-group">
                    <label for="type" class="form-label">Type</label>
                    <select name="type" id="type" class="form-select">
                        <option value="hero">Hero</option>
                        <option value="bottom_bar">Bottom Bar</option>
                        <option value="home_sidebar">Home Side Bar</option>
                        <option value="shop_sidebar">Shop Side Bar</option>
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

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn close-btn" onclick="closeModal();">Close</button>
        <button type="submit" class="btn save-btn">Save</button>
    </div>

</form>
