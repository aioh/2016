<!-- light-blue - v3.1.0 - 2014-12-06 -->
<!DOCTYPE html>
<html>
<head>
    <title>FM91BKK</title>
    <link href="{{asset('assets/admin/css/application.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/vendors/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/main.css')}}" rel="stylesheet">
    @yield('css','')
    <link rel="shortcut icon" href="{{asset('assets/admin/img/favicon.png')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">        
</head>
<body class="background-dark">
    <div class="logo">
        <h4><a href="index.html">FM91BKK <strong>TEST</strong></a></h4>
    </div>                
    @include('system.share.nav')
    <div class="wrap">
        <header class="page-header">
            <div class="navbar">
                <ul class="nav navbar-nav navbar-right pull-right">                                
                    <li class="divider"></li>
                    <li class="hidden-xs">
                        <a href="#" id="settings"
                        title="Settings"
                        data-toggle="popover"
                        data-placement="bottom">
                        <i class="fa fa-cog"></i>
                    </a>
                </li>
                <li class="hidden-xs dropdown">
                    <a href="#" title="Account" id="account"
                    class="dropdown-toggle"
                    data-toggle="dropdown">
                    <i class="fa fa-user"></i>
                </a>
                <ul id="account-menu" class="dropdown-menu account" role="menu">
                    <li role="presentation" class="account-picture">
                        <img src="{{asset('assets/admin/img/2.jpg')}}" alt="">
                        {{Auth::user()->firstname}} {{Auth::user()->lastname}}
                    </li>                        
                </ul>
            </li>
            <li class="visible-xs">
                <a href="#"
                class="btn-navbar"
                data-toggle="collapse"
                data-target=".sidebar"
                title="">
                <i class="fa fa-bars"></i>
            </a>
        </li>
        <li class="hidden-xs"><a href="{{url('system/logout')}}"><i class="fa fa-sign-out"></i></a></li>
    </ul>        
    <div class="languages pull-right">
        <div class="alert pull-right">
            <?php 
            $languages = SystemHelper::getLanguages();
            ?>
            @foreach($languages as $language)
            <a href="{{url('changeLanguage/'.$language->id)}}">{{$language->name}}</a>                    
            @endforeach
        </div>
    </div>
</div>
</header>        
<div class="content container">
    @yield('content','')
</div>
<div class="loader-wrap hiding hide">
    <i class="fa fa-circle-o-notch fa-spin"></i>
</div>
</div>
<!-- common libraries. required for every page-->
<script src="{{asset('assets/admin/lib/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/lib/jquery-pjax/jquery.pjax.js')}}"></script>
<script src="{{asset('assets/admin/lib/bootstrap-sass-official/assets/javascripts/bootstrap.js')}}"></script>
<script src="{{asset('assets/admin/lib/widgster/widgster.js')}}"></script>
<script src="{{asset('assets/admin/lib/underscore/underscore.js')}}"></script>
<script src="{{asset('assets/admin/lib/messenger/build/js/messenger.js')}}"></script>
<script src="{{asset('assets/admin/lib/messenger/build/js/messenger-theme-flat.js')}}"></script>
<script src="{{asset('assets/admin/lib/backbone/backbone.js')}}"></script>
<script src="{{asset('assets/admin/lib/messenger/docs/welcome/javascripts/location-sel.js')}}"></script>
<script src="{{asset('assets/admin/lib/messenger/build/js/messenger.js')}}"></script>
<script src="{{asset('assets/admin/lib/messenger/build/js/messenger-theme-flat.js')}}"></script>
<script src="{{asset('assets/admin/lib/jquery-ui/ui/core.js')}}"></script>
<script src="{{asset('assets/admin/lib/jquery-ui/ui/widget.js')}}"></script>
<script src="{{asset('assets/admin/lib/jquery-ui/ui/mouse.js')}}"></script>
<script src="{{asset('assets/admin/lib/jquery-ui/ui/sortable.js')}}"></script>
<script src="{{asset('assets/admin/lib/jquery.nestable/jquery.nestable.js')}}"></script>
<script src="{{asset('assets/admin/lib/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

<!-- common application js -->
<script src="{{asset('assets/admin/js/app.js')}}"></script>
<script src="{{asset('assets/admin/js/settings.js')}}"></script>
<script src="{{asset('assets/admin/vendors/ck/editor/ckeditor.js')}}"></script>
<script src="{{asset('assets/admin/vendors/ck/finder/ckfinder.js')}}"></script>
<script src="{{asset('assets/admin/js/ui-notifications.js')}}"></script>

<!-- common templates -->
<script type="text/template" id="settings-template">
    <div class="setting clearfix">
        <div>Background</div>
        <div id="background-toggle" class="pull-left btn-group" data-toggle="buttons-radio">
            <% dark = background == 'dark'; light = background == 'light';%>
            <button type="button" data-value="dark" class="btn btn-sm btn-default <%= dark? 'active' : '' %>">Dark</button>
            <button type="button" data-value="light" class="btn btn-sm btn-default <%= light? 'active' : '' %>">Light</button>
        </div>
    </div>
    <div class="setting clearfix">
        <div>Sidebar on the</div>
        <div id="sidebar-toggle" class="pull-left btn-group" data-toggle="buttons-radio">
            <% onRight = sidebar == 'right'%>
            <button type="button" data-value="left" class="btn btn-sm btn-default <%= onRight? '' : 'active' %>">Left</button>
            <button type="button" data-value="right" class="btn btn-sm btn-default <%= onRight? 'active' : '' %>">Right</button>
        </div>
    </div>
    <div class="setting clearfix">
        <div>Sidebar</div>
        <div id="display-sidebar-toggle" class="pull-left btn-group" data-toggle="buttons-radio">
            <% display = displaySidebar%>
            <button type="button" data-value="true" class="btn btn-sm btn-default <%= display? 'active' : '' %>">Show</button>
            <button type="button" data-value="false" class="btn btn-sm btn-default <%= display? '' : 'active' %>">Hide</button>
        </div>
    </div>    
</script>
<!-- page specific scripts -->           
<script src="{{asset('assets/admin/lib/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('assets/admin/lib/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/admin/lib/moment/moment.js')}}"></script>
<script src="{{asset('assets/admin/lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('assets/admin/lib/jquery.maskedinput/jquery.maskedinput.min.js')}}"></script>
<script src="{{asset('assets/admin/lib/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.js')}}"></script>
<script src="{{asset('assets/admin/lib/parsleyjs/dist/parsley.min.js')}}"></script>
<script src="{{asset('assets/admin/js/forms-article.js')}}"></script>
<script src="{{asset('assets/admin/lib/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/admin/vendors/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
@yield('script','')
@include('system.share.js')
</body>
</htm>