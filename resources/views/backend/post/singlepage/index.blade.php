@extends('backend.components.layout')
@section('title')
    {{ $config['seo']['title'] ?? '' }}
@endsection
@section('style')
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <link href="{{ asset('backend') }}/css/plugins/switchery/switchery.css" rel="stylesheet">
    <link href="{{ asset('backend') }}/css/index.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('backend') }}/css/custom.css">
@endsection
@section('content')
    @include('backend.components.title', [
        'title' => $config['seo']['title'],
        'titleHeader' => $config['seo']['titleHeader'],
    ])
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        @include('backend.components.tollbox', [
                            'model' => 'Post',
                        ])
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                @include('backend.post.singlepage.component.fillter')
                                <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th><input type="checkbox" class="checkAll" name="" id=""></th>
                                            <th>Tên bài viết</th>
                                            <th>Nội dung</th>
                                            <th>Hình ảnh</th>
                                            <th>Tình trạng</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($listSinglePages->count() > 0)
                                            @foreach ($listSinglePages as $key => $item)
                                                <tr class="gradeA odd row-{{ $item->id }}" role="row">
                                                    <td class="sorting_1"><input type="checkbox" name=""
                                                            value="{{ $item->id }}" class="checkItem input-check"
                                                            id=""></td>
                                                    <td>{{ $item->title }}</td>
                                                    <td>{!! $item->content !!}</td>
                                                    @php
                                                        $image = json_decode($item->image);
                                                    @endphp
                                                    @if (!empty($image))
                                                        <td><img src="{{ asset('storage/' . ($image[0] ?? '')) }}"
                                                                width="200px" height="200px" alt=""></td>
                                                    @else
                                                        <td></td>
                                                    @endif

                                                    <td>
                                                        <label class="switch">
                                                            <input type="checkbox"
                                                                class="status js-switch-{{ $item->id }}"
                                                                data-field="publish" data-model="SinglePage"
                                                                {{ $item->publish == 1 ? 'checked' : '' }}
                                                                data-id="{{ $item->id }}">
                                                            <span class="slider round"></span>
                                                            <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center list-action action">
                                                            <a class="badge-info mr-2 btn p-2 d-flex btn-action data-toggle="tooltip"
                                                                data-placement="top" title=""
                                                                data-original-title="View"
                                                                href="{{ route('admin.singlepage.edit', $item->id) }}"><i
                                                                    class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            <a class="badge-danger d-flex btn p-2 btn-action"
                                                                data-toggle="tooltip" data-placement="top" title=""
                                                                data-original-title="View"
                                                                href="{{ route('admin.singlepage.show', $item->id) }}"><i
                                                                    class="fa fa-trash" aria-hidden="true"></i></a>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                {{ $listSinglePages->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('backend') }}/js/plugins/switchery/switchery.js"></script>
    <script src="{{ asset('backend') }}/libary/change.js"></script>
@endsection
