@extends('layout/admin')

@section('content')
<h2 class="page-title">Dashboard <small>Statistics</small></h2>
<div class="row">
    <div class="col-md-2 col-sm-4 col-xs-6">
        <div class="box">
            <div class="icon">
                <i class="glyphicon glyphicon-book"></i>
            </div>
            <div class="description">
                <strong>{{$post_count}}</strong> Posts
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
        <div class="box">
            <div class="icon">
                <i class="glyphicon glyphicon-user"></i>
            </div>
            <div class="description">
                <strong>{{$user_count}}</strong> Users
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-4 col-xs-6">
        <div class="box">
            <div class="icon">
                <i class="glyphicon glyphicon-list"></i>
            </div>
            <div class="description">
                <strong>{{$slide_count}}</strong> Slides
            </div>
        </div>
    </div>   
    <div class="col-md-2 col-sm-4 col-xs-6">
        <div class="box">
            <div class="icon">
                <i class="fa fa-font"></i>
            </div>
            <div class="description">
                <strong>{{$language_count}}</strong> Languages
            </div>
        </div>
    </div>    
</div>
<div class="row">
    <div class="col-md-4">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-arrow-right"></i>
                   New Posts
                </h4>
            </header>
            <div class="body">
                @foreach($post_new as $post)
                    <a href="{{url('system/posts/'.$post->id.'/edit?template='.$post->template->template)}}"><h5 class="mt-0 mb-xs weight-normal">- {{@$post->translateOrDefault()->title}}</h5></a>
                @endforeach                
            </div>
        </section>
    </div>    
    <div class="col-md-4">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-arrow-right"></i>
                    New Users
                </h4>
            </header>
            <div class="body">
                @foreach($user_new as $obj)
                    <a href="{{url('system/users/'.$obj->id.'/edit')}}"><h5 class="mt-0 mb-xs weight-normal">- {{$obj->firstname.' '.$obj->lastname}}</h5></a>
                @endforeach                
            </div>
        </section>
    </div>
    <div class="col-md-4">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-arrow-right"></i>
                    New Slide
                </h4>
            </header>
            <div class="body">
                @foreach($slide_new as $obj)
                    <a href="{{url('system/sliders/'.$obj->id.'/edit')}}"><h5 class="mt-0 mb-xs weight-normal">- {{$obj->name}}</h5></a>
                @endforeach                
            </div>
        </section>
    </div>
</div>
@stop