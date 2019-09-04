<nav id="sidebar" class="sidebar nav-collapse collapse">
    <ul id="side-nav" class="side-nav">
        <li class="active">
            <a href="{{url('system/dashboard')}}"><i class="fa fa-home"></i> <span class="name">Dashboard</span></a>
        </li>
        <?php $nav_post = SystemHelper::getTemplatesPost(); ?>
        @if(count($nav_post)>0)
            @foreach(SystemHelper::getTemplatesPost() as $template)
                @if($template->is_show)
                    <li class="panel">
                        <a class="accordion-toggle collapsed" data-toggle="collapse"
                        data-parent="#side-nav" href="#{{$template->template}}-collapse"><i class="fa fa-pencil"></i> <span class="name">{{$template->template}}</span></a>
                        <ul id="{{$template->template}}-collapse" class="panel-collapse collapse ">
                            <li class=""><a href="{{url('system/posts?template='.$template->template)}}">All {{$template->template}}</a></li>                
                            @if($template->is_create==1||Auth::user()->role->priority==9)
                            <li class=""><a href="{{url('system/posts/create?template='.$template->template)}}">New {{$template->template}}</a></li>                  
                            @endif
                        </ul>
                    </li> 
                @endif
            @endforeach
        @endif
        <?php $nav_pages = SystemHelper::getTemplatesPage(); ?>
        @if(count($nav_pages)>0)
        <li class="panel">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
            data-parent="#side-nav" href="#page-collapse"><i class="fa fa-pencil"></i> <span class="name">Page</span></a>            
            <ul id="page-collapse" class="panel-collapse collapse ">
                @foreach($nav_pages as $page)
                    @if(isset($page->posts[0]))
                        <li class=""><a href="{{url('system/posts/'.$page->posts[0]->id.'/edit?template='.$page->template)}}">{{$page->template}}</a></li>                                                        
                    @endif
                    @if(Auth::user()->role->priority==9)
                    <li class=""><a href="{{url('system/posts/create?template='.$page->template)}}">Create {{$page->template}}</a></li>                
                    @endif
                @endforeach
            </ul>
        </li>
        @endif 
        <li class="panel">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
            data-parent="#side-nav" href="#users-collapse"><i class="fa fa-users"></i> <span class="name">Users</span></a>
            <ul id="users-collapse" class="panel-collapse collapse ">
                <li class=""><a href="{{url('system/users')}}">All Users</a></li>
                @if(Auth::user()->role->priority==9)
                    <li class=""><a href="{{url('system/users/create')}}">New User</a></li>  
                @endif
            </ul>
        </li>
        <li class="panel">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
            data-parent="#side-nav" href="#slider-collapse"><i class="fa fa-list"></i> <span class="name">Sliders</span></a>
            <ul id="slider-collapse" class="panel-collapse collapse">
                <li class=""><a href="{{url('system/sliders')}}">All Sliders</a></li>
                <li class=""><a href="{{url('system/sliders/create')}}">New Slider</a></li>  
            </ul>
        </li> 
        <li class="panel">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
            data-parent="#side-nav" href="#menu-collapse"><i class="fa fa-list"></i> <span class="name">Menus</span></a>
            <ul id="menu-collapse" class="panel-collapse collapse">
                <li class=""><a href="{{url('system/menus')}}">All Menus</a></li>
                @if(Auth::user()->role->priority==9)
                <li class=""><a href="{{url('system/menus/create')}}">New Menu</a></li>  
                @endif
            </ul>
        </li>
        @if(Auth::user()->role->priority==9)
        <li class="panel">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
            data-parent="#side-nav" href="#template-collapse"><i class="fa fa-list"></i> <span class="name">Templates</span></a>
            <ul id="template-collapse" class="panel-collapse collapse">
                <li class=""><a href="{{url('system/templates')}}">All Templates</a></li>
                <li class=""><a href="{{url('system/templates/create')}}">New Template</a></li>  
            </ul>
        </li>           
        <li class="panel">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
            data-parent="#side-nav" href="#language-collapse"><i class="fa fa-list"></i> <span class="name">Languages</span></a>
            <ul id="language-collapse" class="panel-collapse collapse">
                <li class=""><a href="{{url('system/languages')}}">All Languages</a></li>
                <li class=""><a href="{{url('system/languages/create')}}">New Language</a></li>  
            </ul>
        </li>    
        @endif       
        <li class="panel">
            <a class="accordion-toggle collapsed" data-toggle="collapse"
            data-parent="#side-nav" href="#setting-collapse"><i class="fa fa-cog"></i> <span class="name">Setting</span></a>
            <ul id="setting-collapse" class="panel-collapse collapse">
                <li class=""><a href="{{url('system/settings/show')}}">Edit Setting</a></li>
                @if(Auth::user()->role->priority==9)
                    <li class=""><a href="{{url('system/settings')}}">All Setting</a></li>
                    <li class=""><a href="{{url('system/settings/create')}}">New Setting</a></li>  
                @endif
            </ul>
        </li>                      
        @if(env('IS_CODE'))
        <li class="panel">
            <a href="{{url('system/code')}}"><i class="fa fa-book"></i> <span class="name">Code</span></a>
        </li>            
        @endif           
        <li class="visible-xs">
            <a href="{{url('system/logout')}}"><i class="fa fa-sign-out"></i> <span class="name">Sign Out</span></a>
        </li>
    </ul>            
</nav>