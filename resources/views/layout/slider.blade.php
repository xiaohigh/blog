<div class="sidebar nobottommargin col_last clearfix">
    <div class="sidebar-widgets-wrap">

        <div class="widget clearfix">

            <div class="tabs nobottommargin clearfix" id="sidebar-tabs">

                <h4>文章推荐</h4>

                <div class="tab-container" id="recom">

                    <div class="tab-content clearfix" id="tabs-1">
                        <div id="popular-post-list-sidebar">
                            @foreach($hottest as $k=>$v)
                            <div class="spost clearfix">
                                <div class="entry-c">
                                    <div class="entry-title">
                                        <h4><a href="#">{{$v->title}}</a></h4>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <div class="widget clearfix">

            <h4>云标签</h4>
            <div class="tagcloud">
                @foreach($tags as $k=>$v)
                <a href="{{url('post/list')}}?tag={{$v->name}}">{{$v->name}}</a>
                @endforeach
            </div>

        </div>

    </div>

</div>