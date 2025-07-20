<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title')</title>
    <meta content="Sman 1 Banjaran" name="description">
    <meta content="Sman 1 Banjaran" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/sman-1.png')}}" rel="icon">
    <link href="{{ asset('assets/img/sman-1.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="{{ asset('assets/vendor/toastr/toastr.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/tree.css')}}" rel="stylesheet">
    
    <style>
        .img-logo{
            max-width: 50%;
            height: auto;
            margin: 0 auto;
        }
        .img-profile{
            max-width: 30%;
            height: auto;
            margin: 0 auto;
        }
        .text-red{
            color: red;
        }

        .select2-container .select2-selection--single {
        height: 36px !important;
		}

		.hidden {
			display: none;
		}

		.bold{
			font-weight: 1000;
		}
		.fs-4 {
			font-size: 1rem!important;
		}

        .error{
			color: #dc3545;
			border-color: #dc3545;
			padding-right: 2.25rem!important;
			background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
			background-repeat: no-repeat;
			background-position: right calc(0.375em + 0.1875rem) center;
			background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
		}

        .table{
            width: 100% !important;
        }

        .btn{
            font-size: 12px;
        }

        div.dataTables_wrapper div.dataTables_length label{
            font-size: 13px !important;
        }
        div.dataTables_wrapper div.dataTables_filter label{
            font-size: 13px !important;
        }
        .table>thead{
            font-size: 13px !important;
        }
        .table>tbody{
            font-size: 13px !important;
        }
        table.dataTable td.dataTables_empty, table.dataTable th.dataTables_empty{
            font-size: 13px !important;
        }
        div.dataTables_wrapper div.dataTables_info{
            font-size: 13px !important;
        }
        .page-link{
            font-size: 13px !important;
        }
        .form-label{
            font-size: 13px !important;
        }
        .form-control{
            font-size: 13px !important;
        }
        .modal-title{
            font-size: 18px !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice{
            font-size: 14px;
            background-color: #0e9fc0;
            color: #ffffff;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
            color: #ffffff;
        }

    </style>
    @stack('styles')
  </head>
