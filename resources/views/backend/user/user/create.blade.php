@extends('backend.components.layout')
@section('title')
    {{ $config['seo']['title'] ?? '' }}
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('backend') }}/css/custom.css">

    <link href="{{ asset('backend') }}/css/plugins/select2/select2.min.css" rel="stylesheet">
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

                                $url = $config['method'] == 'create' ? route('admin.users.store') : route('admin.users.update', $user->id);
                            @endphp
                            <form action="{{ $url }}" method="POST" class="box">
                                @csrf
                                @php
                                    if ($config['method'] == 'create') {
                                    } else {
                                        echo method_field('PUT');
                                    }
                                @endphp

                                <div class="wrapper wrapper-content animated fadeInRight">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="panel-head">
                                                <div class="panel-title">Thông tin chung</div>
                                                <div class="panel-description">
                                                    <p>Nhập thông tin chung của người sử dụng</p>
                                                    <p>Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là
                                                        bắt buộc</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="ibox">
                                                <div class="ibox-content">
                                                    <div class="row mb15">
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Email
                                                                    <span class="text-danger">(*)</span></label>
                                                                <input type="text" name="email"
                                                                    value="{{ old('email', $user->email ?? '') }}"
                                                                    class="form-control" placeholder="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Họ Tên
                                                                    <span class="text-danger">(*)</span></label>
                                                                <input type="text" name="name"
                                                                    value="{{ old('name', $user->name ?? '') }}"
                                                                    class="form-control" placeholder="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $userCatalogue = ['[Chọn nhóm thành viên]', 'Quản trị viên', 'Cộng tác viên'];

                                                    @endphp
                                                    <div class="row mb15">
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Nhóm
                                                                    Thành viên <span class="text-danger">(*)</span></label>
                                                                <select name="user_catalogue_id"
                                                                    class="form-control setupSelect2">
                                                                    @foreach ($userCatalogue as $key => $item)
                                                                        <option
                                                                            {{ $key == old('user_catalogue_id', isset($user->user_catalogue_id) ? $user->user_catalogue_id : '') ? 'selected' : '' }}
                                                                            value="{{ $key }}">{{ $item }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Ngày
                                                                    sinh </label>
                                                                <input type="date" name="birthday"
                                                                    value="{{ old('birthday', isset($user->birthday) ? date('Y-m-d', strtotime($user->birthday)) : '') }}"
                                                                    class="form-control" placeholder="" autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($config['method'] == 'create')
                                                        <div class="row mb15">
                                                            <div class="col-lg-6">
                                                                <div class="form-row">
                                                                    <label for=""
                                                                        class="control-label text-left">Mật khẩu <span
                                                                            class="text-danger">(*)</span></label>
                                                                    <input type="password" name="password" value=""
                                                                        class="form-control" placeholder=""
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-row">
                                                                    <label for=""
                                                                        class="control-label text-left">Nhập lại mật khẩu
                                                                        <span class="text-danger">(*)</span></label>
                                                                    <input type="password" name="re_password" value=""
                                                                        class="form-control" placeholder=""
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row mb15">
                                                        <div class="col-lg-12">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Ảnh
                                                                    đại diện </label>
                                                                <input type="text" name="image"
                                                                    value="{{ old('image', $user->image ?? '') }}"
                                                                    class="form-control upload-image" placeholder=""
                                                                    autocomplete="off" data-upload="Images">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <div class="panel-head">
                                                <div class="panel-title">Thông tin liên hệ</div>
                                                <div class="panel-description">Nhập thông tin liên hệ của người sử dụng
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="ibox">
                                                <div class="ibox-content">
                                                    <div class="row mb15">
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for=""
                                                                    class="control-label text-left">Thành Phố</label>
                                                                <select name="province_id"
                                                                    class="form-control setupSelect2 province location"
                                                                    data-target="districts">
                                                                    <option value="0">[Chọn Thành Phố]</option>
                                                                    @if (isset($provindes))
                                                                        @foreach ($provindes as $province)
                                                                            <option
                                                                                @if (old('province_id') == $province->code) selected @endif
                                                                                value="{{ $province->code }}">
                                                                                {{ $province->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for=""
                                                                    class="control-label text-left">Quận/Huyện </label>
                                                                <select name="district_id"
                                                                    class="form-control districts setupSelect2 location"
                                                                    data-target="wards">
                                                                    <option value="0">[Chọn Quận/Huyện]</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb15">
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for=""
                                                                    class="control-label text-left">Phường/Xã </label>
                                                                <select name="ward_id"
                                                                    class="form-control setupSelect2 wards">
                                                                    <option value="0">[Chọn Phường/Xã]</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Địa
                                                                    chỉ </label>
                                                                <input type="text" name="address"
                                                                    value="{{ old('addresss', $user->address ?? '') }}"
                                                                    class="form-control" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb15">
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Số
                                                                    điện thoại</label>
                                                                <input type="text" name="phone"
                                                                    value="{{ old('phone', $user->phone ?? '') }}"
                                                                    class="form-control" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-row">
                                                                <label for="" class="control-label text-left">Ghi
                                                                    chú</label>
                                                                <input type="text" name="description"
                                                                    value="{{ old('description', $user->description ?? '') }}"
                                                                    class="form-control" placeholder=""
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right mb15">
                                        <button class="btn btn-primary" type="submit">Lưu
                                            lại</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('backend') }}/libary/location.js"></script>
    <script src="{{ asset('backend') }}/libary/libary.js"></script>
    <script src="{{ asset('backend') }}/libary/ckfinder.js"></script>
    <script src="{{ asset('backend') }}/plugin/ckfinder_2/ckfinder.js"></script>
    <script>
        var province_id = '{{ old('province_id') }}';
        var district_id = '{{ old('district_id') }}';
        var ward_id = '{{ old('ward_id') }}';
    </script>
@endsection
