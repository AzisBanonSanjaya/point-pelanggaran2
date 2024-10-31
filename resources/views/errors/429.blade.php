<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login Megastore</title>
	<style>
		@font-face {
		  	font-family: 'gotham';
		  	src: url('{{ asset('underconstruction/font/gotham.woff') }}') format('woff');
		}
		body{
			width: 100%;
			height: 100vh;
			padding: 0;
			margin: 0;
			background: #f2f2f2;
			font-family: 'gotham';
		}
		.box-construction {
			width: 100%;
			height: 100vh;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
		}
		.image-logo {
			width: 190px;
			height: auto;
			object-fit: fill;
		}
		.image-animation {
			width: 420px;
			height: auto;
			padding: 24px;
			object-fit: fill;
		}
		.text-title {
			padding: 16px;
			color: #454545;
			margin: 0;
		}
		.text-desc {
			color: #757575;
			margin: 0;
			padding-bottom: 20px;
		}
		.box-btn {
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.btn {
			padding: 5.5px 6px;
			border-radius: 50%;
			background: #0abcc8;
			display: flex;
			margin: 6px;
			justify-content: center;
			align-items: center;

		}
		.btn img {
			width: 18px;
			height: 18px;
		}

		@media only screen and (max-width: 720px) {
			.image-animation {
				width: 80%;
			}
		}
	</style>
</head>
<body>
	<div class="box-construction">
		<img src="{{ asset('underconstruction/img/login.png') }}" class="image-logo" alt="">
		<img src="{{ asset('underconstruction/img/animation.gif') }}" class="image-animation" alt="">
		<p class="text-title">To Many Request</p>
		<div class="box-btn">
			<a href="https://www.facebook.com/sejutasenyuman/" target="blank" class="btn"><img src="{{ asset('underconstruction/img/facebook-icon.png') }}" alt=""></a>
			<a href="https://twitter.com/loginmegastore" target="blank" class="btn"><img src="{{ asset('underconstruction/img/twitter-icon.png') }}" alt=""></a>
		</div>
	</div>
</body>
</html>
