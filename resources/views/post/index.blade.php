@extends('admin.index')

@section('content')
<link rel="stylesheet" href="{{asset('/b/css/listshow.css')}}">
<div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span>
            <i class="icon-table">
            </i>
            文章列表
        </span>
    </div>
    <div class="mws-panel-body no-padding">
        <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
            <form action="{{url('admin/post/index')}}" method="get">
            <div id="DataTables_Table_1_length" class="dataTables_length">
                <label>
                    显示
                    <select size="1" name="num" aria-controls="DataTables_Table_1">
                        <option value="10" @if($data['num'] == 10)
							selected 
						@endif
                        >
                            10
                        </option>
                        <option value="25" @if($data['num'] == 25)
							selected 
						@endif>
                            25
                        </option>
                        <option value="50" @if($data['num'] == 50)
							selected 
						@endif>
                            50
                        </option>
                        <option value="100" @if($data['num'] == 100)
							selected 
						@endif>
                            100
                        </option>
                    </select>
                </label>
            </div>
            <div id="DataTables_Table_1_length" class="dataTables_length">
                <label>
                    分类
                    <select size="1" name="cate_id" aria-controls="DataTables_Table_1">
                        <option value="0">请选择</option>
                        @foreach($cates as $k=>$v)
                        <option value="{{$v['id']}}" @if($data['cate_id'] == $v['id'])
                            selected 
                        @endif
                        >
                            {{$v['name']}}
                        </option>
                        @endforeach
                    </select>
                    
                </label>
            </div>
            <div class="dataTables_filter" id="DataTables_Table_1_filter">
                <label>
                    关键字:
                    <input type="text" value="{{$data['keywords']}}" aria-controls="DataTables_Table_1" name="keywords">
                    <button class="btn btn-default">搜索</button>
                </label>
            </div>
            </form>
            <table class="mws-datatable-fn mws-table dataTable" id="DataTables_Table_1"
            aria-describedby="DataTables_Table_1_info">
                <thead>
                    <tr role="row">
                        <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending"
                        style="width: 173px;">
                            ID
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending"
                        style="width: 222px;">
                            标题
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending"
                        style="width: 208px;">
                            分类
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending"
                        style="width: 147px;">
                            创建时间
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"
                        style="width: 112px;">
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                	@foreach($posts as $k=>$v)
                    <tr class="
					@if($k % 2 == 1)
						odd
					@else
						even
					@endif
                    ">
                        <td class=" sorting_1">
                            {{$v['id']}}
                        </td>
                        <td class=" ">
                            {{$v['title']}}
                        </td>
                        <td class=" ">
                            {{$v['names']}}
                        </td>
                        <td class=" ">
                            {{$v['created_at']}}
                        </td>
                        <td class=" ">
                            <a href="{{url('/admin/post/edit', ['id' => $v['id']])}}" class="btn btn-primary">修改</a>
                            <a href="{{url('/admin/post/delete', ['id' => $v['id']])}}" class="btn btn-warning">删除</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="dataTables_paginate">
                {!! $posts->appends($data)->render() !!}
            </div>
        </div>
    </div>
</div>
@endsection