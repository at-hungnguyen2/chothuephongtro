@extends('layouts.master')

@section('main-header')
    <h1>
        {{ __('LIST USERS') }}
        <small></small>
    </h1>
@endsection

@section('main-content')
    @if(isset($users))
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">{{ __("User's Table Data") }}</h3>
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
                                    <th class="col-md-1">{{ __('id') }}</th>
                                    <th class="col-md-3">{{ __('Name') }}</th>
                                    <th class="col-md-3">{{ __('Email') }}</th>
                                    <th class="col-md-1">{{ __('Gender') }}</th>
                                    <th class="col-md-1">{{ __('Admin') }}</th>
                                    <th class="col-md-1">{{ __('Active') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ($user->gender == 1) ? __('Male') : __('Female')}}</td>
                                        <td>
                                            <i class="fa fa-certificate {{ ($user->is_admin == 1) ? 'admin':'normal' }}"></i>
                                        </td>
                                        <td>
                                            <i class="fa fa-check {{ ($user->is_active == 1) ? 'active-user':'normal' }}"></i>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box-tools">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    @else
        <h1>{{ __('Nothing to show!') }}</h1>
    @endif

@endsection