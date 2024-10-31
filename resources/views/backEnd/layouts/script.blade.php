 <!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="{{ asset('assets/vendor/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{asset('assets/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/vendor/quill/quill.min.js')}}"></script>
<script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('assets/vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{asset('assets/vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('assets/vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="{{ asset('assets/vendor/toastr/toastr.min.js') }}"></script>
 <!-- Template Main JS File -->
<script src="{{asset('assets/js/main.js')}}"></script>
<script>
    $(document).ready(function() {
		$('*select[data-selectModalCreatejs="true"]').select2({
            dropdownParent: $('#modal-create'),
			width: '100%',
    	});
		$('*select[data-selectModalEditjs="true"]').select2({
            dropdownParent: $('#modal-edit'),
			width: '100%',
    	});
		$('*select[data-selectjs="true"]').select2({
			width: '100%',
        });
		// $('body').Layout('fixLayoutHeight')
		$(".datepicker").datepicker({
			dateFormat: 'dd-mm-yy'
		});
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        @if (Session::has('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ Session::get('success') }}'
            })
        @endif

        @if (Session::has('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ Session::get('error') }}'
            })
        @endif

        $('#data-table').DataTable();

        $(".number-only").keyup(function(e) {
            var regex = /^[0-9]+$/;
            if (regex.test(this.value) !== true) {
                this.value = this.value.replace(/[^0-9]+/, '');
            }
        });
        $(".currency").on("keyup", function() {
            value = $(this).val().replace(/,/g, '');
            if (!$.isNumeric(value) || value == NaN) {
                $(this).val('0').trigger('change');
                value = 0;
            }
            $(this).val(parseFloat(value, 10).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        });
		$(".numbersymbol").keyup(function(e) {
			var regex = /^[0-9(&).,:\-/ X]+$/;
			if (regex.test(this.value) !== true) {
				this.value = this.value.replace(/[^0-9(&).,:\-/ X]+/, '');
			}
		});
        $('.table-responsive').on('show.bs.dropdown', function () {
            $('.table-responsive').css( "overflow", "inherit" );
        });

        $('.table-responsive').on('hide.bs.dropdown', function () {
            $('.table-responsive').css( "overflow", "auto" );
        })



    });
</script>
@stack('scripts')

