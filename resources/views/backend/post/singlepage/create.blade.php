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

                                $url = $config['method'] == 'create' ? route('admin.singlepage.store') : route('admin.singlepage.update', $singlepage->id);
                            @endphp
                            <form action="{{ $url }}" method="POST" class="box">
                                @csrf
                                @php
                                    if ($config['method'] == 'create') {
                                    } elseif ($config['method'] == 'edit') {
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
                                                                    đề bài viết
                                                                    <span class="text-danger">(*)</span></label>
                                                                <input type="text" name="title"
                                                                    value="{{ old('title', $singlepage->title ?? '') }}"
                                                                    class="form-control title" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Đường
                                                                    dẫn bài viêt
                                                                    <span class="text-danger">{{ env('APP_URL') }}/<span
                                                                            class="slug">{{ $singlepage->slug ?? '' }}</span></span><input
                                                                        type="hidden" name="slug"></label>
                                                            </div>

                                                            <div class="col-lg-12">
                                                                <div class="form-row">
                                                                    <label for=""
                                                                        class="control-label text-left">Nội dung ngắn
                                                                        <span class="text-danger">(*)</span></label>
                                                                    <textarea type="text" height="200px !important" name="short_description" value=""
                                                                        class="form-control text-teara-2" placeholder="" autocomplete="off">{{ old('short_description', $singlepage->short_description ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-row">
                                                                    <label for=""
                                                                        class="control-label text-left">Nội dung bài viết
                                                                        <span class="text-danger">(*)</span></label>
                                                                    <textarea type="text" id="meta_description" name="content" value="" class="form-control" placeholder=""
                                                                        autocomplete="off">{{ old('content', $singlepage->content ?? '') }}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="file-upload">
                                                                    <button class="file-upload-btn" type="button"
                                                                        style="{{ $config['method'] == 'edit' ? 'display: none;' : '' }}"
                                                                        onclick="$('.file-upload-input').trigger( 'click' )">Add
                                                                        Image</button>

                                                                    <div class="image-upload-wrap"
                                                                        style="{{ $config['method'] == 'edit' ? 'display: none;' : '' }}">
                                                                        <input class="file-upload-input" name="image"
                                                                            type='file' onchange="readURL(this);"
                                                                            value="{{ asset('storage') . ($config['method'] == 'edit' ? '/' . $singlepage->image : '') }}" />
                                                                        <div class="drag-text">
                                                                            <h3>Drag and drop a file or select add Image
                                                                            </h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="file-upload-content"
                                                                        style="{{ $config['method'] == 'edit' ? 'display: block;' : '' }}">
                                                                        <img class="file-upload-image" width="200px"
                                                                            height="200px"
                                                                            src="{{ asset('storage') . ($config['method'] == 'edit' ? '/' . $singlepage->image : '') }}"
                                                                            alt="your image" name='image' />

                                                                        <div class="image-title-wrap">
                                                                            <button type="button" onclick="removeUpload()"
                                                                                class="remove-image">Remove
                                                                                <span class="image-title">Uploaded
                                                                                    Image</span>
                                                                            </button>
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
                                        @include('backend.components.seo', ['mode' => $singlepage ?? ''])
                                        <div class="text-right mb15">
                                            <button class="btn btn-primary" type="submit">Lưu
                                                lại</button>
                                        </div>
                                    </div>
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
    <script src="{{ asset('backend') }}/libary/singlepage.js"></script>
    <script src="{{ asset('backend') }}/libary/image.js"></script>
    <script>
        CKEDITOR.replace('meta_description');
    </script>
@endsection
