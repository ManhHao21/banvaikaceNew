@extends('backend.components.layout')
@section('title')
    {{ $config['seo']['title'] ?? '' }}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('backend') }}/css/custom.css">

    <link href="{{ asset('backend') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    @include('backend.components.title', [
        'title' => $config['seo']['title'],
        'titleHeader' => $config['seo']['titleHeader'],
    ]);
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
                                        ? route('admin.category.store')
                                        : route('admin.category.update', $category->id);
                            @endphp
                            <form action="{{ $url }}" method="POST" class="box" enctype="multipart/form-data">
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
                                                                <label for="" class="control-label text-left">Tên
                                                                    danh mục
                                                                    <span class="text-danger">(*)</span></label>
                                                                <input type="text" name="name"
                                                                    value="{{ old('name', $category->name ?? '') }}"
                                                                    class="form-control title" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Đường
                                                                    dẫn
                                                                    <span class="text-danger">(*)</span></label>
                                                                <input type="text" name="slug"
                                                                    value="{{ old('slug', $category->slug ?? '') }}"
                                                                    class="form-control slug"
                                                                    placeholder="Nhập đường dẫn..." autocomplete="off">
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="upload__box">
                                                                    <div class="upload__btn-box">
                                                                        <label class="btn-primary btn">
                                                                            <p>Upload images</p>
                                                                            <input type="file" data-max_length="20"
                                                                                name="image" class="upload__inputfile">
                                                                        </label>
                                                                    </div>
                                                                    <div class="upload__img-wrap">
                                                                        @if (isset($category->image))
                                                                            <div class='upload__img-box'>
                                                                                <div style='background-image: url({{ asset("storage/$category->image") }})'
                                                                                    @if (!empty($category->image)) data-number='' data-file='" + f.name + "' @endif
                                                                                    class='img-bg'>
                                                                                    <div class='upload__img-close'></div>
                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                    </div>


                                                                </div>
                                                            </div>
                                                            <div class="form-row" style="margin-top: 10px">
                                                                <label for="cate-name" class="control-label text-left">Danh
                                                                    mục
                                                                    cha
                                                                </label>
                                                                <select name="parent_id" id="cate-name "
                                                                    class="form-control districts setupSelect2 location"
                                                                    data-target="wards">
                                                                    <option value="0">Chọn danh mục</option>
                                                                    {{ getCategories($categories, old('parent_id', $category->id ?? '')) }}
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                        </div>
                                        @include('backend.components.seo', ['mode' => $category ?? ''])

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
@endsection
@section('script')
    <script src="{{ asset('backend') }}/libary/scripts.js"></script>
    <script src="{{ asset('backend') }}/libary/imagemulti.js"></script>
@endsection
