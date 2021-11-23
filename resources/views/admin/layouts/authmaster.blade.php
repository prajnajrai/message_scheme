<!doctype html>
<html lang="en">
	<head>
		@include('admin.partials.master.header')
		@yield('styles')
	</head>
	<body>
		<style>
			@media (min-width: 768px) {
				.register-form {
					position: relative;
					top: 50%;
					transform: translateY(5%);
				}

				.login-form {
					position: relative;
					top: 50%;
					transform: translateY(20%);
				}
			}
			.text-small {
				font-size: 12px;
			}
		</style>
		<div class="wrapper">
			@yield('content')
		</div>
	</body>
	@include('admin.partials.master.footerscripts')
	@yield('scripts')
</html>