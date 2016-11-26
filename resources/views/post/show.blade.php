@extends('login.login')

@section('con')
<section id="content">

    <div class="content-wrap">

        <div class="container clearfix">

            <!-- Post Content
            ============================================= -->
            <div class="postcontent nobottommargin clearfix">

                <div class="single-post nobottommargin">

                    <!-- Single Post
                    ============================================= -->
                    <div class="entry clearfix">

                        <!-- Entry Title
                        ============================================= -->
                        <div class="entry-title">
                            <h1>{{$post->title}}</h1>
                        </div><!-- .entry-title end -->

                        <!-- Entry Meta
                        ============================================= -->
                        <ul class="entry-meta clearfix">
                            <li><i class="icon-calendar3"></i>{{substr($post->created_at, 0, 10)}}</li>
                            <li><a href="{{url('post/list')}}?author={{$post->user->id}}"><i class="icon-user"></i> {{$post->user->name}}</a></li>
                            <li><i class="icon-folder-open"></i> <a href="{{url('post/list')}}?cate={{$post->cate->id}}">{{$post->cate->name}}</a></li>
                        </ul><!-- .entry-meta end -->
                        <hr>
                        <!-- Entry Image
                        ============================================= -->
                        <!-- <div class="entry-image">
                            <a href="#"><img src="{{$post->pic}}" alt=""></a>
                        </div> --><!-- .entry-image end -->

                        <!-- Entry Content
                        ============================================= -->
                        <div class="entry-content notopmargin">
                            {!!markToHtml($post->content)!!}
                        </div>
                    </div><!-- .entry end -->
                    <div class="tagcloud clearfix bottommargin">
                        <a href="javascript:void(0)">相关标签</a>
                        @foreach($post->tag as $k=>$v)
                        <a href="{{url('post/list')}}?tag={{$v->name}}">{{$v->name}}</a>
                        @endforeach
                    </div>
                   
                </div>

            </div>

            <!-- Sidebar
            ============================================= -->
            {!!slider()!!}
            <!-- .sidebar end -->

        </div>

    </div>

</section>
@endsection