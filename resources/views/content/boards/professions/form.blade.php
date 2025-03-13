@extends('layouts/layoutMaster')

@section('title', 'Form ' . $nameCrud)

<!-- Vendor Styles -->
@section('vendor-style')
    @vite([
    'resources/assets/vendor/libs/select2/select2.scss',
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
    'resources/js/boards/professions/form.js'
])
@endsection

@section('content')

    <!-- Sticky Actions -->
    <form id="board-form" action="{{route('profession.store', ['id' => @$profession['_id']])}}" method="post"
          enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header sticky-element bg-label-light d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                        <h5 class="card-title mb-sm-0 me-2">
                            @if($method == 'create')
                                Create
                            @elseif($method == 'edit')
                                Update
                            @else
                                View
                            @endif
                            {{$nameCrud}}
                        </h5>
                        <div class="action-btns">
                            <a type="button" href="{{route('profession.index')}}" class="btn btn-label-danger me-4">
                                <span class="align-middle"> Cancel</span>
                            </a>
                            @if($method != 'view')
                                <button class="btn btn-primary" type="submit">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    @if($method == 'create')
                                        Add
                                    @elseif($method == 'edit')
                                        Update
                                    @else
                                        View
                                    @endif
                                    Profession
                                </button>
                            @endif
                        </div>
                    </div>
                    @if ($method == 'view')
                        <fieldset disabled>
                    @endif
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <h5 class="mb-6">1. Profession data</h5>
                                <div class="row g-6">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-start align-items-sm-center gap-6">
                                            <img src="{{isset($image) ? $image : asset('assets/img/icons/forms/upload.png')}}" alt="profession-image"
                                                 class="d-block w-px-100 h-px-100 rounded" id="uploadedFile">
                                            <div class="button-wrapper">
                                                <label for="formFile"
                                                       class="btn btn-primary me-3 mb-4 waves-effect waves-light"
                                                       tabindex="0">
                                                    <span class="d-none d-sm-block">Upload new photo</span>
                                                    <i class="ti ti-upload d-block d-sm-none"></i>
                                                    <input type="file" id="formFile" name="imagen" class="fileInput"
                                                           hidden="" accept="image/png, image/jpeg"
                                                           data-url="{{ @$profession['imagen'] }}">
                                                </label>
                                                <button type="button"
                                                        class="btn btn-label-secondary account-image-reset mb-4 waves-effect">
                                                    <i class="ti ti-refresh-dot d-block d-sm-none"></i>
                                                    <span class="d-none d-sm-block">Reset</span>
                                                </button>

                                                <div>Allowed JPG or PNG. Max size of 800K</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="titulo">Job title *</label>
                                        <input type="text" id="titulo" class="form-control" name="titulo"
                                               placeholder="Informático" value="{{@$profession['titulo']}}"/>
                                    </div>
                                    <label class="switch switch-primary">
                                        <input type="checkbox" class="switch-input" name="estado"
                                               @if (isset($profession['estado']) && $profession['estado'] == true) checked @endif>
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on">
                                                <i class="ti ti-check"></i>
                                            </span>
                                            <span class="switch-off">
                                                <i class="ti ti-x"></i>
                                            </span>
                                        </span>
                                        <span class="switch-label">Active profession</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($method == 'view')
                        </fieldset>
                    @endif
                </div>
            </div>
        </div>
    </form>

@endsection
