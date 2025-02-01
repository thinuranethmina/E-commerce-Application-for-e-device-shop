<form class="ajaxForm" action="{{ route('admin.variation.store') }}" method="POST">
    @csrf

    <div class="modal-header">
        <div class="w-100 d-flex justify-content-start">
            <span>Create Variation</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">

            <div class="col-xl-10 col-12 mx-auto">
                <div class="form-group">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control">
                </div>
            </div>

            <div class="col-xl-10 col-12 mx-auto">
                <div class="form-group" id="variationContainer">
                    <label for="values" class="form-label">Values</label>
                    <div class="row mb-2">
                        <div class="col pe-0">
                            <input type="text" id="name" name="values[]" class="form-control">
                        </div>
                        <div class="col-2 pe-0">
                            <input type="color" id="color" name="colors[]" class="form-control">
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-primary h-100" onclick="addVariationValue()">
                                <span class="fi fi-rr-add d-flex"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn close-btn" onclick="closeModal();">Close</button>
        <button type="submit" class="btn save-btn">Save</button>
    </div>

</form>
