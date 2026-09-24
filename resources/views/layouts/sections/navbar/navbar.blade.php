@php
    $containerNav = $containerNav ?? 'container-xxl';
    $navbarDetached = $navbarDetached ?? '';
@endphp

<!-- Navbar -->
@if (isset($navbarDetached) && $navbarDetached == 'navbar-detached')
    <nav class="layout-navbar {{ $containerNav }} navbar navbar-expand-xl {{ $navbarDetached }} align-items-center bg-navbar-theme"
        id="layout-navbar">
@endif
@if (isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="{{ $containerNav }}">
@endif

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
@if (isset($navbarFull))
    <div class="py-0 navbar-brand app-brand demo d-none d-xl-flex me-4">
        <a href="{{ url('/') }}" class="gap-2 app-brand-link">
            <span class="app-brand-logo demo">
                @include('_partials.macros', ['width' => 25, 'withbg' => '#666cff'])
            </span>
            <span class="app-brand-text demo menu-text fw-bold">{{ config('variables.templateName') }}</span>
        </a>
    </div>
@endif

<!-- ! Not required for layout-without-menu -->
@if (!isset($navbarHideToggle))
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
        <a class="px-0 nav-item nav-link me-xl-4" href="javascript:void(0)">
            <i class="mdi mdi-menu mdi-24px"></i>
        </a>
    </div>
@endif

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

    {{-- @if (!isset($menuHorizontal))
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
        {{-- @if (isset($menuHorizontal))
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
                    <img
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAACT0lEQVR4nO2Wy2sTURjFD2j/AB/1D3BrrcWUtkJgcj9i1u6EEkQ32YmvFHHTRRoaRRBRCoJB0xS0ClUKdlXFGrWK1BqamZRIrWlihSbpJAN1m09usKWSZJrHBAU9cJjLfcxvvnPvMAP8l4nmgLY4cEwFzmjAgLRsx4E+OQarpQI9KjCqAT80gKt4QwNCC0B308AocEAFxlSgaAL8zXKuCoQ/A+2NVtmlASu1Ais8QHIB6KwLGgc6NEBvFLoNXogBR2qF7lOBb81Ctzm1AOypJeIxC6GbDplC5Z7Uc5DqjL2rKjg5fDWQHByMtMSBa8MVocy8K6sb67m8wa1wVjd0ySgD53JGX6ugWzaM3nKwbpyqZfEzdZYTq6lSe3z+RemazmZ4dinGI2+eckbPm1XtLgNn88aAGXBtPc8T0Vf8eP4lzyQ+ceJ7mm/MPCqNvf+i8eWpO3x+8pZ53HnDWwnsrbZgaHqU3eNDfCJ8hY8HLzLdPce3X09w/0Mfr2TW+OD1k+wMXuCzkzf5+eKcGfhSOVg33JUmy+iC76b4wcfpUsWbVtPL/CQa4dVsdqvv7VKMPywvmkRd6P8zh6tQ6Pl7Xicpn98f8Hg8kVbY5/cHUE1Op/MwERWJiC12UVGUDpiJiMJWg4UQ97GTXC7XXiJKWwhN2e32nT+LUkKIQ0SkWwAtEFF9fyFE1ElEX5sAy9SOohHZ7fb2X3tez4ErCiFCiqLsR7NSFKVb3kwIsWESqxy713CVZrLZbG0Oh6OXiE4LIbzSsi37FEXZbboY/7p+ArPRNUUu/+PdAAAAAElFTkSuQmCC">
                @else
                    <img
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAADaklEQVR4nO2W20sUURzH96neooL6I4LKYLUZG2ay1VyScodFsstLTxVFD1Eh9NoFghCKCLf7DcK3cEbTwF3z8rAaWpnt2m7p7s6oaZmsbs7l+I2zrZd0b671UPSFHxx+5/zO58w5Z87vZ7H8VxrV1vauArBdtZccjrDWM9Rom/pon+V3SyiX8nhRvnf4hOcdACgcE1bYfMSNY8LUR/sEUbpTJNZtXTGQqXi+XnBIjwVRmhFEGQeON4dTgWkfHSM4ZMI75IdcmbQuJyjvrN8mOOTB+GQJywo8bx/pTi0LWnKwMU9wSF8WTbRcMHhRHqcfkBUUwBrTJD53m+IprmjQVgKuPOaOhCLRRgAbMoMJuYuENM30n7vg7Vou2Oas1+tehNqIaU5O3Ha1qruEmrTQ8I6CrUoR/07r7u6bhQOYCQ5OtIlHXoxmA6661Pla08yA3t8fVEtt3T/HWWOTLlfq8x7Z76xOTKiPnT7lIbHY1CydEHxtdIebaDMZ+ERVR19f//hLMj0d+3K+yqMw+dO0X7UX99BFALiR6mxXAwhGa592KDu5DwrHhobsxd1a71s/ftXbJOBmAOMUMFRW2kVjFWFHIPrwftuCuDEASx8ZAAyASQAeACaS6yuAliTgceqnu5EibhgAXQSzBKzYbYfiK+XYUIRjBmfbC23Oz1rnwbSdbZzddmgpmCk4Nz9ZJlsEzjIuwljPLgFT5x8Hs9Yzabc6o6XY6lSWdqtpagMwAKALGZTkcs1kCPkOwA2ATQZelbh9cemfggNDe/d0xlfKFwbpCwRC6K1tTQLu0Q0zMIchZGai5marwhd+pPHD+/Z49WCAptTkOZv+5DAM49vVKy0RNn8y/gCUFL3Rfe8/aLr5yfXE706Zj096BuuaQu2EkLlHR/f5Aupu2+ufYwvuWVJJ8/vzVIHzxQcW5k98u36thRhGtKE53GRzNmjZPJmVR5uHwurUq1++/lZNa8TGp89SCmt9MFxe5jVUVR35HPPSDJNLdrp8rcdrGCSUwLssmRRtb9/4fdrsvFjd411pPi6tfD7V0TnyDMBaSzbinPVbeFEe+w2FwCi3r35TVtBZ0cqBd8gDuYJ5UQrw5fJmS67FHi/Kj2gBt5xiTxDl+zkXewtFS1beId3NUN728g7pFj0my19f0P9T+gG2eKpch8Dw1QAAAABJRU5ErkJggg==">
                @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ url('language/ar') }}" data-language="ar" class="active">
                        <img
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAACT0lEQVR4nO2Wy2sTURjFD2j/AB/1D3BrrcWUtkJgcj9i1u6EEkQ32YmvFHHTRRoaRRBRCoJB0xS0ClUKdlXFGrWK1BqamZRIrWlihSbpJAN1m09usKWSZJrHBAU9cJjLfcxvvnPvMAP8l4nmgLY4cEwFzmjAgLRsx4E+OQarpQI9KjCqAT80gKt4QwNCC0B308AocEAFxlSgaAL8zXKuCoQ/A+2NVtmlASu1Ais8QHIB6KwLGgc6NEBvFLoNXogBR2qF7lOBb81Ctzm1AOypJeIxC6GbDplC5Z7Uc5DqjL2rKjg5fDWQHByMtMSBa8MVocy8K6sb67m8wa1wVjd0ySgD53JGX6ugWzaM3nKwbpyqZfEzdZYTq6lSe3z+RemazmZ4dinGI2+eckbPm1XtLgNn88aAGXBtPc8T0Vf8eP4lzyQ+ceJ7mm/MPCqNvf+i8eWpO3x+8pZ53HnDWwnsrbZgaHqU3eNDfCJ8hY8HLzLdPce3X09w/0Mfr2TW+OD1k+wMXuCzkzf5+eKcGfhSOVg33JUmy+iC76b4wcfpUsWbVtPL/CQa4dVsdqvv7VKMPywvmkRd6P8zh6tQ6Pl7Xicpn98f8Hg8kVbY5/cHUE1Op/MwERWJiC12UVGUDpiJiMJWg4UQ97GTXC7XXiJKWwhN2e32nT+LUkKIQ0SkWwAtEFF9fyFE1ElEX5sAy9SOohHZ7fb2X3tez4ErCiFCiqLsR7NSFKVb3kwIsWESqxy713CVZrLZbG0Oh6OXiE4LIbzSsi37FEXZbboY/7p+ArPRNUUu/+PdAAAAAElFTkSuQmCC">
                        <span class="align-middle">العربية</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ url('language/en') }}" data-language="en">
                        <img
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAADaklEQVR4nO2W20sUURzH96neooL6I4LKYLUZG2ay1VyScodFsstLTxVFD1Eh9NoFghCKCLf7DcK3cEbTwF3z8rAaWpnt2m7p7s6oaZmsbs7l+I2zrZd0b671UPSFHxx+5/zO58w5Z87vZ7H8VxrV1vauArBdtZccjrDWM9Rom/pon+V3SyiX8nhRvnf4hOcdACgcE1bYfMSNY8LUR/sEUbpTJNZtXTGQqXi+XnBIjwVRmhFEGQeON4dTgWkfHSM4ZMI75IdcmbQuJyjvrN8mOOTB+GQJywo8bx/pTi0LWnKwMU9wSF8WTbRcMHhRHqcfkBUUwBrTJD53m+IprmjQVgKuPOaOhCLRRgAbMoMJuYuENM30n7vg7Vou2Oas1+tehNqIaU5O3Ha1qruEmrTQ8I6CrUoR/07r7u6bhQOYCQ5OtIlHXoxmA6661Pla08yA3t8fVEtt3T/HWWOTLlfq8x7Z76xOTKiPnT7lIbHY1CydEHxtdIebaDMZ+ERVR19f//hLMj0d+3K+yqMw+dO0X7UX99BFALiR6mxXAwhGa592KDu5DwrHhobsxd1a71s/ftXbJOBmAOMUMFRW2kVjFWFHIPrwftuCuDEASx8ZAAyASQAeACaS6yuAliTgceqnu5EibhgAXQSzBKzYbYfiK+XYUIRjBmfbC23Oz1rnwbSdbZzddmgpmCk4Nz9ZJlsEzjIuwljPLgFT5x8Hs9Yzabc6o6XY6lSWdqtpagMwAKALGZTkcs1kCPkOwA2ATQZelbh9cemfggNDe/d0xlfKFwbpCwRC6K1tTQLu0Q0zMIchZGai5marwhd+pPHD+/Z49WCAptTkOZv+5DAM49vVKy0RNn8y/gCUFL3Rfe8/aLr5yfXE706Zj096BuuaQu2EkLlHR/f5Aupu2+ufYwvuWVJJ8/vzVIHzxQcW5k98u36thRhGtKE53GRzNmjZPJmVR5uHwurUq1++/lZNa8TGp89SCmt9MFxe5jVUVR35HPPSDJNLdrp8rcdrGCSUwLssmRRtb9/4fdrsvFjd411pPi6tfD7V0TnyDMBaSzbinPVbeFEe+w2FwCi3r35TVtBZ0cqBd8gDuYJ5UQrw5fJmS67FHi/Kj2gBt5xiTxDl+zkXewtFS1beId3NUN728g7pFj0my19f0P9T+gG2eKpch8Dw1QAAAABJRU5ErkJggg==">
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
                href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                <i class='mdi mdi-view-grid-plus-outline mdi-24px'></i>
            </a>
            <div class="py-0 dropdown-menu dropdown-menu-end">
                <div class="dropdown-menu-header border-bottom">
                    <div class="py-3 dropdown-header d-flex align-items-center">
                        <h5 class="mb-0 text-body me-auto">اختصارات الصفحات</h5>
                        <a href="javascript:void(0)" class="dropdown-shortcuts-add text-muted" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Add shortcuts"><i
                                class="mdi mdi-view-grid-plus-outline mdi-24px"></i></a>
                    </div>
                </div>
                <div class="dropdown-shortcuts-list scrollable-container">
                    <div class="overflow-visible row row-bordered g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
                                <i class="mdi mdi-home-outline fs-4"></i>
                            </span>
                            <a href="{{ url('/') }}" class="stretched-link">لوحة المتابعة</a>
                            <small class="mb-0 text-muted">ملف المستخدم</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
                                <i class="mdi mdi-file-import-outline fs-4"></i>
                            </span>
                            <a href="{{ route('Incomingbooks') }}" class="stretched-link">ادارة المخاطبات</a>
                            <small class="mb-0 text-muted">الوارد والصادر</small>
                        </div>
                    </div>
                    <div class="overflow-visible row row-bordered g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
                                <i class="mdi mdi-domain fs-4"></i>
                            </span>
                            <a href="{{ route('Sections') }}" class="stretched-link">الأقسام</a>
                            <small class="mb-0 text-muted">إدارة الأقسام</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
                                <i class="mdi mdi-office-building fs-4"></i>
                            </span>
                            <a href="{{ route('Departments') }}" class="stretched-link">الدوائر</a>
                            <small class="mb-0 text-muted">إدارة الدوائر</small>
                        </div>
                    </div>

                    <div class="overflow-visible row row-bordered g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
                                <i class="mdi mdi-file-chart-outline fs-4"></i>
                            </span>
                            <a href="{{ route('Reports') }}" class="stretched-link">التقارير</a>
                            <small class="mb-0 text-muted">انشاء وتصدير</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
                                <i class="mdi mdi-email-outline fs-4"></i>
                            </span>
                            <a href="{{ route('Emaillists') }}" class="stretched-link">البريد الإلكتروني</a>
                            <small class="mb-0 text-muted">للاقسام والدوائر</small>
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
                                        <span class="avatar-initial rounded-circle bg-label-danger">CF</span>
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
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
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
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
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
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
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
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
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
                        <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
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
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="{{ Auth::user() ? Auth::user()->profile_photo_url : asset('assets/img/avatars/1.png') }}"
                        alt class="h-auto w-px-40 rounded-circle">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" {{-- href="{{ Route::has('profile.show') ? route('profile.show') : url('pages/profile-user') }}" --}}>
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
                                            @foreach (Auth::user()->getRoleNames() as $roles)
                                                <?php $coma = '';
                                                $i++;
                                                if ($i < $roles_count) {
                                                    $coma = ' , ';
                                                } ?>
                                                {{ $roles . $coma }}
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
                    <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('two-factor.setup') }}">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-shield-key-outline me-2 text-primary fs-5"></i>
                            <span class="align-middle fw-semibold">إعداد تطبيق المصادقة (TOTP)</span>
                        </div>
                        @if (Auth::check() && Auth::user()->hasTotpSetup())
                            <span class="badge bg-success ms-2" style="font-size: 0.72rem;">مفعل</span>
                        @else
                            <span class="badge bg-secondary ms-2" style="font-size: 0.72rem;">غير مفعل</span>
                        @endif
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
                {{--  <li>
                    <a class="dropdown-item" href="{{ url('app/invoice/list') }}">
                        <i class="mdi mdi-credit-card-outline me-2"></i>
                        <span class="align-middle">Billing</span>
                    </a>
                </li> --}}
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
                            <span class="align-middle">تسجيل خروج</span>
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
                            <span class="align-middle">تسجيل دخول</span>
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
@if (!isset($navbarDetached))
    </div>
