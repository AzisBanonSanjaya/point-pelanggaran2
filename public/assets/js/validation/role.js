if ($("#form-role").length > 0) {
    $("#form-role").validate({
        ignore: '*:not([name])',
        rules: {
            name: {
                required: true,
            },
            "permission_id[]": {
                required: true,
            },

        },
        messages: {
            name: {
                required: function() {
                    toastr.error('Nama Role Harus Diisi')
                },
            },
            "permission_id[]": {
                required: function() {
                    toastr.error('Permission Harus Dipilih')
                },
            },
        },
        debug: true,
        submitHandler : function(form) {
            form.submit();
        }
    })
}
