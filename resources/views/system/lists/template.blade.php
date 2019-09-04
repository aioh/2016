@extends('layout/admin')

@section('content')
    <h2 class="page-title"><?php echo $title?></h2>
    <div class="row">
        <div class="col-lg-12">
            <section class="widget">
                <header>
                    <div class="widget-controls">
                        <a data-widgster="expand" title="Expand" href="#"><i class="glyphicon glyphicon-chevron-up"></i></a>
                        <a data-widgster="collapse" title="Collapse" href="#"><i class="glyphicon glyphicon-chevron-down"></i></a>
                        <a data-widgster="close" title="Close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                    </div>
                </header>
                <div class="body">                        
                    <div class="mt">
                        <table id="datatable-table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>            
    </div>
    <div class="loader-wrap hiding hide">
        <i class="fa fa-circle-o-notch fa-spin"></i>
    </div>
@stop

@section('script')
    <script>       
        $("#datatable-table").dataTable({
            stateSave: true,
            responsive: true,
            "ajax": "{{url('system/templates/get-all')}}",
            "columns": [
            { "data": "id" },
            { "data": "template" },                           
            ],
            "columnDefs": [            
            {                
                "render": function ( data, type, row ) {                    
                    var edit = '<a href="{{url('system/templates')}}/'+row.id+'/edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
                    var _delete = "<form action='{{url('system/templates/')}}/"+row.id+"' class='inline-control form-ajax' onclick='return(deleteObj(this))'><a class='delete-link'><i class='fa fa-trash-o'></i></a></form>";
                    return edit+' '+_delete;
                },
                "targets": 2     
            }
            ],
            "sDom": "<'row'<'col-md-6 hidden-xs'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
            "oLanguage": {
                "sLengthMenu": "_MENU_",
                "sInfo": "Showing <strong>_START_ to _END_</strong> of _TOTAL_ entries"
            },
            "oClasses": {
                "sFilter": "pull-right",
                "sFilterInput": "form-control ml-sm"
            }
        });
    $(".dataTables_length select").selectpicker({
        width: 'auto'
    });
    </script>
@stop