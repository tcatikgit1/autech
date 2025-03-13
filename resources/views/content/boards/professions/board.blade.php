@extends('layouts/layoutMaster')

@section('title', 'Professions - Autonomus')

@section('vendor-style')
    @vite([
      'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
      'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
      'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
      'resources/assets/vendor/libs/select2/select2.scss',
      'resources/assets/vendor/libs/@form-validation/form-validation.scss',
      'resources/assets/vendor/libs/animate-css/animate.scss',
      'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
    ])
@endsection

@section('vendor-script')
    @vite([
      'resources/assets/vendor/libs/moment/moment.js',
      'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
      'resources/assets/vendor/libs/select2/select2.js',
      'resources/assets/vendor/libs/@form-validation/popular.js',
      'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
      'resources/assets/vendor/libs/@form-validation/auto-focus.js',
      'resources/assets/vendor/libs/cleavejs/cleave.js',
      'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
      'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
      'resources/assets/js/extended-ui-sweetalert2.js',
    ])
@endsection

@section('page-script')
    @vite([
        'resources/js/custom/custom-form-ajax-response.js',
        'resources/js/boards/professions/board.js'
    ])
@endsection

@section('content')

    <div class="row g-6 mb-6">
        <h4 class="mb-0">Professions</h4>
    </div>
    <!-- Users List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="card-title mb-0">Filters</h5>
            <div class="d-flex justify-content-between align-items-center row pt-4 gap-4 gap-md-0">
                <div class="col-md-2 filter-titulo"></div>
                <div class="col-md-2 filter-estado"></div>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatable table">
                <thead class="border-top">
                <tr>
                    <th></th>
                    <th></th>
                    <th>Title</th>
                    <th>Updated at</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

@endsection
