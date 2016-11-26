@extends('login.login')

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
							<a href="#" data-lightbox="image"><img class="image_fade" src="{{$v->pic}}" alt="Post Image"></a>
						</div>
						<div class="entry-title">
							<h2><a href="{{url('/post',['id'=>$v->id])}}">{{$v->title}}</a></h2>
						</div>
						<ul class="entry-meta clearfix">
							<li><i class="icon-calendar3"></i> {{$v->created_at}}</li>
							<li><a href="#"><i class="icon-user"></i> {{$v->user->name}}</a></li>
							<li><i class="icon-folder-open"></i> <a href="#">{{$v->cate->name}}</a></li>
						</ul>
						<div class="entry-content">
							<a href="{{url('/post',['id'=>$v->id])}}"class="more-link">去瞅瞅</a>
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
			{!!slider()!!}
			<!-- .sidebar end -->
				
		</div>

	</div>

</section>	
@endsection