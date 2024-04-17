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

        .d-flex {
            display: flex;
        }

        .d-flex>a>i {
            align-items: center;
            justify-content: center;
        }
        .button {
            border: none;
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
                                <div class="search pb-2">
                                    <div class="input-group col-md-3 mr-2">
                                        <div class="form-outline " style="width:100% !important" data-mdb-input-init>
                                            <input type="search" id="form1" class="form-control w-100"
                                                style="width:100% !important" />
                                        </div>
                                    </div>
                                    <div class="input-group col-md-3">
                                        <div class="form-outline " style="width:100% !important" data-mdb-input-init>
                                            <input type="search" id="form1" class="form-control w-100"
                                                style="width:100% !important" />
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select class="form-control " style="width:100% !important"
                                            id="exampleFormControlSelect1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-primary mr-3" style="margin-bottom:0 !important">Tìm
                                        kiếm</button>
                                    <div class="btn btn-primary" style="margin-bottom:0 !important">
                                        <a href="{{ route('admin.quantri.create') }}" style="color:white">Thêm quản trị
                                            viên</a>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th>STT</th>
                                            <th>Họ và tên</th>
                                            <th>Số điện thoại</th>
                                            <th>Quyền</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($listUser->count() > 0)
                                            @foreach ($listUser as $key => $item)
                                                <tr class="gradeA odd" role="row">
                                                    <td class="sorting_1">{{ $key + 1 }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->phone }}</td>
                                                    <td class="center">
                                                        <button
                                                            class="btn-sm {{ $item->is_active == 0 ? 'btn btn-primary' : 'btn btn-secondary' }}">
                                                            {{ $item->is_active == 0 ? 'Admin' : 'Đăng bài' }}
                                                        </button>
                                                    </td>

                                                    <td>
                                                        <div class="d-flex align-items-center list-action action">
                                                            <a class="badge-info mr-2 btn p-2 d-flex btn-action data-toggle="tooltip"
                                                                data-placement="top" title=""
                                                                data-original-title="View"
                                                                href="{{ route('admin.quantri.edit', $item->id) }}"><i
                                                                    class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            <a href="">
                                                                <form action="{{ route('admin.quantri.destroy', $item) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="badge bg-warning mr-2 button"
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title=""
                                                                        onclick="return confirm('Bạn có chắc muốn xóa bài viết này không?')"
                                                                        data-original-title="Delete"><i class="fa fa-trash"
                                                                            aria-hidden="true"></i></button>
                                                                </form>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                                {{ $listUser->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
