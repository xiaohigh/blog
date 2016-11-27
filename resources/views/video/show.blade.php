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
                                <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
                                <video id='video'  class="video-js vjs-default-skin" controls data-setup='{"fluid": true}'>
                                    <source
                                            src="http://odq99fvnh.bkt.clouddn.com/{{$video->m3u8}}"
                                            type="application/x-mpegURL">
                                </video>
                                <script src="http://vjs.zencdn.net/5.8.8/video.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/3.6.0/videojs-contrib-hls.min.js"></script>
                            </div>
                            <!-- Entry Title
                            ============================================= -->
                            <div class="entry-title">
                                <h1>{{$video->serie->title}}</h1>
                            </div><!-- .entry-title end -->
                            <hr>
                            <div class="entry-content">
                                <div class="list-group">
                                    @foreach($videos as $k=>$v)
                                    <a href="/video/{{$v->id}}.html" class="list-group-item @if($v->id == $id) active @endif">
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