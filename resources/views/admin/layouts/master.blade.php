<!doctype html>
<html lang="en">
	<head>
		@include('admin.partials.master.header')
		@yield('styles')
	</head>
	<body>
		<div class="wrapper">
			<!-- <div class="sidebar" data-color="gray">
				<div class="sidebar-wrapper">
					<div class="logo">
						<a href="/" class="simple-text">
							{{ env('APP_NAME') }}
						</a>
					</div>
					
				</div>
			</div> -->
			<div class="main-panel">
				@include('admin.partials.master.headernav')
				<div class="content">
					<div class="container-fluid">
						@yield('content')
					</div>
				</div>
				<footer class="footer">
					<div class="container-fluid">
						<p class="copyright pull-right">
							©2019 Powered By <a href="http://atconline.biz/" target="_blank">ATC Online</a>
						</p>
					</div>
				</footer>
			</div>
		</div>
	</body>
	@include('admin.partials.master.footerscripts')
	@yield('scripts')
</html>
