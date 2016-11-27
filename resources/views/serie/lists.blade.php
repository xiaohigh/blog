@extends('layout.home')

@section('con')
    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">
                <div id="posts" class="post-grid grid-3 clearfix series">
                    @foreach($series as $k=>$v)
                    <div class="entry clearfix">
                        <div class="entry-image">
                            <a href="/serie/{{$v->id}}.html"><img class="image_fade" src="{{env('IMG_URL')}}/{{$v->profile}}" alt="{{ $v->title }}" style="opacity: 1;"></a>
                        </div>
                        <div class="entry-title">
                            <h2><a href="/serie/{{$v->id}}.html">{{$v->title}}</a></h2>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </section>
@endsection