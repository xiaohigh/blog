@extends('layout.home')

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
                            <div class="entry-image">
                                <img src="{{env('IMG_URL')}}/{{$serie->profile}}" alt="">
                            </div>
                            <!-- Entry Title
                            ============================================= -->
                            <div class="entry-title">
                                <h1>{{$serie->title}}</h1>
                                <blockquote>
                                    <p>{{$serie->intro}}</p>
                                </blockquote>
                            </div><!-- .entry-title end -->
                            <hr>
                            <div class="entry-content">
                                <div class="list-group">
                                    @foreach($videos as $k=>$v)
                                        <a href="/video/{{$v->id}}.html" class="list-group-item">
                                            <i class="icon-play"></i>&nbsp;&nbsp;{{$v->title}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div><!-- .entry end -->

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