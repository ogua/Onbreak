<div {!! admin_attrs($group_attrs) !!}>
    
    <div class="offset-sm-2 col-sm-7">
        <label for="{{$id}}" class="col-form-label">{{$label}}</label>
        <div class="{{$class}}">
            <p>{!! $value !!}</p>
        </div>
        <textarea name="{{$name}}" class="d-none" rows="{{ $rows }}" placeholder="{{ $placeholder }}" {!! $attributes !!} >{!! $value !!}</textarea>
        @include('admin::form.error')
        @include('admin::form.help-block')
    </div>
</div>

<script require="wangEditor" @script>
    var E = window.wangEditor;
    var $editor = new E(this);
    var $textarea = $(this).parent().find('textarea');
    $editor.customConfig.onchange = function (html) {
        $textarea.val(html);
    }
    $editor.customConfig.zIndex = 100;
    $editor.create();
</script>
