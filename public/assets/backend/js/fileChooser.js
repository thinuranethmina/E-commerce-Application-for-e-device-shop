let imageArray = [];

function previewImageChooser(inputId, titleId, initialImage, attributeStatus, mode, imagePath, imageIndex) {

    var fileChooserTitle = document.getElementById(titleId);
    var input = document.getElementById(inputId);
    var selectedImage = document.getElementById('selected' + inputId.charAt(0).toUpperCase() + inputId.slice(1));

    if (input.hasAttribute('multiple') == true) {

        if (mode == 'edit') {
            var preview = document.createElement('div');
            var image = document.createElement('img');
            var closeIcon = document.createElement('div');

            preview.className = 'image-preview multipleImages';
            image.className = 'preview-image';
            closeIcon.className = 'close-icon';
            closeIcon.innerHTML = '<i class="fi fi-rr-cross-small" onclick="removeImage(' + imageIndex + ', \'' + inputId + '\', \'' + titleId + '\', \'' + imagePath + '\', \'' + mode + '\')"></i>';
            image.src = imagePath + '/' + initialImage;

            preview.appendChild(image);
            preview.appendChild(closeIcon);

            selectedImage.appendChild(preview);

            var imageObject = {
                image: initialImage,
                status: "uploaded"
            };

            imageArray.push(imageObject);

        } else {
            for (var i = 0; i < input.files.length; i++) {
                var currentFile = input.files[i];

                // imageArray.push(currentFile);

                var imageObject = {
                    image: currentFile,
                    status: "newset"
                };

                imageArray.push(imageObject);

                updatePreview(inputId, titleId, imagePath, attributeStatus, mode);
            }

        }

        selectedImage.style.display = 'block';


    } else {
        var preview = document.createElement('div');
        var image = document.createElement('img');


        fileChooserTitle.style.display = 'none';
        preview.className = 'image-preview ' + inputId;
        // preview.id = 'preview' + inputId;
        image.src = input.files && input.files.length > 0 && input.files[0].type.startsWith('image/') ?
            URL.createObjectURL(input.files[0]) : imagePath + '/' + initialImage;

        var closeIcon = document.createElement('div');
        closeIcon.className = 'close-icon';
        closeIcon.innerHTML = '<i class="fi fi-rr-cross-small" onclick="removeImage(0, \'' + inputId + '\', \'' + titleId + '\', \'' + imagePath + '\', \'' + mode + '\')"></i>';

        image.className = 'preview-image';

        preview.appendChild(image);
        preview.appendChild(closeIcon);

        selectedImage.appendChild(preview);
        selectedImage.style.display = 'block';

        preview.setAttribute('data-status', attributeStatus);
    }

}

function removeImage(index, inputId, titleId, imagePath, mode) {
    var input = document.getElementById(inputId);
    var selectedImage = document.getElementById('selected' + inputId.charAt(0).toUpperCase() + inputId.slice(1));
    var previewImage = document.querySelector('.' + inputId);
    var fileChooserTitle = document.getElementById(titleId);

    var previewNewImage = document.querySelector('.image-preview[data-status="undefined"]');

    if (input.hasAttribute('multiple')) {
        if (imageArray[index].status == 'newset') {
            imageArray.splice(index, 1);
        } else {
            imageArray[index].status = 'deleted';
        }

        updatePreview(inputId, titleId, imagePath);

    } else {
        var currentStatus = previewImage.getAttribute('data-status');

        if (previewImage.getAttribute('data-status') == 'uploaded') {
            fileChooserTitle.style.display = 'block';
            previewImage.style.display = 'none';
            previewImage.setAttribute('data-status', 'deleted');
            input.setAttribute('data-status', 'deleted');
        } else {
            fileChooserTitle.style.display = 'block';
            previewNewImage.remove();
            input.value = null;
        }

    }
}


function updatePreview(inputId, titleId, imagePath, attributeStatus, mode) {

    var selectedImage = document.getElementById('selected' + inputId.charAt(0).toUpperCase() + inputId.slice(1));

    selectedImage.innerHTML = '';

    for (var i = 0; i < imageArray.length; i++) {
        var preview = document.createElement('div');
        var image = document.createElement('img');
        var closeIcon = document.createElement('div');

        preview.className = 'image-preview multipleImages';
        image.className = 'preview-image';

        closeIcon.className = 'close-icon';
        closeIcon.innerHTML = '<i class="fi fi-rr-cross-small" onclick="removeImage(' + i + ', \'' + inputId + '\', \'' + titleId + '\', \'' + imagePath + '\', \'' + mode + '\')"></i>';

        var hasStatus = imageArray[i].hasOwnProperty('status');
        var imageSource;

        if (hasStatus) {
            if (imageArray[i].status !== 'deleted') {
                imageSource = imageArray[i].image;
            } else {
                imageSource = imageArray[i].image;
                preview.style.display = 'none';
            }
        } else {
            imageSource = imageArray[i];
        }

        if (typeof imageSource === 'string') {
            image.src = '../../../' + imageSource;
        } else if (imageSource instanceof Blob) {
            image.src = URL.createObjectURL(imageSource);
        }

        preview.appendChild(image);
        preview.appendChild(closeIcon);

        selectedImage.appendChild(preview);
    }

    selectedImage.style.display = imageArray.length > 0 ? 'block' : 'none';
}