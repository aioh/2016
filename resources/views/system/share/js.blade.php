<script>
$_token = "{{ csrf_token() }}";
function deleteObj(obj)
{
    check = confirm('Do you want to delete this element?');
    if(check){
        var ajax = $(obj).hasClass('form-ajax');
        if(ajax){
            $.ajax({
                url: $(obj).attr('action'),
                method : 'post',
                data : {_method: 'delete',_token:$_token}
            }).done(function(data) {
                json = JSON.parse(data);
                if(json.code==200){                    
                    if(json.data.delete!=''){
                        $(obj).closest(json.data.delete).remove();                        
                    }
                    Messenger({
                        type: "error",
                        // extraClasses:'messenger-fixed messenger-on-right messenger-on-top'
                    }).post(json.message);
                }else{
                    Messenger({
                        // extraClasses:'messenger-fixed messenger-on-right messenger-on-top'
                    }).post({
                            message:json.message,
                            type:'error'
                        });
                }
            });
            return false;
        }else{
            $(obj).append('<input type="text" name="_token" value="'+$_token+'"/>');
            $(obj).append('<input type="text" name="_method" value="delete"/>');
            $(obj).submit();
        }
    }
}

@if(Session::get('response'))        
   
    Messenger().post('{{Session::get('response')}}');
@endif

</script>
<script>
    $('.date-picker').datetimepicker({
        pickTime: false,
        format: 'YYYY-MM-DD'
    });
    $('.date-time-picker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm'
    });
var ck_config = {
    toolbar: [
    { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source'] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike',] },
    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-'] },
    { name: 'links', items: [ 'Link', 'Unlink' ] },
    { name: 'insert', items: [ 'Image' ] },
    { name: 'styles', items: [ 'FontSize' ] },
    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
    ],
    enterMode: CKEDITOR.ENTER_BR,
    contentsCss: "{{asset('assets/admin/vendors/ck/ck.css')}}",                
    height:200
};
@if(isset($editor) > 0)
    @foreach ($editor as $item)
    var editor = CKEDITOR.replace({{$item}},ck_config);
    CKFinder.setupCKEditor( editor, "{{asset('assets/admin/vendors/ck/finder')}}" ); 
    @endforeach
@endif
// setting images upload and reorder
sortings = [];
@if(isset($tmp_image) > 0)
    @foreach ($tmp_image as $key=>$key) {
        sortings[{{$key}}] = {{json_encode($key,true)}}
    @endforeach
@endif
</script>