<div {!! admin_attrs($group_attrs) !!}>
    <div class="offset-sm-2 col-sm-7">
        <label for="{{$id}}" class="col-form-label">{{$label}}</label>
        <textarea class="form-control {{$class}}" id="{{$id}}" name="{{$name}}" placeholder="{{ $placeholder }}" {!! $attributes !!} >{{ $value }}</textarea>
        @include('admin::form.error')
        @include('admin::form.help-block')
    </div>
</div>
