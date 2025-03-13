@extends('layouts/layoutFront')

@section('title', 'User Profile - Profile')

<!-- Vendor Styles -->
@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/dropzone/dropzone.scss',
    'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss'
  ])
@endsection

<!-- Page Styles -->
@section('page-style')
@vite([
  'resources/assets/vendor/scss/pages/page-user-profile.scss'
 ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/moment/moment.js',
  'resources/assets/vendor/libs/select2/select2.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
  'resources/assets/vendor/libs/dropzone/dropzone.js',
  'resources/assets/vendor/libs/sortablejs/sortable.js',
  'resources/assets/vendor/libs/bs-stepper/bs-stepper.js'
])
@endsection

@section('page-script')
    @vite([
      'resources/js/google-place-api.js',
      'resources/js/web/user-panel/index.js',
      'resources/js/web/user-panel/change-email-form.js',
      'resources/js/web/user-panel/change-password-form.js',
      'resources/js/web/user-panel/payment-history.js',
      'resources/js/web/user-panel/my-promotions.js',
      'resources/js/web/user-panel/advertisement.js',
      'resources/js/web/user-panel/my-favs.js',
      'resources/js/web/user-panel/become-autonomus.js',
      'resources/js/web/user-panel/autonomus-data.js',
    ])
@endsection

@section('content')
  <div class="container">

    <meta name="tab" content="{{$tab}}">
    <meta name="modal" content="{{$modal}}">
    <meta name="gateway-url" content="{{ env('GATEWAY_URL') }}">
    <input type="hidden" id="user_type" value="{{ session()->get('user')['tipo'] ?? null }}">
    @include('pages.profile.profile-main')
  </div>

  <!-- Cargar Google Maps API con la clave -->
  <script src="https://maps.googleapis.com/maps/api/js?key={{ env("MAPS_API_KEY") }}&loading=async&libraries=places"></script>

@endsection
