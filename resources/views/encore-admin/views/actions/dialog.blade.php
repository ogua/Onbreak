<script>
$('{{ $selector }}').off('{{ $event }}').on('{{ $event }}', function() {
    var data = $(this).data();
    var $target = $(this);
    var url = $(this).attr('url') || '{{ $url }}';
    Object.assign(data, @json($parameters));
    {!! $action_script !!}
    var options = {};
    Object.assign(options, @json($options));
    options.preConfirm = function(input) {
        return new Promise(function(resolve, reject) {
            $.LoadingOverlay("show");
            $.ajax({
                method: '{{ $method }}',
                url: url,
                data: data
            }).done(function (data) {
                resolve(data);
                $.LoadingOverlay("hide");
            }).fail(function(request){
                reject(request);
                $.LoadingOverlay("hide");
            });
        });
    };

    $.admin.confirm(options).then(function(result) {
        if (typeof result.dismiss !== 'undefined') {
            return Promise.reject();
        }
        return [result.value, $target];
    }).then($.admin.action.then).catch($.admin.action.catch);
});
</script>
