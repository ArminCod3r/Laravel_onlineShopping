@extends('site/layouts/siteLayout')

@section('header')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>پروفایل</title>
@endsection

@section('content')
	<div class="container-fluid users_profile">
		<div class="row">

			<div class="col-sm-3 right_side">
				<ul>

					<li>
						<a href="#"> سفارشات من </a>
					</li>

					<li>
						<a href="#">لیست مورد علاقه</a>
					</li>

					<li>
						<a href="#"> نقدهای من </a>
					</li>

					<li>
						<a href="#"> نظرات من </a>
					</li>

					<li>
						<a href="#"> آدرس ها </a>
					</li>

				</ul>
			</div>

			<div class="col-sm-9 left_side">
				details
			</div>

		</div>		
	</div>
@endsection