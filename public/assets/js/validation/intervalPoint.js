if ($("#form-create").length > 0) {
    $("#form-create").validate({
        ignore: '*:not([name])',
        rules: {
            name: {
                required: true,
            },
            type: {
                required: true,
            },
            from: {
                required: true,
            },
            to: {
                required: true,
            },

        },
        messages: {
            name: {
                required: function() {
                    toastr.error('Nama Pelanggaran Harus Diisi')
                },
            },
            type: {
                required: function() {
                    toastr.error('Urgensi Pelanggaran Harus Diisi')
                },
            },
            from: {
                required: function() {
                    toastr.error('Point Awal Harus Diisi')
                },
            },
            to: {
                required: function() {
                    toastr.error('Point Akhir Harus Diisi')
                },
            },
        },
        debug: true,
        submitHandler : function(form) {
            form.submit();
        }
    })
}


if ($("#form-edit").length > 0) {
    $("#form-edit").validate({
        ignore: '*:not([name])',
        rules: {
            name: {
                required: true,
            },
            type: {
                required: true,
            },
            from: {
                required: true,
            },
            to: {
                required: true,
            },

        },
        messages: {
            name: {
                required: function() {
                    toastr.error('Nama Pelanggaran Harus Diisi')
                },
            },
            type: {
                required: function() {
                    toastr.error('Urgensi Pelanggaran Harus Diisi')
                },
            },
            from: {
                required: function() {
                    toastr.error('Point Awal Harus Diisi')
                },
            },
            to: {
                required: function() {
                    toastr.error('Point Akhir Harus Diisi')
                },
            },
        },
        debug: true,
        submitHandler : function(form) {
            form.submit();
        }
    })
}