if ($("#form-create").length > 0) {
    $("#form-create").validate({
        ignore: '*:not([name])',
        rules: {
            name: {
                required: true,
            },
            major: {
                required: true,
            },
            user_id: {
                required: true,
            },

        },
        messages: {
            name: {
                required: function() {
                    toastr.error('Nama Kelas Harus Diisi')
                },
            },
            major: {
                required: function() {
                    toastr.error('Jurusan Harus Diisi')
                },
            },
            user_id: {
                required: function() {
                    toastr.error('Wali Kelas Harus Diisi')
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
            major: {
                required: true,
            },
            user_id: {
                required: true,
            },

        },
        messages: {
            name: {
                required: function() {
                    toastr.error('Nama Kelas Harus Diisi')
                },
            },
            major: {
                required: function() {
                    toastr.error('Jurusan Harus Diisi')
                },
            },
            user_id: {
                required: function() {
                    toastr.error('Wali Kelas Harus Diisi')
                },
            },
        },
        debug: true,
        submitHandler : function(form) {
            form.submit();
        }
    })
}