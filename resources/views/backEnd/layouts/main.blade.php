<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	@include('backEnd.layouts.head')
	<body class="d-flex flex-column min-vh-100">
		@include('backEnd.layouts.sidebar')
		<main id="main" class="main">
			@yield('content')
        </main>

		@include('backEnd.layouts.footer')
		@include('backEnd.layouts.script')
	</body>
</html>

