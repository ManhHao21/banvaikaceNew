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
                            <form action="{{ route('admin.system.create') }}" method="post" class="box"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="wrapper wrapper-content animated fadeInRight">
                                    @foreach ($system as $key => $item)
                                        <div class="row pl-2">
                                            <div class="col-lg-4">
                                                <div class="panel-head">
                                                    <div class="panel-title">{{ $item['label'] }}</div>
                                                    <div class="panel-description">
                                                        <p>{{ $item['description'] }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="ibox">
                                                    <div class="ibox-content">
                                                        <div class="row mb15">
                                                            <div class="col-lg-12">
                                                                @if (count($item['value']))
                                                                    @foreach ($item['value'] as $keyValue => $itemValue)
                                                                        @php
                                                                            $name = $key . '_' . $keyValue;
                                                                        @endphp
                                                                        <div class="form-row">
                                                                            <label for=""
                                                                                class="control-label text-left">{{ $itemValue['label'] }}
                                                                            </label>
                                                                            @switch($itemValue['type'])
                                                                                @case('text')
                                                                                    {!! renderSystemInput($name, 'text', $systemAll) !!}
                                                                                @break

                                                                                @case('file')
                                                                                    {!! renderSystemInput($name, 'file', $systemAll) !!}
                                                                                @break

                                                                                @case('textarea')
                                                                                    {!! renderSystemTextarea($name, $systemAll) !!}
                                                                                @break

                                                                                @case('select')
                                                                                    {!! renderSystemSelect($itemValue['option'], $name, $systemAll) !!}
                                                                                @break

                                                                                @default
                                                                            @endswitch

                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    @endforeach
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
    <script src="{{ asset('backend') }}/libary/scripts.js"></script>
    <script src="{{ asset('backend') }}/libary/imagemulti.js"></script>
    <script src="{{ asset('backend') }}/libary/selectM.js"></script>
    <script>
        CKEDITOR.replace('meta_description');
    </script>
@endsection
