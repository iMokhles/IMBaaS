@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1>
        {{ trans('backpack::base.dashboard') }}<small> Statics</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('backpack::base.dashboard') }}</li>
      </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        @foreach($statics as $static)
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-{{$static['color']}}">
                    <div class="inner">
                        <h3>{{$static['count']}}</h3>

                        <p>{{$static['title']}}</p>
                    </div>
                    <div class="icon">
                        <i class="fa {{$static['icon']}}"></i>
                    </div>
                    <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

        @endforeach
    </div>
@endsection
