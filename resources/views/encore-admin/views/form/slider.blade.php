<div {!! admin_attrs($group_attrs) !!}>

    

    <div class="offset-sm-2 col-sm-7">
        <label for="{{$id}}" class="col-form-label">{{$label}}</label>
        <input type="text" class="form-control {{$class}}" name="{{$name}}" data-from="{{ $value }}" {!! $attributes !!} />
        @include('admin::form.error')
        @include('admin::form.help-block')

    </div>
</div>

<script require="rangeSlider" @script>
    $(this).ionRangeSlider(@json($options));
</script>
