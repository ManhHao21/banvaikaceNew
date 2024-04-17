@extends('backend.components.layout')
@section('title')
    {{ $config['seo']['title'] ?? '' }}
@endsection
@section('style')
    <link href="{{ asset('backend') }}/css/index.css" rel="stylesheet">
@endsection
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <form action="{{ route('admin.catelogue.destroy', $userCatelog->id) }}" class="form"
                                method="post">
                                @csrf
                                @method('DELETE')
                                <div id="DataTables_Table_0_wrapper"
                                    class="dataTables_wrapper form-inline dt-bootstrap pb-27">
                                    <div class="col-sm-3">
                                        <div>Bạn có chắc chắn xóa tài khoản trên {{ $userCatelog->name }} </div>
                                        <div>Một khi đã xóa thì không thể khôi phục được</div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Tên người dùng <strong>(*)</strong> </label>
                                            <input type="text" class="form-control" name="name" disabled
                                                value="{{ old('name', $userCatelog->name ?? '') }}"
                                                style="width:100% !important">
                                            @error('name')
                                                <p style="color:red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6 mb-2">
                                            <label>Email <strong>(*)</strong> </label>
                                            <input type="text" class="form-control" name="description" disabled
                                                value="{{ old('description', $userCatelog->description ?? '') }}"
                                                style="width:100% !important">
                                            @error('description')
                                                <p style="color:red">{{ $message }}</p>
                                            @enderror
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
