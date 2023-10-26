<script>
$('{{ $selector }}').off('{{ $event }}').on('{{ $event }}', function() {
    var data = $(this).data();
    var $target = $(this);
    $.LoadingOverlay("show");
    var url = $(this).attr('url') || '{{ $url }}';
    Object.assign(data, @json($parameters));
    {!! $action_script !!}
    new Promise(function (resolve,reject) {
        $.ajax({
            method: '{{ $method }}',
            url: url,
            data: data
        }).done(function (data) {
            resolve([data, $target]);
            $.LoadingOverlay("hide");
        }).fail(function(request){
            reject(request);
            $.LoadingOverlay("hide");
        });
    }).then($.admin.action.then).catch($.admin.action.catch);
});
</script>
