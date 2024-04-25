<head>
    <meta charset="utf-8">
    <title>{{$result['homepage_slogan']}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="{{ $result['seo_meta_keyword'] }}" name="keywords">
    <meta content="{{ $result['seo_meta_title'] }}" name="description">

    <!-- Favicon -->
    <link href="{{ asset('storage') }}/{{$result['homepage_favicon'] }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('Fontend') }}/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('Fontend') }}/css/style.css" rel="stylesheet">
    <link href="{{ asset('Fontend') }}/css/main.css" rel="stylesheet">
    @yield('style')
</head>
