<div class="image-chooser">
    <label for="{{ $name }}">
        <div class="preview-image {{ $type ?? '' }}" style="background-color: {{ $bgColor ?? 'white' }}">
            <img id="{{ $name }}Preview" class="image {{ $cover ? 'cover' : 'contain' }}"
                src="{{ $src ?? asset('assets/global/images/default.png') }}"
                style="width: {{ $width ?? '100%' }}; height: {{ $height ?? '100%' }}; max-height: {{ $maxHeight ?? '200px' }};">
            <div class="image-overlay"></div>
        </div>
    </label>
</div>

<input type="file" id="{{ $name }}" name="{{ $name }}" class="form-control d-none"
    onchange="previewImage(this, '{{ $name }}Preview');">
