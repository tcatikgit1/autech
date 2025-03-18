<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">

@vite([
    'resources/assets/vendor/fonts/tabler-icons.scss',
    'resources/assets/vendor/fonts/flag-icons.scss',
    'resources/assets/vendor/libs/node-waves/node-waves.scss',
    'resources/css/app.scss'

])
<!-- Core CSS -->
{{-- @vite([
    'resources/assets/vendor/scss' . $configData['rtlSupport'] . '/core' . ($configData['style'] !== 'light' ? '-' . $configData['style'] : '') . '.scss',
    'resources/assets/vendor/scss' . $configData['rtlSupport'] . '/' . $configData['theme'] . ($configData['style'] !== 'light' ? '-' . $configData['style'] : '') . '.scss',
    'resources/assets/css/demo.css'
]) --}}

<!-- Vendor Styles -->
@vite([
    'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss',
    'resources/assets/vendor/libs/typeahead-js/typeahead.scss',
    'resources/css/app.scss',
    'resources/scss/navbar.scss',
    'resources/scss/footer.scss',
])
@yield('vendor-style')

<!-- Page Styles -->
@yield('page-style')
