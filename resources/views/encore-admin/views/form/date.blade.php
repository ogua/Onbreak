<div {!! admin_attrs($group_attrs) !!}>
    
    <div class="offset-sm-2 col-sm-7">
        <label for="{{$id}}" class="col-form-label">
        {{$label}}
    </label>
        <div class="input-group"  style="width: 250px;">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="far {{ $icon }} fa-w"></i>
                </span>
            </div>
            <input {!! $attributes !!} />
        </div>
        @include('admin::form.error')
        @include('admin::form.help-block')
    </div>
</div>

<script require="datetimepicker" @script>
    $(this).datetimepicker(@json($options));
</script>
