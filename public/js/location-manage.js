$(document).ready(function () {
    let location_table = $("#location-table").DataTable({
        responsive: true,
        ajax: {
            "url": "/locations"
        },
        columns: [{
                "data": 'cnt'
            },
            {
                "data": 'address'
            },
            {
                "data": 'latitude'
            },
            {
                "data": 'longitude'
            },
            {
                "data": 'distance'
            },
            {
                "data": ''
            },
        ],
        columnDefs: [{
            targets: -1,
            orderable: false,
            render: function () {
                return `
                <a href="javascript:;" class="edit-location"><i class="mdi mdi-lead-pencil"></i></a>&nbsp;&nbsp;
                <a href="javascript:;" class="delete-location"><i class="mdi mdi-delete"></i></a>
                `;
            }
        }, ],
        "order": [
            [0, 'asc']
        ]
    });

    $("#location-table tbody").on("click", ".edit-location", function () {
        let selectedData = location_table.row($(this).closest('tr')).data();

        $('#location-modal').modal('show');
        $('#location-modal #location-edit-id').val(selectedData.id);
        $('#location-modal #location-address').val(selectedData.address);
        $('#location-modal #location-latitude').val(selectedData.latitude);
        $('#location-modal #location-longitude').val(selectedData.longitude);
        $('#location-modal #location-distance').val(selectedData.distance);
        $('#location-modal .modal-title').text('Edit Location');
        $('#location-modal .btn-location').text('Edit');
    });

    $("#location-table tbody").on("click", ".delete-location", function () {
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: '/locations/destroy',
                    type: 'delete',
                    data: {
                        id: location_table.row($(this).closest('tr')).data().id,
                        _token: _token
                    },
                    dataType: 'text',
                    success: function (data) {
                        if (data == "1") {
                            swal("Deleted!", "Data has been deleted.", "success");
                            location_table.ajax.reload();
                        } else if (data == "-1") {
                            swal("Warning!", "Can't delete this location. First delete the cities or the sites that related with this location.", "warning");
                        }
                    }
                });
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {}
        });
    });

    $("#location-modal").on('hide.bs.modal', function () {
        $('#location-modal #location-edit-id').val('0');
        $('#location-modal #location-address').val('');
        $('#location-modal #location-latitude').val('');
        $('#location-modal #location-longitude').val('');
        $('#location-modal #location-distance').val('');
        $('#location-modal .modal-title').text('Add Location');
        $('#location-modal .btn-location').text('Add');

        $("#location-modal").find(".alert").remove();
    });

    $('.form-location').on('submit', function (e) {
        e.preventDefault();

        let id = $('#location-edit-id').val();
        let address = $('#location-address').val();
        let latitude = $('#location-latitude').val();
        let longitude = $('#location-longitude').val();
        let distance = $('#location-distance').val();

        let url = '/locations',
            method = 'post';
        if (id > 0) {
            url = '/locations/' + id;
            method = 'put';
        }

        $.ajax({
            url: url,
            type: method,
            data: {
                address: address,
                latitude: latitude,
                longitude: longitude,
                distance: distance,
                _token: _token
            },
            dataType: 'text',
            success: function (data) {
                processResult(data);
            }
        });

    });

    function processResult(data) {
        if (data == "1") {
            location_table.ajax.reload();

            $('#location-modal').modal('hide');
        } else if (data == -1) {
            showMessage($("#location-modal").find("form").find(".modal-body"), "warning", "Location name is already existed!");
        }
    }

});
