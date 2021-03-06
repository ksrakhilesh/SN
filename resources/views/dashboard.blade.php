@extends('layouts.master')
@section('title')
Dashboard
@stop
@section('styles')
{{ Html::style('src/css/main.css') }}
@stop
@section('content')
<section class="row new-post">
	<div class="col-md-6 col-md-offset-3">
		<header>
			<h3>Hello {{ Auth::user()->name }} !</h3>
		</header><!-- /header -->
		{!! Form::open(['route' => ['post.create']]) !!}
		{!! Form::textarea('new-post', null, ['class' => 'form-control' , 'rows' => '5' , 'placeholder' => 'Whats on your mind?' ]) !!}
		{!! Form::submit('Create Post', ['class' => 'btn btn-primary dotopspace']) !!}
		{!! Form::close() !!}
	</div>
</section>
<section class="row posts">
	<div class="col-md-6 col-md-offset-3">
		<header>
			<h4><strong>Posts by Everyone</strong></h4>
		</header><!-- /header -->
		@foreach ($posts as $post)
		<article class="post" data-postid = "{{ $post->id }}">
			<p>{{ $post->body }}</p>
			<div class="info">
				Posted By {{ $post->user->name }} on {{ date("D jS \of M Y h:ia" , strtotime($post->created_at)) }}
			</div>	
			<div class="interaction">
				<a href="#" class="like">{{ Auth::user()->likes()->where('post_id',$post->id)->first() ? Auth::user()->likes()->where('post_id',$post->id)->first()->like == 1 ? 'Liked' : 'Like' : 'Like' }}</a>
				<a href="#" class="like">{{ Auth::user()->likes()->where('post_id',$post->id)->first() ? Auth::user()->likes()->where('post_id',$post->id)->first()->like == 0 ? 'Disliked' : 'Dislike' : 'Dislike' }}</a>
				@if (Auth::user()->id == $post->user->id)
				<a href="#" class="edit"> | Edit</a>
				<a href="{{ route('post.delete', ['post_id' => $post->id]) }}"> | Delete </a>
				@endif

			</div>
		</article>
		@endforeach
	</div>
</section>
<div class="modal fade" tabindex="-1" role="dialog" id="edit-modal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edit Post</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="form-group">
						<label for="post-body">Edit the Post</label>
						<textarea class="form-control" name= "post-body" id = "post-body" rows="5"></textarea>

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="modal-save">Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
	var token = '{{ Session::token() }}';
	var urlEdit = '{{ route('edit') }}';
	var urlLike = '{{ route('like') }}';
</script>
@stop
@section('scripts')
{{ Html::script('src/js/app.js') }}
@stop
