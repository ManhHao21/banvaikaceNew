function readURL(input) {
    if (input.files && input.files.length > 0) {
        for (let i = 0; i < input.files.length; i++) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const imageId = 'image-' + Date.now(); // Unique identifier for each image
                const imageHtml = `
                    <div id="${imageId}" class="uploaded-image"  width='200px' height="200px">
                        <img class="file-upload-image image-full" src="${e.target.result}" alt="uploaded image"  width='200px' height="200px" />
                        <i class="fa fa-times-circle icon-close" onclick="removeImage('${imageId}')" aria-hidden="true"></i>
                    </div>
                `;
                $('.file-upload-content').append(imageHtml);
            };
            reader.readAsDataURL(input.files[i]);
        }

        $('.image-upload-wrap').hide();
        $('.file-upload-content').show();
    } else {
        removeUpload();
    }
}

function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').empty(); // Clear all images
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
}

function removeImage(imageId) {
    $('#' + imageId).remove();
}

$('.image-upload-wrap').bind('dragover', function () {
    $('.image-upload-wrap').addClass('image-dropping');
});

$('.image-upload-wrap').bind('dragleave', function () {
    $('.image-upload-wrap').removeClass('image-dropping');
});
