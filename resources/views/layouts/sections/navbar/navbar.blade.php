@php
	$containerNav = $containerNav ?? 'container-xxl';
	$navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
<nav class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme" id="layout-navbar">
@endif
@if(isset($navbarDetached) && $navbarDetached == '')
	<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
		<div class="{{$containerNav}}">
			@endif

			<!--  Brand demo (display only for navbar-full and hide on below xl) -->
			@if(isset($navbarFull))
				<div class="py-0 navbar-brand app-brand demo d-none d-xl-flex me-4">
					<a href="{{url('/')}}" class="gap-2 app-brand-link">
						<span class="app-brand-logo demo">
							@include('_partials.macros',["width"=>25,"withbg"=>'#666cff'])
						</span>
						<span class="app-brand-text demo menu-text fw-bold">{{config('variables.templateName')}}</span>
					</a>
				</div>
			@endif

			<!-- ! Not required for layout-without-menu -->
			@if(!isset($navbarHideToggle))
				<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ?' d-xl-none ' : '' }}">
					<a class="px-0 nav-item nav-link me-xl-4" href="javascript:void(0)">
						<i class="mdi mdi-menu mdi-24px"></i>
					</a>
				</div>
			@endif

			<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

				{{-- @if(!isset($menuHorizontal))
					<!-- Search -->
					<div class="navbar-nav align-items-center">
						<div class="mb-0 nav-item navbar-search-wrapper">
							<a class="px-0 nav-item nav-link search-toggler fw-normal" href="javascript:void(0);">
								<i class="mdi mdi-magnify mdi-24px scaleX-n1-rtl"></i>
								<span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
							</a>
						</div>
					</div>
					<!-- /Search -->
				@endif --}}

				<ul class="flex-row navbar-nav align-items-center ms-auto">
					{{-- @if(isset($menuHorizontal))
						<!-- Search -->
						<li class="nav-item navbar-search-wrapper me-2 me-xl-0">
							<a class="nav-link search-toggler" href="javascript:void(0);">
								<i class="mdi mdi-magnify mdi-24px scaleX-n1-rtl"></i>
							</a>
						</li>
						<!-- /Search -->
					@endif --}}

					<!-- Language -->
					<li class="nav-item dropdown-language dropdown me-1 me-xl-0">
						<a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
							href="javascript:void(0);" data-bs-toggle="dropdown">
							{{-- <i class='mdi mdi-translate mdi-24px'></i> --}}
							@if (app()->getLocale() == 'ar')
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAACT0lEQVR4nO2Wy2sTURjFD2j/AB/1D3BrrcWUtkJgcj9i1u6EEkQ32YmvFHHTRRoaRRBRCoJB0xS0ClUKdlXFGrWK1BqamZRIrWlihSbpJAN1m09usKWSZJrHBAU9cJjLfcxvvnPvMAP8l4nmgLY4cEwFzmjAgLRsx4E+OQarpQI9KjCqAT80gKt4QwNCC0B308AocEAFxlSgaAL8zXKuCoQ/A+2NVtmlASu1Ais8QHIB6KwLGgc6NEBvFLoNXogBR2qF7lOBb81Ctzm1AOypJeIxC6GbDplC5Z7Uc5DqjL2rKjg5fDWQHByMtMSBa8MVocy8K6sb67m8wa1wVjd0ySgD53JGX6ugWzaM3nKwbpyqZfEzdZYTq6lSe3z+RemazmZ4dinGI2+eckbPm1XtLgNn88aAGXBtPc8T0Vf8eP4lzyQ+ceJ7mm/MPCqNvf+i8eWpO3x+8pZ53HnDWwnsrbZgaHqU3eNDfCJ8hY8HLzLdPce3X09w/0Mfr2TW+OD1k+wMXuCzkzf5+eKcGfhSOVg33JUmy+iC76b4wcfpUsWbVtPL/CQa4dVsdqvv7VKMPywvmkRd6P8zh6tQ6Pl7Xicpn98f8Hg8kVbY5/cHUE1Op/MwERWJiC12UVGUDpiJiMJWg4UQ97GTXC7XXiJKWwhN2e32nT+LUkKIQ0SkWwAtEFF9fyFE1ElEX5sAy9SOohHZ7fb2X3tez4ErCiFCiqLsR7NSFKVb3kwIsWESqxy713CVZrLZbG0Oh6OXiE4LIbzSsi37FEXZbboY/7p+ArPRNUUu/+PdAAAAAElFTkSuQmCC">
							@else
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAADaklEQVR4nO2W20sUURzH96neooL6I4LKYLUZG2ay1VyScodFsstLTxVFD1Eh9NoFghCKCLf7DcK3cEbTwF3z8rAaWpnt2m7p7s6oaZmsbs7l+I2zrZd0b671UPSFHxx+5/zO58w5Z87vZ7H8VxrV1vauArBdtZccjrDWM9Rom/pon+V3SyiX8nhRvnf4hOcdACgcE1bYfMSNY8LUR/sEUbpTJNZtXTGQqXi+XnBIjwVRmhFEGQeON4dTgWkfHSM4ZMI75IdcmbQuJyjvrN8mOOTB+GQJywo8bx/pTi0LWnKwMU9wSF8WTbRcMHhRHqcfkBUUwBrTJD53m+IprmjQVgKuPOaOhCLRRgAbMoMJuYuENM30n7vg7Vou2Oas1+tehNqIaU5O3Ha1qruEmrTQ8I6CrUoR/07r7u6bhQOYCQ5OtIlHXoxmA6661Pla08yA3t8fVEtt3T/HWWOTLlfq8x7Z76xOTKiPnT7lIbHY1CydEHxtdIebaDMZ+ERVR19f//hLMj0d+3K+yqMw+dO0X7UX99BFALiR6mxXAwhGa592KDu5DwrHhobsxd1a71s/ftXbJOBmAOMUMFRW2kVjFWFHIPrwftuCuDEASx8ZAAyASQAeACaS6yuAliTgceqnu5EibhgAXQSzBKzYbYfiK+XYUIRjBmfbC23Oz1rnwbSdbZzddmgpmCk4Nz9ZJlsEzjIuwljPLgFT5x8Hs9Yzabc6o6XY6lSWdqtpagMwAKALGZTkcs1kCPkOwA2ATQZelbh9cemfggNDe/d0xlfKFwbpCwRC6K1tTQLu0Q0zMIchZGai5marwhd+pPHD+/Z49WCAptTkOZv+5DAM49vVKy0RNn8y/gCUFL3Rfe8/aLr5yfXE706Zj096BuuaQu2EkLlHR/f5Aupu2+ufYwvuWVJJ8/vzVIHzxQcW5k98u36thRhGtKE53GRzNmjZPJmVR5uHwurUq1++/lZNa8TGp89SCmt9MFxe5jVUVR35HPPSDJNLdrp8rcdrGCSUwLssmRRtb9/4fdrsvFjd411pPi6tfD7V0TnyDMBaSzbinPVbeFEe+w2FwCi3r35TVtBZ0cqBd8gDuYJ5UQrw5fJmS67FHi/Kj2gBt5xiTxDl+zkXewtFS1beId3NUN728g7pFj0my19f0P9T+gG2eKpch8Dw1QAAAABJRU5ErkJggg==">
							@endif
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li>
								<a class="dropdown-item" href="{{url('language/ar')}}" data-language="ar" class="active">
									<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAACT0lEQVR4nO2Wy2sTURjFD2j/AB/1D3BrrcWUtkJgcj9i1u6EEkQ32YmvFHHTRRoaRRBRCoJB0xS0ClUKdlXFGrWK1BqamZRIrWlihSbpJAN1m09usKWSZJrHBAU9cJjLfcxvvnPvMAP8l4nmgLY4cEwFzmjAgLRsx4E+OQarpQI9KjCqAT80gKt4QwNCC0B308AocEAFxlSgaAL8zXKuCoQ/A+2NVtmlASu1Ais8QHIB6KwLGgc6NEBvFLoNXogBR2qF7lOBb81Ctzm1AOypJeIxC6GbDplC5Z7Uc5DqjL2rKjg5fDWQHByMtMSBa8MVocy8K6sb67m8wa1wVjd0ySgD53JGX6ugWzaM3nKwbpyqZfEzdZYTq6lSe3z+RemazmZ4dinGI2+eckbPm1XtLgNn88aAGXBtPc8T0Vf8eP4lzyQ+ceJ7mm/MPCqNvf+i8eWpO3x+8pZ53HnDWwnsrbZgaHqU3eNDfCJ8hY8HLzLdPce3X09w/0Mfr2TW+OD1k+wMXuCzkzf5+eKcGfhSOVg33JUmy+iC76b4wcfpUsWbVtPL/CQa4dVsdqvv7VKMPywvmkRd6P8zh6tQ6Pl7Xicpn98f8Hg8kVbY5/cHUE1Op/MwERWJiC12UVGUDpiJiMJWg4UQ97GTXC7XXiJKWwhN2e32nT+LUkKIQ0SkWwAtEFF9fyFE1ElEX5sAy9SOohHZ7fb2X3tez4ErCiFCiqLsR7NSFKVb3kwIsWESqxy713CVZrLZbG0Oh6OXiE4LIbzSsi37FEXZbboY/7p+ArPRNUUu/+PdAAAAAElFTkSuQmCC">
									<span class="align-middle">العربية</span>
								</a>
							</li>
							<li>
								<a class="dropdown-item" href="{{url('language/en')}}" data-language="en">
									<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAADaklEQVR4nO2W20sUURzH96neooL6I4LKYLUZG2ay1VyScodFsstLTxVFD1Eh9NoFghCKCLf7DcK3cEbTwF3z8rAaWpnt2m7p7s6oaZmsbs7l+I2zrZd0b671UPSFHxx+5/zO58w5Z87vZ7H8VxrV1vauArBdtZccjrDWM9Rom/pon+V3SyiX8nhRvnf4hOcdACgcE1bYfMSNY8LUR/sEUbpTJNZtXTGQqXi+XnBIjwVRmhFEGQeON4dTgWkfHSM4ZMI75IdcmbQuJyjvrN8mOOTB+GQJywo8bx/pTi0LWnKwMU9wSF8WTbRcMHhRHqcfkBUUwBrTJD53m+IprmjQVgKuPOaOhCLRRgAbMoMJuYuENM30n7vg7Vou2Oas1+tehNqIaU5O3Ha1qruEmrTQ8I6CrUoR/07r7u6bhQOYCQ5OtIlHXoxmA6661Pla08yA3t8fVEtt3T/HWWOTLlfq8x7Z76xOTKiPnT7lIbHY1CydEHxtdIebaDMZ+ERVR19f//hLMj0d+3K+yqMw+dO0X7UX99BFALiR6mxXAwhGa592KDu5DwrHhobsxd1a71s/ftXbJOBmAOMUMFRW2kVjFWFHIPrwftuCuDEASx8ZAAyASQAeACaS6yuAliTgceqnu5EibhgAXQSzBKzYbYfiK+XYUIRjBmfbC23Oz1rnwbSdbZzddmgpmCk4Nz9ZJlsEzjIuwljPLgFT5x8Hs9Yzabc6o6XY6lSWdqtpagMwAKALGZTkcs1kCPkOwA2ATQZelbh9cemfggNDe/d0xlfKFwbpCwRC6K1tTQLu0Q0zMIchZGai5marwhd+pPHD+/Z49WCAptTkOZv+5DAM49vVKy0RNn8y/gCUFL3Rfe8/aLr5yfXE706Zj096BuuaQu2EkLlHR/f5Aupu2+ufYwvuWVJJ8/vzVIHzxQcW5k98u36thRhGtKE53GRzNmjZPJmVR5uHwurUq1++/lZNa8TGp89SCmt9MFxe5jVUVR35HPPSDJNLdrp8rcdrGCSUwLssmRRtb9/4fdrsvFjd411pPi6tfD7V0TnyDMBaSzbinPVbeFEe+w2FwCi3r35TVtBZ0cqBd8gDuYJ5UQrw5fJmS67FHi/Kj2gBt5xiTxDl+zkXewtFS1beId3NUN728g7pFj0my19f0P9T+gG2eKpch8Dw1QAAAABJRU5ErkJggg==">
									<span class="align-middle">English</span>
								</a>
							</li>
							{{-- <li>
								<a class="dropdown-item" href="{{url('lang/fr')}}" data-language="fr">
									<span class="align-middle">French</span>
								</a>
							</li>
							<li>
								<a class="dropdown-item" href="{{url('lang/de')}}" data-language="de">
									<span class="align-middle">German</span>
								</a>
							</li>
							<li>
								<a class="dropdown-item" href="{{url('lang/pt')}}" data-language="pt">
									<span class="align-middle">Portuguese</span>
								</a>
							</li> --}}
						</ul>
					</li>
					<!--/ Language -->

					<!-- Style Switcher -->
					<li class="nav-item me-1 me-xl-0">
						<a class="nav-link btn btn-text-secondary rounded-pill btn-icon style-switcher-toggle hide-arrow"
							href="javascript:void(0);">
							<i class='mdi mdi-24px'></i>
						</a>
					</li>
					<!--/ Style Switcher -->

					<!-- Quick links  -->
					<li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-1 me-xl-0">
						<a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
							href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
							aria-expanded="false">
							<i class='mdi mdi-view-grid-plus-outline mdi-24px'></i>
						</a>
						<div class="py-0 dropdown-menu dropdown-menu-end">
							<div class="dropdown-menu-header border-bottom">
								<div class="py-3 dropdown-header d-flex align-items-center">
									<h5 class="mb-0 text-body me-auto">Shortcuts</h5>
									<a href="javascript:void(0)" class="dropdown-shortcuts-add text-muted"
										data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i
											class="mdi mdi-view-grid-plus-outline mdi-24px"></i></a>
								</div>
							</div>
							<div class="dropdown-shortcuts-list scrollable-container">
								<div class="overflow-visible row row-bordered g-0">
									<div class="dropdown-shortcuts-item col">
										<span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
											<i class="mdi mdi-calendar fs-4"></i>
										</span>
										<a href="{{url('app/calendar')}}" class="stretched-link">Calendar</a>
										<small class="mb-0 text-muted">Appointments</small>
									</div>
									<div class="dropdown-shortcuts-item col">
										<span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
											<i class="mdi mdi-file-document-outline fs-4"></i>
										</span>
										<a href="{{url('app/invoice/list')}}" class="stretched-link">Invoice App</a>
										<small class="mb-0 text-muted">Manage Accounts</small>
									</div>
								</div>
								<div class="overflow-visible row row-bordered g-0">
									<div class="dropdown-shortcuts-item col">
										<span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
											<i class="mdi mdi-account-outline fs-4"></i>
										</span>
										<a href="{{url('app/user/list')}}" class="stretched-link">User App</a>
										<small class="mb-0 text-muted">Manage Users</small>
									</div>
									<div class="dropdown-shortcuts-item col">
										<span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
											<i class="mdi mdi-shield-check-outline fs-4"></i>
										</span>
										<a href="{{url('app/access-roles')}}" class="stretched-link">Role Management</a>
										<small class="mb-0 text-muted">Permission</small>
									</div>
								</div>
								<div class="overflow-visible row row-bordered g-0">
									<div class="dropdown-shortcuts-item col">
										<span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
											<i class="mdi mdi-chart-pie-outline fs-4"></i>
										</span>
										<a href="{{url('/')}}" class="stretched-link">Dashboard</a>
										<small class="mb-0 text-muted">User Profile</small>
									</div>
									<div class="dropdown-shortcuts-item col">
										<span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
											<i class="mdi mdi-cog-outline fs-4"></i>
										</span>
										<a href="{{url('pages/account-settings-account')}}"
											class="stretched-link">Setting</a>
										<small class="mb-0 text-muted">Account Settings</small>
									</div>
								</div>
								<div class="overflow-visible row row-bordered g-0">
									<div class="dropdown-shortcuts-item col">
										<span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
											<i class="mdi mdi-help-circle-outline fs-4"></i>
										</span>
										<a href="{{url('pages/help-center-landing')}}" class="stretched-link">Help
											Center</a>
										<small class="mb-0 text-muted">FAQs & Articles</small>
									</div>
									<div class="dropdown-shortcuts-item col">
										<span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
											<i class="mdi mdi-dock-window fs-4"></i>
										</span>
										<a href="{{url('modal-examples')}}" class="stretched-link">Modals</a>
										<small class="mb-0 text-muted">Useful Popups</small>
									</div>
								</div>
							</div>
						</div>
					</li>
					<!-- Quick links -->

					<!-- Notification -->
					<li class="nav-item dropdown-notifications navbar-dropdown dropdown me-2 me-xl-1">
						<a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
							href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
							aria-expanded="false">
							<i class="mdi mdi-bell-outline mdi-24px"></i>
							<span
								class="top-0 mt-2 border position-absolute start-50 translate-middle-y badge badge-dot bg-danger"></span>
						</a>
						<ul class="py-0 dropdown-menu dropdown-menu-end">
							<li class="dropdown-menu-header border-bottom">
								<div class="py-3 dropdown-header d-flex align-items-center">
									<h6 class="mb-0 me-auto">Notification</h6>
									<span class="badge rounded-pill bg-label-primary">8 New</span>
								</div>
							</li>
							<li class="dropdown-notifications-list scrollable-container">
								<ul class="list-group list-group-flush">
									<li class="list-group-item list-group-item-action dropdown-notifications-item">
										<div class="gap-2 d-flex">
											<div class="flex-shrink-0">
												<div class="avatar me-1">
													<img src="{{ asset('assets/img/avatars/1.png') }}" alt
														class="h-auto w-px-40 rounded-circle">
												</div>
											</div>
											<div class="overflow-hidden d-flex flex-column flex-grow-1 w-px-200">
												<h6 class="mb-1 text-truncate">Congratulation Lettie 🎉</h6>
												<small class="text-truncate text-body">Won the monthly best seller gold
													badge</small>
											</div>
											<div class="flex-shrink-0 dropdown-notifications-actions">
												<small class="text-muted">1h ago</small>
											</div>
										</div>
									</li>
									<li class="list-group-item list-group-item-action dropdown-notifications-item">
										<div class="gap-2 d-flex">
											<div class="flex-shrink-0">
												<div class="avatar me-1">
													<span
														class="avatar-initial rounded-circle bg-label-danger">CF</span>
												</div>
											</div>
											<div class="overflow-hidden d-flex flex-column flex-grow-1 w-px-200">
												<h6 class="mb-1 text-truncate">Charles Franklin</h6>
												<small class="text-truncate text-body">Accepted your connection</small>
											</div>
											<div class="flex-shrink-0 dropdown-notifications-actions">
												<small class="text-muted">12hr ago</small>
											</div>
										</div>
									</li>
									<li
										class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
										<div class="gap-2 d-flex">
											<div class="flex-shrink-0">
												<div class="avatar me-1">
													<img src="{{ asset('assets/img/avatars/2.png') }}" alt
														class="h-auto rounded-circle">
												</div>
											</div>
											<div class="overflow-hidden d-flex flex-column flex-grow-1 w-px-200">
												<h6 class="mb-1 text-truncate">New Message ✉️</h6>
												<small class="text-truncate text-body">You have new message from
													Natalie</small>
											</div>
											<div class="flex-shrink-0 dropdown-notifications-actions">
												<small class="text-muted">1h ago</small>
											</div>
										</div>
									</li>
									<li class="list-group-item list-group-item-action dropdown-notifications-item">
										<div class="gap-2 d-flex">
											<div class="flex-shrink-0">
												<div class="avatar me-1">
													<span class="avatar-initial rounded-circle bg-label-success"><i
															class="mdi mdi-cart-outline"></i></span>
												</div>
											</div>
											<div class="overflow-hidden d-flex flex-column flex-grow-1 w-px-200">
												<h6 class="mb-1 text-truncate">Whoo! You have new order 🛒 </h6>
												<small class="text-truncate text-body">ACME Inc. made new order
													$1,154</small>
											</div>
											<div class="flex-shrink-0 dropdown-notifications-actions">
												<small class="text-muted">1 day ago</small>
											</div>
										</div>
									</li>
									<li
										class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
										<div class="gap-2 d-flex">
											<div class="flex-shrink-0">
												<div class="avatar me-1">
													<img src="{{ asset('assets/img/avatars/9.png') }}" alt
														class="h-auto w-px-40 rounded-circle">
												</div>
											</div>
											<div class="overflow-hidden d-flex flex-column flex-grow-1 w-px-200">
												<h6 class="mb-1 text-truncate">Application has been approved 🚀 </h6>
												<small class="text-truncate text-body">Your ABC project application has
													been approved.</small>
											</div>
											<div class="flex-shrink-0 dropdown-notifications-actions">
												<small class="text-muted">2 days ago</small>
											</div>
										</div>
									</li>
									<li
										class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
										<div class="gap-2 d-flex">
											<div class="flex-shrink-0">
												<div class="avatar me-1">
													<span class="avatar-initial rounded-circle bg-label-success"><i
															class="mdi mdi-chart-pie-outline"></i></span>
												</div>
											</div>
											<div class="overflow-hidden d-flex flex-column flex-grow-1 w-px-200">
												<h6 class="mb-1 text-truncate">Monthly report is generated</h6>
												<small class="text-truncate text-body">July monthly financial report is
													generated </small>
											</div>
											<div class="flex-shrink-0 dropdown-notifications-actions">
												<small class="text-muted">3 days ago</small>
											</div>
										</div>
									</li>
									<li
										class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
										<div class="gap-2 d-flex">
											<div class="flex-shrink-0">
												<div class="avatar me-1">
													<img src="{{ asset('assets/img/avatars/5.png') }}" alt
														class="h-auto rounded-circle">
												</div>
											</div>
											<div class="overflow-hidden d-flex flex-column flex-grow-1 w-px-200">
												<h6 class="mb-1 text-truncate">Send connection request</h6>
												<small class="text-truncate text-body">Peter sent you connection
													request</small>
											</div>
											<div class="flex-shrink-0 dropdown-notifications-actions">
												<small class="text-muted">4 days ago</small>
											</div>
										</div>
									</li>
									<li class="list-group-item list-group-item-action dropdown-notifications-item">
										<div class="gap-2 d-flex">
											<div class="flex-shrink-0">
												<div class="avatar me-1">
													<img src="{{ asset('assets/img/avatars/6.png') }}" alt
														class="h-auto rounded-circle">
												</div>
											</div>
											<div class="overflow-hidden d-flex flex-column flex-grow-1 w-px-200">
												<h6 class="mb-1 text-truncate">New message from Jane</h6>
												<small class="text-truncate text-body">Your have new message from
													Jane</small>
											</div>
											<div class="flex-shrink-0 dropdown-notifications-actions">
												<small class="text-muted">5 days ago</small>
											</div>
										</div>
									</li>
									<li
										class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
										<div class="gap-2 d-flex">
											<div class="flex-shrink-0">
												<div class="avatar me-1">
													<span class="avatar-initial rounded-circle bg-label-warning"><i
															class="mdi mdi-alert-circle-outline"></i></span>
												</div>
											</div>
											<div class="overflow-hidden d-flex flex-column flex-grow-1 w-px-200">
												<h6 class="mb-1">CPU is running high</h6>
												<small class="text-truncate text-body">CPU Utilization Percent is
													currently at 88.63%,</small>
											</div>
											<div class="flex-shrink-0 dropdown-notifications-actions">
												<small class="text-muted">5 days ago</small>
											</div>
										</div>
									</li>
								</ul>
							</li>
							<li class="p-2 dropdown-menu-footer border-top">
								<a href="javascript:void(0);" class="btn btn-primary d-flex justify-content-center">
									View all notifications
								</a>
							</li>
						</ul>
					</li>
					<!--/ Notification -->

					<!-- User -->
					<li class="nav-item navbar-dropdown dropdown-user dropdown">
						<a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
							data-bs-toggle="dropdown">
							<div class="avatar avatar-online">
								<img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}"
									alt class="h-auto w-px-40 rounded-circle">
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li>
								<a class="dropdown-item"
									{{--href="{{ Route::has('profile.show') ? route('profile.show') : url('pages/profile-user') }}"--}}>
									<div class="d-flex">
										<div class="flex-shrink-0 me-3">
											<div class="avatar avatar-online">
												<img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}"
													alt class="h-auto w-px-40 rounded-circle">
											</div>
										</div>
										<div class="text-center flex-grow-1">
											<span class="fw-semibold d-block">
												@if (Auth::check())
													<div>{{ Auth::user()->name }}</div>
													<div>{{ Auth::user()->email }}</div>
													<div>
														@php
															$roles_count = count(Auth::user()->getRoleNames());
															$i = 0;
															$disease = '';
														@endphp
														@foreach(Auth::user()->getRoleNames() as $roles)
															<?php $coma = ''; $i++; if($i < $roles_count) { $coma = ' , '; } ?>
															{{$roles .$coma }}
														@endforeach
													</div>
												@else
													John Doe
												@endif
											</span>
										</div>
									</div>
								</a>
							</li>
							<li>
								<div class="dropdown-divider"></div>
							</li>
							<li>
								<a class="dropdown-item"
									{{--href="{{ Route::has('profile.show') ? route('profile.show') : url('pages/profile-user') }}"--}}>
									<i class="mdi mdi-account-outline me-2"></i>
									<span class="align-middle">My Profile</span>
								</a>
							</li>
							@if (Auth::check() && Laravel\Jetstream\Jetstream::hasApiFeatures())
							<li>
								<a class="dropdown-item" href="{{ route('api-tokens.index') }}">
									<i class='mdi mdi-key-outline me-2'></i>
									<span class="align-middle">API Tokens</span>
								</a>
							</li>
							@endif
							<li>
								<a class="dropdown-item" href="{{url('app/invoice/list')}}">
									<i class="mdi mdi-credit-card-outline me-2"></i>
									<span class="align-middle">Billing</span>
								</a>
							</li>
							@if (Auth::User() && Laravel\Jetstream\Jetstream::hasTeamFeatures())
								<li>
									<div class="dropdown-divider"></div>
								</li>
								<li>
									<h6 class="dropdown-header">Manage Team</h6>
								</li>
								<li>
									<div class="dropdown-divider"></div>
								</li>
								<li>
									<a class="dropdown-item"
										href="{{ Auth::user() ? route('teams.show', Auth::user()->currentTeam->id) : 'javascript:void(0)' }}">
										<i class='mdi mdi-cog-outline me-2'></i>
										<span class="align-middle">Team Settings</span>
									</a>
								</li>
								@can('create', Laravel\Jetstream\Jetstream::newTeamModel())
									<li>
										<a class="dropdown-item" href="{{ route('teams.create') }}">
											<i class='mdi mdi-account-outline me-2'></i>
											<span class="align-middle">Create New Team</span>
										</a>
									</li>
								@endcan
								<li>
									<div class="dropdown-divider"></div>
								</li>
								<lI>
									<h6 class="dropdown-header">Switch Teams</h6>
								</lI>
								<li>
									<div class="dropdown-divider"></div>
								</li>
								@if (Auth::user())
									@foreach (Auth::user()->allTeams() as $team)
										{{-- Below commented code read by artisan command while installing jetstream. !! Do not
										remove if you want
										to use jetstream. --}}

										{{--
										<x-switchable-team :team="$team" /> --}}
									@endforeach
								@endif
							@endif
							<li>
								<div class="dropdown-divider"></div>
							</li>
							@if (Auth::check())
								<li>
									<a class="dropdown-item" href="{{ route('logout') }}"
										onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
										<i class='mdi mdi-logout me-2'></i>
										<span class="align-middle">Logout</span>
									</a>
								</li>
								<form method="POST" id="logout-form" action="{{ route('logout') }}">
									@csrf
								</form>
							@else
								<li>
									<a class="dropdown-item"
										href="{{ Route::has('login') ? route('login') : url('auth/login-basic') }}">
										<i class='mdi mdi-login me-2'></i>
										<span class="align-middle">Login</span>
									</a>
								</li>
							@endif
						</ul>
					</li>
					<!--/ User -->
				</ul>
			</div>

			<!-- Search Small Screens -->
			{{-- <div class="navbar-search-wrapper search-input-wrapper {{ isset($menuHorizontal) ? $containerNav : '' }} d-none">
				<input type="text"
					class="form-control search-input {{ isset($menuHorizontal) ? '' : $containerNav }} border-0"
					placeholder="Search..." aria-label="Search...">
				<i class="cursor-pointer mdi mdi-close search-toggler"></i>
			</div> --}}
			@if(!isset($navbarDetached))
		</div>
		@endif
	</nav>
	<!-- / Navbar -->
