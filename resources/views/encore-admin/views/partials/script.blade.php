<script data-exec-on-popstate>
require(@json($requires), function ({{ implode(',', $exports) }}) {
    @foreach($script as $s)

{!! $s !!}
    @endforeach
    //NProgress.configure({ parent: '.main-header' });

    $(document).on('click','.changelocal',function(e){
        e.preventDefault();
        var local = $(this).data('locale');
        $.ajax({
            beforeSend: function(){
              $.LoadingOverlay("show");
          },
          complete: function(){
              $.LoadingOverlay("hide");
          },
          url: '/set-locale/'+local,
          type: 'get',
          data: {},
          success: function(data){
            location.reload();
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
    });

    // $(document).on('click','button[type=submit]',function(e){
    //     e.preventDefault();
    //     alert('submit clicked');        
    // });

    $.ajaxSetup({
     headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
   });



});
</script>


