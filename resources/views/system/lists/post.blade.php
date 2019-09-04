@extends('layout/admin')

@section('content')
    <h2 class="page-title"><?php echo $title?></h2>
    <div class="row">
        <div class="col-lg-12">
            <section class="widget">                
                <div class="body">                        
                    <div class="mt">
                        {!! Form::open(array('url'=>url('system/posts?template='.Input::get('template')),'method'=>'get','files'=>true))!!}
                        <input type="hidden" name="template" value="{{Input::get('template')}}"> 
                        <input type="text" name="search" class=""> 
                        <button class="btn btn-primary" type="submit">Search</button>
                        {!! Form::close() !!}
                        <table id="datatable-table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Template</th>                       
                                    <th>parent</th>                       
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                <tr>
                                    <td>{{$post->id}}</td>
                                    <td>{{$post->title}}</td>
                                    <td>{{$post->template->template}}</td>
                                    <td>
                                    {{$post->parent->title or ''}}
                                    </td>
                                    <td>
                                        <a href="{{url('system/posts/'.$post->id)}}/edit?template={{$template}}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp
                                        @if($post->template->is_delete)
                                            <form action='{{url('system/posts/'.$post->id)}}' class='inline-control form-ajax' onclick='return(deleteObj(this))'><a class='delete-link'><i class='fa fa-trash-o'></i></a></form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($posts->count()>0)
                            {!! $posts->appends(['template' => $post->template->template,'search'=>$search])->render() !!}
                        @endif
                    </div>
                </div>
            </section>
        </div>            
    </div>
    <div class="loader-wrap hiding hide">
        <i class="fa fa-circle-o-notch fa-spin"></i>
    </div>
@stop