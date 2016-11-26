@extends('admin.index')

@section('content')
<link rel="stylesheet" href="{{asset('/b/css/listshow.css')}}">
<div class="mws-panel grid_8">
    <div class="mws-panel-header">
        <span>
            <i class="icon-table">
            </i>
            分类列表
        </span>
    </div>
    <div class="mws-panel-body no-padding">
        <div id="DataTables_Table_1_wrapper" class="dataTables_wrapper" role="grid">
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
                            分类名
                        </th>
                        <th class="sorting" role="columnheader" tabindex="0" aria-controls="DataTables_Table_1"
                        rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending"
                        style="width: 112px;">
                            操作
                        </th>
                    </tr>
                </thead>
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                	@foreach($cates as $k=>$v)
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
                            {{$v['name']}}
                        </td>

                        <td class=" ">
                            <a href="{{url('/admin/cate/edit', ['id' => $v['id']])}}" class="btn btn-primary">修改</a>
                            <a href="{{url('/admin/cate/delete', ['id' => $v['id']])}}" class="btn btn-warning">删除</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>
@endsection