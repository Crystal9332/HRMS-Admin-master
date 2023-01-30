$(document).ready(function () {

    downloadImg($('.qr-code').html());

    $('#city').on('change', function () {
        if ($(this).val() == '') {
            $('#site').val('');
            return;
        }

        $('#ref-email').val('');

        $.ajax({
            url: '/getSite/' + $(this).val(),
            type: 'get',
            dataType: 'json',
            async: false,
            success: function (response) {

                $('#site').empty();
                $('#site').append($('<option>', {
                    value: '',
                    text: 'Choose Site'
                }));
                $.each(response.data, function (i, data) {
                    $('#site').append($('<option>', {
                        value: data.data.id,
                        text: data.name
                    }));
                });
            }
        });
    });
    $('#site').on('change', function () {
        if ($(this).val() == '') {
            $('#ref-email').val('');
            return;
        }
        $.ajax({
            url: '/getReferenceEmail/' + $(this).val(),
            type: 'get',
            dataType: 'text',
            async: false,
            success: function (data) {
                $('#email').val(data);
            }
        });
    });
    $('i.edit-email').on('click', function () {
        if (!$('#city').val()) {
            showMessage($('form').find('div.col-md-6').find('div.message'), 'warning', 'Please select City');
            return;
        }
        if (!$('#site').val()) {
            showMessage($('form').find('div.col-md-6').find('div.message'), 'warning', 'Please select Site');
            return;
        }
        $('#selected-city-text').val($('#city option:selected').text());
        $('#selected-site-text').val($('#site option:selected').text());
        $('#ref-email').val($('#email').val())
        $('#email-modal').modal('show');
    });
    $('form.form-email').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/editSite/' + $('#site').val(),
            type: 'put',
            data: {
                email: $('#ref-email').val(),
                _token: _token
            },
            dataType: 'text',
            success: function (data) {
                if (data == 1) {
                    $('#email').val($('#ref-email').val())
                }
                $('#email-modal').modal('hide');
            }
        });
    });
    $('form.form-qr').on('submit', function (e) {
        e.preventDefault();

        let validate = true,
            data = {};
        $('input.check').each(function (index, element) {
            if ($(this)[0].checked) {
                let cnt = 0;
                $(this).closest('.time-container').find('input.form-control').each(function (i, e) {
                    if (!$(this).val()) {
                        $(this).closest('.controls').find('div.help-block').html('<ul role="alert"><li>This is required</li></ul>');
                        validate = false;
                    } else {
                        cnt++;
                    }
                });
                if (cnt == 2) {
                    // let res = [];
                    data[$(this).closest('.time-container').attr('c-name') + '_time'] = $(this).closest('.time-container').find('input.form-control[type="date"]').val() + ' ' + $(this).closest('.time-container').find('input.form-control[type="time"]').val() + ':00';
                    // data.push(res);
                }
            }
        });

        if (!validate)
            return;

        if (isEmpty(data)) {
            $('div.validate-error').html('<div>Please check either "Start" or "End" at least</div>');
            return;
        }

        data['site_id'] = $('#site').val();
        data['_token'] = _token;

        $.ajax({
            url: '/qrs/' + $('#code-id').val(),
            type: 'put',
            data: data,
            dataType: 'text',
            async: false,
            success: function (data) {
                $('#download').removeClass('hidden');
                $('#download').addClass('show');

                downloadImg(data);
            }
        });
    });

    $('input.check').on('change', function () {
        if ($(this)[0].checked) {
            $(this).closest('.time-container').find('input.form-control').prop('disabled', false);
            $(this).closest('.time-container').find('input.form-control').prop('required', true);
            $('div.validate-error').html('');
        } else {
            $(this).closest('.time-container').find('input.form-control').prop('disabled', true);
            $(this).closest('.time-container').find('input.form-control').prop('required', false);
            $(this).closest('.time-container').find('div.help-block').html('');
        }
    });
});

function showMessage(e, i, c) {
    var l = $('<div class="alert alert-' + i + ' alert-dismissible fade show add-category-message-type" role="alert">\n' +
        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
        '<span aria-hidden="true">&times;</span>\n' +
        '</button>\n' +
        '<strong>' + c + '</strong>' +
        '</div>');
    l.prependTo(e);
};

function isEmpty(obj) {
    for (var key in obj) {
        if (obj.hasOwnProperty(key))
            return false;
    }
    return true;
}

function createElementFromHTML(htmlString) {
    var div = document.createElement('div');
    div.innerHTML = htmlString.replace('<?xml version="1.0" encoding="UTF-8"?>', '').trim();

    return div.firstChild;
}

function downloadImg(data) {
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
}

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
