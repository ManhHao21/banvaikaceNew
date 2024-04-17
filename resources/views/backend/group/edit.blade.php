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

        .right {
            float: left;
        }
    </style>
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
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="col-sm-3">
                                    <div>Nhập thông tin chung </div>
                                    <div>Nhập thông tin chung của người sử dụng</div>
                                </div>
                                <div class="col-sm-9">
                                    <form action="{{ route('admin.quantri.update', $admin->id) }}" class="form"
                                        method="POST">
                                        @method('PUT')
                                        @csrf
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Tên người dùng <strong>(*)</strong> </label>
                                            <input type="text" class="form-control" name="name"
                                                style="width:100% !important" value="{{ old('name', $admin->name) }}">
                                            @error('name')
                                                <p style="color:red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Email <strong>(*)</strong> </label>
                                            <input type="text" class="form-control" name="email"
                                                style="width:100% !important" value="{{ old('email', $admin->email) }}">
                                            @error('email')
                                                <p style="color:red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-6 mb-2">
                                            <label>Nhóm thành viên <strong>(*)</strong></label>
                                            <select class="form-control " style="width:100% !important"
                                                id="exampleFormControlSelect1" name="group_id">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Số điện thoại</label>
                                            <input type="text" class="form-control" name="phone"
                                                style="width:100% !important" value="{{ old('phone', $admin->phone) }}">
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Mật khẩu <strong>(*)</strong> </label>
                                            <input type="password" class="form-control" name="password"
                                                style="width:100% !important">
                                            @error('password')
                                                <p style="color:red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Mật khẩu nhập lại <strong>(*)</strong> </label>
                                            <input type="password" class="form-control" name="confilm_password"
                                                style="width:100% !important">
                                            @error('confilm_password')
                                                <p style="color:red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <button class="btn btn-primary right">Gửi đi</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