@endif
</nav>
<!-- / Navbar -->


<!-- نافذة مودال إضافة الاختصار -->
<div class="modal fade" id="addShortcutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="p-4 modal-content p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-md-0">
                <div class="mb-4 text-center mt-n4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold mb-2">
                            <span class="text-primary">إضافة</span> اختصار جديد
                        </h3>
                        <p class="text-muted">
                            <i class="mdi mdi-link-variant me-1"></i>
                            قم بإدخال تفاصيل الاختصار في النموذج أدناه
                        </p>
                    </div>
                </div>
                <hr class="mt-n2">
                <form id="addShortcutForm" autocomplete="off">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="shortcutTitle" placeholder="اسم الاختصار"
                                    class="form-control" />
                                <label for="shortcutTitle">اسم الاختصار</label>
                            </div>
                            <small id="titleError" class='text-danger d-none'>يجب إدخال اسم الاختصار</small>
                        </div>

                        <div class="mb-3 col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="shortcutCategory" placeholder="اسم الفئة"
                                    class="form-control" /> <label for="shortcutCategory">اسم
                                    الفئة (مثال: تطبيقات، أدوات)</label>
                            </div>
                            <small id="categoryError" class='text-danger d-none'>يجب إدخال اسم الفئة</small>
                        </div>
                        <div class="mb-3 col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="shortcutLink" placeholder="رابط الصفحة"
                                    class="form-control" />
                                <label for="shortcutLink">رابط الصفحة (مثال: /my-page)</label>
                            </div>
                            <small id="linkError" class='text-danger d-none'>يجب إدخال رابط صحيح</small>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">اختر أيقونة</label>
                            <div class="d-flex flex-wrap gap-2 icon-selector">
                                <div class="icon-option" data-icon="mdi mdi-email-outline" title="بريد إلكتروني">
                                    <i class="mdi mdi-email-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-file-chart-outline" title="تقارير">
                                    <i class="mdi mdi-file-chart-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-domain" title="قسم">
                                    <i class="mdi mdi-domain mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-office-building" title="دائرة">
                                    <i class="mdi mdi-office-building mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-view-dashboard-outline"
                                    title="لوحة تحكم">
                                    <i class="mdi mdi-view-dashboard-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-account-outline" title="ملف شخصي">
                                    <i class="mdi mdi-account-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-cog-outline" title="إعدادات">
                                    <i class="mdi mdi-cog-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-calendar-blank-outline" title="تقويم">
                                    <i class="mdi mdi-calendar-blank-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-file-import-outline" title="مخاطبة">
                                    <i class="mdi mdi-file-import-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-home-outline" title="الرئيسية">
                                    <i class="mdi mdi-home-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-information-outline" title="معلومات">
                                    <i class="mdi mdi-information-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-help-circle-outline" title="مساعدة">
                                    <i class="mdi mdi-help-circle-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-chart-line" title="رسوم بيانية">
                                    <i class="mdi mdi-chart-line mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-home-outline" title="الرئيسية">
                                    <i class="mdi mdi-home-outline mdi-24px"></i>
                                </div>
                            </div>
                            <input type="hidden" id="shortcutIcon" value="mdi mdi-star-outline">
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="text-center col-12 demo-vertical-spacing mb-n4">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">إضافة</button>
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- نافذة مودال تعديل الاختصار -->
<div class="modal fade" id="editShortcutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="p-4 modal-content p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-md-0">
                <div class="mb-4 text-center mt-n4">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold mb-2">
                            <span class="text-warning">تعديل</span> الاختصار
                        </h3>
                        <p class="text-muted">
                            <i class="mdi mdi-pencil-outline me-1"></i>
                            قم بتعديل تفاصيل الاختصار في النموذج أدناه
                        </p>
                    </div>
                </div>
                <hr class="mt-n2">
                <form id="editShortcutForm" autocomplete="off">
                    <div class="row">
                        <div class="mb-3 col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="editShortcutTitle" placeholder="اسم الاختصار"
                                    class="form-control" />
                                <label for="editShortcutTitle">اسم الاختصار</label>
                            </div>
                            <small id="editTitleError" class='text-danger d-none'>يجب إدخال اسم الاختصار</small>
                        </div>
                        <div class="mb-3 col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="editShortcutCategory" placeholder="اسم الفئة"
                                    class="form-control" />
                                <label for="editShortcutCategory">اسم الفئة (مثال: تطبيقات، أدوات)</label>
                            </div>
                            <small id="editCategoryError" class='text-danger d-none'>يجب إدخال اسم الفئة</small>
                        </div>
                        <div class="mb-3 col-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="editShortcutLink" placeholder="رابط الصفحة"
                                    class="form-control" />
                                <label for="editShortcutLink">رابط الصفحة (مثال: /my-page)</label>
                            </div>
                            <small id="editLinkError" class='text-danger d-none'>يجب إدخال رابط صحيح</small>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label">اختر أيقونة</label>
                            <div class="d-flex flex-wrap gap-2 icon-selector">
                                <div class="icon-option" data-icon="mdi mdi-email-outline" title="بريد إلكتروني">
                                    <i class="mdi mdi-email-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-file-chart-outline" title="تقارير">
                                    <i class="mdi mdi-file-chart-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-domain" title="قسم">
                                    <i class="mdi mdi-domain mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-office-building" title="دائرة">
                                    <i class="mdi mdi-office-building mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-view-dashboard-outline"
                                    title="لوحة تحكم">
                                    <i class="mdi mdi-view-dashboard-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-account-outline" title="ملف شخصي">
                                    <i class="mdi mdi-account-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-cog-outline" title="إعدادات">
                                    <i class="mdi mdi-cog-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-calendar-blank-outline" title="تقويم">
                                    <i class="mdi mdi-calendar-blank-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-file-import-outline" title="مخاطبة">
                                    <i class="mdi mdi-file-import-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-home-outline" title="الرئيسية">
                                    <i class="mdi mdi-home-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-information-outline" title="معلومات">
                                    <i class="mdi mdi-information-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-help-circle-outline" title="مساعدة">
                                    <i class="mdi mdi-help-circle-outline mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-chart-line" title="رسوم بيانية">
                                    <i class="mdi mdi-chart-line mdi-24px"></i>
                                </div>
                                <div class="icon-option" data-icon="mdi mdi-home-outline" title="الرئيسية">
                                    <i class="mdi mdi-home-outline mdi-24px"></i>
                                </div>
                            </div>
                            <input type="hidden" id="editShortcutIcon" value="mdi mdi-star-outline">
                        </div>
                    </div>
                    <input type="hidden" id="editShortcutIndex">
                    <hr class="my-0">
                    <div class="text-center col-12 demo-vertical-spacing mb-n4">
                        <button type="submit" class="btn btn-warning me-sm-3 me-1">تعديل</button>
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">تجاهل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- نافذة مودال تأكيد الحذف -->
<div wire:ignore.self class="modal fade" id="deleteShortcutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="p-4 modal-content p-md-5">
            <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body p-md-0">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-2">
                        <span class="text-danger">حذف</span> الاختصار
                    </h3>
                    <p class="text-muted">
                        <i class="mdi mdi-delete-outline me-1"></i>
                        هل أنت متأكد من حذف هذا الاختصار؟
                    </p>
                </div>
                <hr class="mt-n2">
                <form id="deleteShortcutModalForm" onsubmit="return false" autocomplete="off">
                    <div class="row">
                        <div class="col text-center">
                            <div class="text-danger">
                                <label for="shortcutToDelete">الاختصار</label>
                                <div class="form-control-plaintext mt-n2" id="shortcutToDeleteTitle"></div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="d-flex justify-content-center col-12 demo-vertical-spacing mb-n4">
                        <button type="button" id="confirmDeleteBtn"
                            class="flex-fill btn btn-danger me-sm-3 me-1">حذف</button>
                        <button type="button" class="flex-fill btn btn-outline-secondary"
                            data-bs-dismiss="modal">تجاهل</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const addShortcutBtn = document.querySelector('.dropdown-shortcuts-add');
        const shortcutsContainer = document.querySelector('.dropdown-shortcuts-list');
        const staticShortcuts = document.querySelectorAll('.dropdown-shortcuts-list > div');
        const addShortcutModal = new bootstrap.Modal(document.getElementById('addShortcutModal'));
        const addShortcutForm = document.getElementById('addShortcutForm');
        const editShortcutModal = new bootstrap.Modal(document.getElementById('editShortcutModal'));
        const editShortcutForm = document.getElementById('editShortcutForm');
        const deleteShortcutModal = new bootstrap.Modal(document.getElementById('deleteShortcutModal'));
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

        let savedShortcuts = JSON.parse(localStorage.getItem('customShortcuts')) || [];
        let draggedItem = null;

        // عرض الاختصارات الثابتة والمخصصة
        renderShortcuts();

        // فتح مودال الإضافة
        addShortcutBtn.addEventListener('click', function() {
            addShortcutModal.show();
        });

        // معالجة إرسال نموذج الإضافة
        addShortcutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleShortcutFormSubmit('add');
        });

        // معالجة إرسال نموذج التعديل
        editShortcutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleShortcutFormSubmit('edit');
        });

        // تفعيل اختيار الأيقونة في مودال الإضافة
        document.querySelectorAll('#addShortcutModal .icon-option').forEach(icon => {
            icon.addEventListener('click', function() {
                document.querySelectorAll('#addShortcutModal .icon-option').forEach(i => {
                    i.classList.remove('selected');
                });
                this.classList.add('selected');
                document.getElementById('shortcutIcon').value = this.dataset.icon;
            });
        });

        // تفعيل اختيار الأيقونة في مودال التعديل
        document.querySelectorAll('#editShortcutModal .icon-option').forEach(icon => {
            icon.addEventListener('click', function() {
                document.querySelectorAll('#editShortcutModal .icon-option').forEach(i => {
                    i.classList.remove('selected');
                });
                this.classList.add('selected');
                document.getElementById('editShortcutIcon').value = this.dataset
                    .icon; // تم تصحيح المعرف هنا
            });
        });


        // دالة عامة لمعالجة النماذج
        function handleShortcutFormSubmit(mode) {
            const form = mode === 'add' ? addShortcutForm : editShortcutForm;
            const title = mode === 'add' ?
                document.getElementById('shortcutTitle').value.trim() :
                document.getElementById('editShortcutTitle').value.trim();
            const link = mode === 'add' ?
                document.getElementById('shortcutLink').value.trim() :
                document.getElementById('editShortcutLink').value.trim();
            const icon = mode === 'add' ?
                document.getElementById('shortcutIcon').value :
                document.getElementById('editShortcutIcon').value;
            // **الجزء الجديد: جلب قيمة الفئة**
            const category = mode === 'add' ?
                document.getElementById('shortcutCategory').value.trim() :
                document.getElementById('editShortcutCategory').value.trim();

            // التحقق من الصحة
            let isValid = true;
            const titleError = mode === 'add' ? 'titleError' : 'editTitleError';
            const linkError = mode === 'add' ? 'linkError' : 'editLinkError';
            const categoryError = mode === 'add' ? 'categoryError' : 'editCategoryError'; // **الجزء الجديد**

            if (!title) {
                document.getElementById(titleError).classList.remove('d-none');
                isValid = false;
            } else {
                document.getElementById(titleError).classList.add('d-none');
            }

            if (!link) {
                document.getElementById(linkError).classList.remove('d-none');
                isValid = false;
            } else {
                document.getElementById(linkError).classList.add('d-none');
            }

            // **الجزء الجديد: التحقق من صحة حقل الفئة**
            if (!category) {
                document.getElementById(categoryError).classList.remove('d-none');
                isValid = false;
            } else {
                document.getElementById(categoryError).classList.add('d-none');
            }

            if (!isValid) return;

            // تنسيق الرابط
            let formattedLink = link;
            if (!formattedLink.startsWith('/') && !formattedLink.startsWith('http')) {
                formattedLink = '/' + formattedLink;
            }

            if (mode === 'add') {
                // حفظ الاختصار الجديد
                const shortcut = {
                    title,
                    link: formattedLink,
                    icon: icon || 'mdi mdi-star-outline',
                    category: category // **الجزء الجديد: حفظ الفئة**
                };
                savedShortcuts.push(shortcut);
                localStorage.setItem('customShortcuts', JSON.stringify(savedShortcuts));
                renderShortcuts();
                addShortcutModal.hide();
                addShortcutForm.reset();
                document.getElementById('shortcutCategory').value =
                    'اختصار مخصص'; // إعادة تعيين القيمة الافتراضية
                // إعادة تعيين الأيقونة المحددة
                document.querySelectorAll('#addShortcutModal .icon-option').forEach(i => {
                    i.classList.remove('selected');
                });
                document.getElementById('shortcutIcon').value = 'mdi mdi-star-outline';
                showToast("تم إضافة الاختصار بنجاح", "#7367f0");
            } else {
                // تحديث الاختصار الموجود
                const index = parseInt(document.getElementById('editShortcutIndex').value);
                savedShortcuts[index] = {
                    title,
                    link: formattedLink,
                    icon: icon || 'mdi mdi-star-outline',
                    category: category // **الجزء الجديد: تحديث الفئة**
                };
                localStorage.setItem('customShortcuts', JSON.stringify(savedShortcuts));
                renderShortcuts();
                editShortcutModal.hide();
                showToast("تم تعديل الاختصار بنجاح", "#ffb800");
            }
        }

        // دالة لإعادة عرض جميع الاختصارات (الثابتة + المخصصة)
        function renderShortcuts() {
            // مسح المحتوى الحالي مع الاحتفاظ بالاختصارات الثابتة
            shortcutsContainer.innerHTML = '';

            // إعادة إضافة الاختصارات الثابتة
            staticShortcuts.forEach(row => {
                shortcutsContainer.appendChild(row.cloneNode(true));
            });

            // إضافة فاصل إذا كان هناك اختصارات ثابتة ومخصصة
            if (staticShortcuts.length > 0 && savedShortcuts.length > 0) {
                const separator = document.createElement('div');
                separator.classList.add('dropdown-divider');
                shortcutsContainer.appendChild(separator);
            }

            // إنشاء صفوف للاختصارات المخصصة (كل صف يحتوي على عنصرين)
            for (let i = 0; i < savedShortcuts.length; i += 2) {
                const row = document.createElement('div');
                row.classList.add('overflow-visible', 'row', 'row-bordered', 'g-0');

                // إضافة العنصر الأول في الصف
                if (savedShortcuts[i]) {
                    row.appendChild(createShortcutElement(savedShortcuts[i], i));
                }

                // إضافة العنصر الثاني في الصف إذا كان موجودًا
                if (savedShortcuts[i + 1]) {
                    row.appendChild(createShortcutElement(savedShortcuts[i + 1], i + 1));
                }

                shortcutsContainer.appendChild(row);
            }

            // تفعيل السحب والإفلات بعد عرض العناصر
            setupDragAndDrop();
        }

        // دالة إنشاء عنصر اختصار مخصص واحد
        function createShortcutElement(shortcut, index) {
            const col = document.createElement('div');
            col.classList.add('dropdown-shortcuts-item', 'col', 'position-relative', 'shortcut-item');
            col.dataset.index = index;
            col.draggable = true;

            const iconClass = shortcut.icon || 'mdi mdi-star-outline';
            const shortcutCategoryText = shortcut.category || 'اختصار مخصص';

            col.innerHTML = `
                <span class="mb-2 dropdown-shortcuts-icon bg-label-secondary rounded-circle">
                    <i class="${iconClass} fs-4"></i>
                </span>
                <a href="${shortcut.link}" class="stretched-link">${shortcut.title}</a>
                <small class="mb-0 text-muted d-block">${shortcutCategoryText}</small>
                `;

            const btnGroup = document.createElement('div');
            btnGroup.classList.add('position-absolute', 'd-flex', 'gap-1');
            btnGroup.style.top = '8px';
            btnGroup.style.right = '8px';
            btnGroup.style.zIndex = '10';

            const editBtn = document.createElement('button');
            editBtn.type = 'button';
            editBtn.classList.add('btn', 'btn-sm', 'btn-icon', 'shortcut-edit-btn');
            editBtn.innerHTML = '<i class="mdi mdi-pencil-outline mdi-18px"></i>';
            editBtn.title = 'تعديل الاختصار';
            editBtn.addEventListener('mouseenter', () => editBtn.style.color = '#ffb800');
            editBtn.addEventListener('mouseleave', () => editBtn.style.color = '');

            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.classList.add('btn', 'btn-sm', 'btn-icon', 'shortcut-delete-btn');
            deleteBtn.innerHTML = '<i class="mdi mdi-close mdi-18px"></i>';
            deleteBtn.title = 'حذف الاختصار';
            deleteBtn.addEventListener('mouseenter', () => deleteBtn.style.color = '#ff3e1d');
            deleteBtn.addEventListener('mouseleave', () => deleteBtn.style.color = '');

            btnGroup.appendChild(editBtn);
            btnGroup.appendChild(deleteBtn);
            col.appendChild(btnGroup);

            editBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                document.getElementById('editShortcutTitle').value = shortcut.title;
                document.getElementById('editShortcutLink').value = shortcut.link;
                document.getElementById('editShortcutCategory').value = shortcut.category || '';
                document.getElementById('editShortcutIndex').value = index;
                document.getElementById('editShortcutIcon').value = shortcut.icon ||
                    'mdi mdi-star-outline';

                document.querySelectorAll('#editShortcutModal .icon-option').forEach(icon => {
                    icon.classList.remove('selected');
                    if (icon.dataset.icon === (shortcut.icon || 'mdi mdi-star-outline')) {
                        icon.classList.add('selected');
                    }
                });

                editShortcutModal.show();
            });

            deleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                document.getElementById('shortcutToDeleteTitle').textContent = shortcut.title;
                deleteShortcutModal.show();

                const deleteHandler = function() {
                    savedShortcuts.splice(index, 1);
                    localStorage.setItem('customShortcuts', JSON.stringify(savedShortcuts));
                    renderShortcuts();
                    deleteShortcutModal.hide();
                    confirmDeleteBtn.removeEventListener('click', deleteHandler);
                    showToast("تم حذف الاختصار بنجاح", "#ff3e1d");
                };

                confirmDeleteBtn.addEventListener('click', deleteHandler);

                deleteShortcutModal._element.addEventListener('hidden.bs.modal', function() {
                    confirmDeleteBtn.removeEventListener('click', deleteHandler);
                });
            });

            return col;
        }

        // دالة لإعداد أحداث السحب والإفلات
        function setupDragAndDrop() {
            const shortcutItems = document.querySelectorAll('.shortcut-item');

            shortcutItems.forEach(item => {
                // بدء السحب
                item.addEventListener('dragstart', function(e) {
                    draggedItem = item;
                    setTimeout(() => {
                        item.style.opacity = '0.5';
                    }, 0);
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/html', item.innerHTML);
                });

                // انتهاء السحب
                item.addEventListener('dragend', function() {
                    setTimeout(() => {
                        draggedItem.style.opacity = '1';
                        draggedItem = null;
                    }, 0);
                });

                // منع السلوك الافتراضي للسماح بالإفلات
                item.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                });

                // عند دخول العنصر إلى منطقة الإفلات
                item.addEventListener('dragenter', function(e) {
                    e.preventDefault();
                    this.style.backgroundColor = '#f8f8f8';
                });

                // عند مغادرة العنصر لمنطقة الإفلات
                item.addEventListener('dragleave', function() {
                    this.style.backgroundColor = '';
                });

                // عند الإفلات
                item.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.style.backgroundColor = '';

                    if (draggedItem !== this) {
                        // الحصول على المؤشرات
                        const fromIndex = parseInt(draggedItem.dataset.index);
                        const toIndex = parseInt(this.dataset.index);

                        // إعادة ترتيب المصفوفة
                        const movedItem = savedShortcuts[fromIndex];
                        savedShortcuts.splice(fromIndex, 1);
                        savedShortcuts.splice(toIndex, 0, movedItem);

                        // حفظ الترتيب الجديد
                        localStorage.setItem('customShortcuts', JSON.stringify(savedShortcuts));

                        // إعادة عرض الاختصارات
                        renderShortcuts();
                        showToast("تم تغيير ترتيب الاختصارات", "#28a745");
                    }
                });
            });
        }

        // دالة لعرض رسائل التنبيه
        function showToast(message, color) {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "left",
                backgroundColor: color,
            }).showToast();
        }
    });
</script>

<style>
    .icon-option {
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        transition: all 0.3s ease;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-option:hover {
        background-color: rgba(115, 103, 240, 0.12);
        color: #7367f0;
    }

    .icon-option.selected {
        background-color: rgba(115, 103, 240, 0.24);
        color: #7367f0;
        border: 1px solid #7367f0;
    }

    .icon-selector {
        max-height: 200px;
        overflow-y: auto;
        padding: 5px;
    }
</style>
