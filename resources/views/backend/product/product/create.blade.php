@extends('backend.components.layout')
@section('title')
    {{ $config['seo']['title'] ?? '' }}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('backend') }}/css/custom.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <link href="{{ asset('backend') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <link href="{{ asset('backend') }}/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/css/index.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend') }}/css/custom.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/css/tag.css">
@endsection
@section('content')
    @include('backend.components.title', [
        'title' => $config['seo']['title'],
        'titleHeader' => $config['seo']['titleHeader'],
    ])
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            @php
                                $url =
                                    $config['method'] == 'create'
                                        ? route('admin.product.store')
                                        : route('admin.product.update', $product->id);
                            @endphp
                            <form action="{{ $url }}" method="post" class="box" enctype="multipart/form-data">
                                @csrf
                                @php
                                    if ($config['method'] == 'create') {
                                    } else {
                                        echo method_field('PUT');
                                    }
                                @endphp
                                <div class="wrapper wrapper-content animated fadeInRight">
                                    <div class="row pl-2">
                                        <div class="col-lg-4">
                                            <div class="panel-head">
                                                <div class="panel-title">Thông tin chung</div>
                                                <div class="panel-description">
                                                    <p>Nhập thông tin chung của người sử dụng</p>
                                                    <p>Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là
                                                        bắt buộc</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="ibox">
                                                <div class="ibox-content">
                                                    <div class="row mb15">
                                                        <div class="col-lg-12">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Tiêu
                                                                    đề sản phẩm
                                                                    <span class="text-danger">(*)</span></label>
                                                                <input type="text" name="name"
                                                                    value="{{ old('name', $product->name ?? '') }}"
                                                                    class="form-control title" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Đường
                                                                    dẫn sản phẩm
                                                                    <span class="text-danger">(*)</span></label>
                                                                <input type="text" name="slug"
                                                                    value="{{ old('slug', $product->slug ?? '') }}"
                                                                    class="form-control slug" placeholder=""
                                                                    autocomplete="off">
                                                            </div>

                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-row" style="margin-bottom: 10px;">
                                                                <label for="" class="control-label text-left">Danh
                                                                    mục sản phẩm
                                                                </label>
                                                                <select name="categories_id"
                                                                    class="form-control districts setupSelect2 location"
                                                                    data-target="wards">
                                                                    <option value="0">Chọn danh mục</option>
                                                                    {{ getCategories($categories, old('categories_id')) }}
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row col-lg-6">
                                                            <label for="" class="control-label text-left">SKU
                                                                <span class="text-danger">(*)</span></label>
                                                            <input type="text" name="sku"
                                                                value="{{ old('sku', $product->sku ?? '') }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="form-row col-lg-6">
                                                            <label for="" class="control-label text-left">Khối
                                                                lượng sản phẩm
                                                                <span class="text-danger">(*)</span></label>
                                                            <input type="text" name="gms"
                                                                value="{{ old('gms', $product->gms ?? '') }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="form-row col-lg-6">
                                                            <label for="" class="control-label text-left">Giá
                                                                tiền
                                                                <span class="text-danger">(*)</span></label>
                                                            <input type="text" name="price"
                                                                value="{{ old('price', $product->price ?? '') }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="form-row col-lg-6">
                                                            <label for="" class="control-label text-left">giá giảm
                                                                <span class="text-danger">(*)</span></label>
                                                            <input type="text" name="seller"
                                                                value="{{ old('seller', $product->seller ?? '') }}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="upload__box">
                                                                <div class="upload__btn-box">
                                                                    <label class="btn-primary btn">
                                                                        <p>Upload images</p>
                                                                        <input type="file" multiple=""
                                                                            data-max_length="20" name="image[]"
                                                                            class="upload__inputfile">
                                                                    </label>
                                                                </div>
                                                                <div class="upload__img-wrap"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-row">
                                                                <div class="form-check form-switch switch-check">
                                                                    <label class="switch">
                                                                        <input type="checkbox" class="status"
                                                                            name="is_hot" value="1">
                                                                        <span class="slider round"></span>
                                                                        <meta name="csrf-token"
                                                                            content="{{ csrf_token() }}" />
                                                                    </label>
                                                                    <label class="form-check-label"
                                                                        for="flexSwitchCheckDefault">Sản phẩm hot</label>
                                                                </div>
                                                                <div class="form-check form-switch switch-check">
                                                                    <label class="switch">
                                                                        <input type="checkbox" class="status js-switch"
                                                                            name="top_view" value="1">
                                                                        <span class="slider round"></span>
                                                                        <meta name="csrf-token"
                                                                            content="{{ csrf_token() }}" />
                                                                    </label>
                                                                    <label class="form-check-label"
                                                                        for="flexSwitchCheckDefault">Sản phẩm nổi
                                                                        bật</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                    </div>
                                </div>
                                <div class="wrapper wrapper-content animated fadeInRight">
                                    <div class="row pl-2">
                                        <div class="col-lg-4">
                                            <div class="panel-head">
                                                <div class="panel-title">Thông tin bổ sung cho sản phẩm</div>
                                                <div class="panel-description">
                                                    <p>Nhập thông tin bổ sung cho sản phẩm</p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="ibox">
                                                <div class="ibox-content">
                                                    <div class="row mb15">
                                                        <div class="col-lg-12">
                                                            <div class="form-row">
                                                                <label for=""
                                                                    class="control-label text-left">description
                                                                    <span class="text-danger">(*)</span></label>
                                                                <textarea type="text" id="meta_description" name="description" value="" class="form-control"
                                                                    placeholder="" autocomplete="off">{{ old('description', $product->description ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12" style="margin-top: 15px">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading">
                                                                    <h3>Image color</h3>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="form-group">
                                                                        <input type="file" name="images_color[]"
                                                                            id="images" multiple class="form-control"
                                                                            required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div id="image_preview" style="width:100%;">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="text-right mb15">
                                    <button class="btn btn-primary" type="submit">Lưu
                                        lại</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('backend') }}/libary/scripts.js"></script>
    <script src="{{ asset('backend') }}/libary/imagemulti.js"></script>
    <script src="{{ asset('backend') }}/libary/selectM.js"></script>
    <script src="{{ asset('backend') }}/libary/tag.js"></script>
    <script src="{{ asset('backend') }}/libary/image-color.js"></script>
    <script src="{{ asset('backend') }}/js/plugins/switchery/switchery.js"></script>
    <script>
        CKEDITOR.replace('meta_description');
    </script>
@endsection
