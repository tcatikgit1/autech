@extends('layouts/layoutMaster')

@section('title', 'Form ' . $nameCrud )

<!-- Vendor Styles -->
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss',
        'resources/assets/vendor/libs/animate-css/animate.scss',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
      ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite([
      'resources/assets/vendor/libs/jquery-sticky/jquery-sticky.js',
      'resources/assets/vendor/libs/cleavejs/cleave.js',
      'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
      'resources/assets/vendor/libs/select2/select2.js',
        'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
        'resources/assets/js/extended-ui-sweetalert2.js',
    ])
@endsection

<!-- Page Scripts -->
@section('page-script')
    @vite([
    'resources/assets/js/form-layouts.js',
    'resources/js/boards/employees/form.js'
    ])
@endsection

@section('content')

    <!-- Sticky Actions -->
    <form id="board-form" action="{{route('board.employee.store', ['id' => @$employee['_id']])}}" method="post" enctype="multipart/form-data">
        @csrf
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header sticky-element bg-label-light d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">@if($method == 'create') Create @elseif($method=='edit') Update @else View @endif {{$nameCrud}}</h5>
                    <div class="action-btns">
                        <a type="button" href="{{route('board.employee.index')}}" class="btn btn-label-danger me-4">
                            <span class="align-middle"> Cancel</span>
                        </a>
                        @if($method != 'view')
                        <button class="btn btn-primary" type="submit">
                            <i class="ti ti-device-floppy me-1"></i>
                            @if($method == 'create') Add @elseif($method=='edit') Update @else View @endif Employee
                        </button>
                        @endif
                    </div>
                </div>
                @if($method == 'view') <fieldset disabled> @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <!-- 1. Delivery Address -->
                            <h5 class="mb-6">1. Employee Data</h5>
                            <div class="row g-6">

                                <div class="col-md-6">
                                    <div class="d-flex align-items-start align-items-sm-center gap-6">
                                        <img src="{{config('app.FILES_URL') . $employee['avatar']}}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedFile">
                                        <div class="button-wrapper">
                                            <label for="formFile" class="btn btn-primary me-3 mb-4 waves-effect waves-light" tabindex="0">
                                                <span class="d-none d-sm-block">Upload new photo</span>
                                                <i class="ti ti-upload d-block d-sm-none"></i>
                                                <input type="file" id="formFile" name="avatar" class="fileInput" hidden="" accept="image/png, image/jpeg" data-url="{{@$employee['avatar']}}">
                                            </label>
                                            <button type="button" class="btn btn-label-secondary account-image-reset mb-4 waves-effect">
                                                <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>

                                            <div>Allowed JPG or PNG. Max size of 800K</div>
                                        </div>
                                    </div>
                                </div>

{{--                                <div class="col-md-6">--}}
{{--                                    <label for="formFile" class="form-label">Avatar</label>--}}
{{--                                    <input type="file" id="formFile" class="form-control" name="avatar" data-url="{{@$employee['avatar']}}">--}}
{{--                                </div>--}}

                                <div class="col-md-3">
                                    <label class="form-label" for="fullname">Name *</label>
                                    <input type="text" id="fullname" class="form-control" name="nombre" value="{{@$employee['nombre']}}" placeholder="John" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="apellidos">Last Name *</label>
                                    <input type="text" id="apellidos" class="form-control" name="apellidos" value="{{@$employee['apellidos']}}" placeholder="Doe" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email *</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="text" id="email" name="email" value="{{@$employee['email']}}" placeholder="john.doe@gmail.com" aria-label="john.doe" aria-describedby="email3" />
{{--                                        <span class="input-group-text" id="email3">@example.com</span>--}}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="telefono">Phone Number</label>
                                    <input type="text" id="telefono" class="form-control phone-mask" name="telefono" value="{{@$employee['telefono']}}" placeholder="658 799 8941" aria-label="658 799 8941" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="dni">ID Number</label>
                                    <input type="text" id="dni" class="form-control" name="dni" value="{{@$employee['dni']}}" placeholder="58877777A" aria-label="58877777A" />
                                </div>
                                <label class="switch switch-primary">
                                    <input type="checkbox" class="switch-input" name="is_blocked" @if(isset($employee['is_blocked']) && $employee['is_blocked'] == true) checked @endif>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                          <i class="ti ti-check"></i>
                                        </span>
                                        <span class="switch-off">
                                          <i class="ti ti-x"></i>
                                        </span>
                                    </span>
                                    <span class="switch-label">Blocked employee</span>
                                </label>

                            </div>
{{--                            <hr>--}}

{{--                            <h5 class="my-6">2. Delivery Type</h5>--}}

{{--                            <h5 class="my-6">3. Apply Promo code</h5>--}}

{{--                            <h5 class="my-6">4. Payment Method</h5>--}}

                        </div>
                    </div>
                </div>
                @if($method == 'view') </fieldset> @endif
            </div>
        </div>
    </div>
    </form>

@endsection
