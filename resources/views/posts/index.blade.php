@extends('layouts.master')

@section('main-header')
    <h1>
        {{ __('LIST USERS') }}
        <small></small>
    </h1>
@endsection

@section('main-content')
    @if(isset($posts))
    	@include('flash::message')
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ __("Posts's Table Data") }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="table_wrapper" class="table-responsive form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="table" class=" table table-bordered dataTable table-hover"
                                   role="grid"
                                   aria-describedby="table_info">
                                <thead>
                                <tr>
                                    <th class="col-md-1">{{ __('Id') }}</th>
                                    <th class="col-md-3">{{ __('Title') }}</th>
                                    <th class="col-md-3">{{ __('User') }}</th>
                                    <th class="col-md-1">{{ __('Post Type') }}</th>
                                    <th class="col-md-1">{{ __('Cost') }}</th>
                                    <th class="col-md-1">{{ __('Subject') }}</th>
                                    <th class="col-md-1">{{ __('District') }}</th>
                                    <th class="col-md-1">{{ __('Status') }}</th>
                                    <th class="col-md-1">{{ __('Active') }}</th>
                                    <th class="col-md-1">{{ __('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->user->name }}</td>
                                        <td>{{ $post->postType->type }}</td>
                                        <td>{{ $post->cost->cost }}</td>
                                        <td>{{ $post->subject->subject }}</td>
                                        <td>{{ $post->district->district }}</td>                                      
                                        <td>
                                        	<form method="POST" action="/posts/{{ $post->id }}">
                                        		<input type="hidden" name="_method" value="PUT">
                                        		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="status" value="{{ $post->status }}">
                                            	<button type="submit" class="btn-xs btn-primary"><i class="fa fa-certificate {{ ($post->status == 1) ? 'admin':'normal' }}"></i></button>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="POST" action="/posts/{{ $post->id }}">
                                                <input type="hidden" name="_method" value="PUT">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="is_active" value="{{ $post->is_active }}">
                                                <button type="submit" class="btn-xs btn-primary"><i class="fa fa-certificate {{ ($post->is_active == 1) ? 'admin':'normal' }}"></i></button>
                                            </form>
                                        </td>
                                        <td>
                                            <a class="btn-xs btn-default" href="{{ route('rooms.index', $post->id) }}"><i class="fa fa-search"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box-tools">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    @else
        <h1>{{ __('Nothing to show!') }}</h1>
    @endif

@endsection