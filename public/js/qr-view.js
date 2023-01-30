$(document).ready(function () {
    let data = $('#qr-code').html();
    console.log(data);
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');
    var DOMURL = window.URL || window.webkitURL || window;

    var img = new Image();
    let url = URL.createObjectURL(new Blob([data], {
        type: "image/svg+xml;charset=utf-8"
    }));

    img.onload = function () {
        ctx.drawImage(img, 0, 0);
        DOMURL.revokeObjectURL(url);

        var imgURI = canvas
            .toDataURL('image/png')
            .replace('image/png', 'image/octet-stream');

        triggerDownload(imgURI);
    };

    $('#img-qr-code').attr('src', url);

    getDataUri(url, function (dataUri) {
        $('#download').attr('href', dataUri);
    });

});

function getDataUri(url, callback) {
    var image = new Image();

    image.onload = function () {
        var canvas = document.createElement('canvas');
        canvas.width = this.naturalWidth; // or 'width' if you want a special/scaled size
        canvas.height = this.naturalHeight; // or 'height' if you want a special/scaled size

        canvas.getContext('2d').drawImage(this, 0, 0);

        // Get raw image data
        callback(canvas.toDataURL('image/png').replace(/^data:image\/(png|jpg);base64,/, ''));

        // ... or get as Data URI
        callback(canvas.toDataURL('image/png'));
    };

    image.src = url;
}
