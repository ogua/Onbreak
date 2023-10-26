<div {!! admin_attrs($group_attrs) !!}>
    
    <div class="offset-sm-2 col-sm-7">
        <label for="{{$id}}" class="col-form-label">{{$label}}</label>
        <div class="input-group">
            <button id="@id" class="icon btn btn-@color {{ $class }}" data-icon="{{ $value ?: $default }}" name="{{ $name }}"></button>
        </div>
        @include('admin::form.error')
        @include('admin::form.help-block')
    </div>
</div>

<script require="iconpicker" @script>
    $(this).iconpicker({
        arrowClass: 'btn-@color',
        selectedClass: 'btn-@color',
        unselectedClass: '',
        placement: 'right',
    });
</script>
