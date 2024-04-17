@extends('backend.components.layout')
@section('title')
    {{ $config['seo']['title'] ?? '' }}
@endsection
@section('style')
    <style>
        .pb-2 {
            padding-bottom: 10px;
        }

        .w-100 {
            width: 100%;
        }

        .mr-2 {
            margin-right: 10px !important;
        }

        .mr-3 {
            margin-right: 30px !important;
        }

        strong {
            color: red;
        }

        .mb-2 {
            margin-bottom: 7px !important;
        }

        .pb-27 {
            padding-bottom: 27px !important;
        }

        .right {
            float: left;
        }

        .button {
            float: right;
            margin-right: 69%;
            margin-top: 20px;
        }

        .table-responsive {
            overflow-x: hidden;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    @include('backend.components.title', [
        'title' => $config['seo']['title'],
        'titleHeader' => $config['seo']['titleHeader'],
    ]);
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <form action="{{ route('admin.catelogue.store') }}" class="form" method="post">
                                @csrf
                                <div id="DataTables_Table_0_wrapper"
                                    class="dataTables_wrapper form-inline dt-bootstrap pb-27">
                                    <div class="col-sm-3">
                                        <div>Nhập thông tin chung </div>
                                        <div>Nhập thông tin chung của người sử dụng</div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Tên người dùng <strong>(*)</strong> </label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', $user->name ?? '') }}" style="width:100% !important">
                                            @error('name')
                                                <p style="color:red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Email <strong>(*)</strong> </label>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ old('email', $user->email ?? '') }}" style="width:100% !important">
                                            @error('email')
                                                <p style="color:red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        @php
                                            $group_id = ['[ Chọn nhóm thành viên ]', 'Mua sỉ', 'Mua lẻ'];
                                        @endphp
                                        <div class="form-group col-md-6 mb-2">
                                            <label>Nhóm thành viên <strong>(*)</strong></label>
                                            <select class="form-control js-example-basic-multiple"
                                                style="width:100% !important" id="exampleFormControlSelect1"
                                                name="group_id">
                                                @foreach ($group_id as $key => $item)
                                                    <option value="{{ $key }}"
                                                        {{ $key == old('group_id', isset($user->group_id) ? $user->group_id : '') ? 'selected' : '' }}>
                                                        {{ $item }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Ngày sinh</label>
                                            <input type="date" class="form-control" name="birthday"
                                                style="width:100% !important"
                                                value="{{ old('birthday', $user->birthday ? date('Y-m-d', strtotime($user->birthday)) : '') }}">
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Mật khẩu <strong>(*)</strong> </label>
                                            <input type="text" class="form-control" name="password"
                                                style="width:100% !important">
                                            @error('password')
                                                <p style="color:red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Mật khẩu nhập lại <strong>(*)</strong> </label>
                                            <input type="text" class="form-control" name="confilm_password"
                                                style="width:100% !important">
                                            @error('confilm_password')
                                                <p style="color:red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-12 mb-2">
                                            <label>Ảnh đại diện <strong>(*)</strong> </label>
                                            <input type="text" class="form-control" name="image_thumb"
                                                style="width:100% !important" data-upload="Images">

                                        </div>

                                    </div>
                                </div>
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                    <div class="col-sm-3">
                                        <div>Nhập thông tin liên hệ </div>
                                        <div>Nhập thông tin liên hệ của người sử dụng</div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-group col-md-6 mb-2">
                                            <label>Chọn thành phố</label>
                                            <select class="form-control setupSelect2 province location"
                                                style="width:100% !important" id="exampleFormControlSelect1 "
                                                name="province_id" data-target="districts">
                                                <option value="0">[ Chọn thành phố ]</option>
                                                @if ($provindes->count() > 0)
                                                    @foreach ($provindes as $item)
                                                        <option @if (old('province_id') == $item->code) selected @endif
                                                            value="{{ $item->code }}">{{ $item->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label>Chọn quận huyện</label>
                                            <select class="form-control districts setupSelect2 location"
                                                style="width:100% !important" name="district_id" data-target="wards">
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label>Chọn phường/xã ></label>
                                            <select class="form-control wards setupSelect2" style="width:100% !important"
                                                id="exampleFormControlSelect1" name="ward_id">
                                                <option value="0">[ Chọn phường xã ]</option>

                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Địa chỉ</label>
                                            <input type="text" class="form-control" name="address"
                                                style="width:100% !important">
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Số điện thoại </label>
                                            <input type="text" class="form-control" name="phone"
                                                style="width:100% !important">
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Ghi chú </label>
                                            <input type="text" class="form-control" name="des"
                                                style="width:100% !important">

                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-primary button">Gửi đi</button>

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
