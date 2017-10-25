@extends('layouts.master')

@section('main-header')
    <h1>
        {{ __('LIST ROOMS OF POST') }}
        <small></small>
    </h1>
@endsection

@section('main-content')
    @if(isset($rooms))
    	@include('flash::message')
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ __("Room's Table Data") }}</h3>
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
                                    <th class="col-md-1">{{ __('Post') }}</th>
                                    <th class="col-md-1">{{ __('Cost') }}</th>
                                    <th class="col-md-1">{{ __('Subject') }}</th>
                                    <th class="col-md-1">{{ __('Status') }}</th>
                                    <th class="col-md-1">{{ __('Amount') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rooms as $room)
                                    <tr>
                                        <td>{{ $room->id }}</td>
                                        <td>{{ $room->post->title }}</td>
                                        <td>{{ $room->cost }}</td>
                                        <td>{{ $room->subject->subject }}</td>
                                        <td>
                                        	<form method="POST" action="/rooms/{{ $room->id }}">
                                        		<input type="hidden" name="_method" value="PUT">
                                        		<input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" name="status" value="{{ $room->status }}">
                                            	<button type="submit" class="btn-xs btn-primary"><i class="fa fa-certificate {{ ($room->status == 1) ? 'admin':'normal' }}"></i></button>
                                            </form>
                                        </td>
                                        <td>{{ $room->amount }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box-tools">
                    {{ $rooms->links() }}
                </div>
            </div>
        </div>
    @else
        <h1>{{ __('Nothing to show!') }}</h1>
    @endif

@endsection