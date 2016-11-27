@extends('layout.home')

@section('con')
<section id="content">

	<div class="content-wrap">

		<div class="container clearfix">

			<!-- Post Content
			============================================= -->
			<div class="postcontent nobottommargin clearfix">

				<!-- Posts
				============================================= -->
				@foreach($posts as $k=>$v)
				<div id="posts">

					<div class="entry clearfix">
						<div class="entry-image">
							<a href="{{route('post-detail',['id'=>$v->id])}}"><img class="image_fade" src="{{env('IMG_URL')}}/{{$v->pic}}" alt="{{$v->title}}"></a>
						</div>
						<div class="entry-title">
							<h2><a href="{{route('post-detail',['id'=>$v->id])}}">{{$v->title}}</a></h2>
						</div>

					</div>

				</div><!-- #posts end -->
				@endforeach
				<!-- Pagination
				============================================= -->
				@if ($posts->lastPage() > 1)
					<ul class="pager">
					    <li class="{{ ($posts->currentPage() == 1) ? ' disabled' : '' }}">
					        <a href="{{ $posts->url(1) }}">上一页</a>
					    </li>
					    
					    <li class="{{ ($posts->currentPage() == $posts->lastPage()) ? ' disabled' : '' }}">
					        <a href="{{ $posts->url($posts->currentPage()+1) }}" >下一页</a>
					    </li>
					</ul>
				@endif
				<!-- .pager end -->

			</div><!-- .postcontent end -->

			<!-- Sidebar
			============================================= -->
			{!!\App\Http\Controllers\IndexController::slider()!!}
			<!-- .sidebar end -->
				
		</div>

	</div>

</section>	
@endsection