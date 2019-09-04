<nav class="navbar">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a href="#" class="navbar-brand visible-xs">
      <img src="{{asset('assets/site/images/logo.jpg')}}">
    </a>
  </div>
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">  
    <ul class="pull-left nav nav-justified">
      <?php
        $header = SystemHelper::getMenus('header');
      ?>
      @foreach($header->posts as $item)
        <?php $temp_item = $item->translateOrDefault(Session::get('language_local')); ?>
        <li>          
          <a style="padding: 0 10px !important;" href="{{url($item->slug)}}" @if($temp_item->id==10) target="_blank" @endif >{{$temp_item->menu_title}}</a>
        </li>
      @endforeach     
      <li class="visible-xs tel-xs"><a href="#">{{$setting['tel']}} {{$setting['text_tel']}}</a></li>
    </ul>
  </div><!-- /.container-fluid -->
</div>
    </div>  
  </div><!-- /.container-fluid -->
</nav>