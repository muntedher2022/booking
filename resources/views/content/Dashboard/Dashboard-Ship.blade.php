@extends('layouts/layoutMaster')

@section('title', 'لوحة التحكم')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-statistics.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-analytics.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/dashboards-crm.js') }}"></script>
    <script src="{{ asset('assets/js/charts-apex.js') }}"></script>
    <script src="{{ asset('assets/js/cards-statistics.js') }}"></script>
@endsection


@section('content')

    @livewire('dashboard.dashboard-ship')

@endsection

@section('vendor-style')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/remixicon/remixicon.css') }}" />
@endsection

@section('vendor-script')
    @parent
    <script src="{{ asset('assets/vendor/libs/remixicon/remixicon.js') }}"></script>
@endsection
