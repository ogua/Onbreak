<div {!! admin_attrs($group_attrs) !!}>

    <div class="offset-sm-2 col-sm-7">
        <label for="{{$id}}" class="col-form-label">{{$label}}</label>
        <input type="text" id="{{$id}}" name="{{$name}}" value="{{$value}}" class="form-control" readonly {!! $attributes !!} />

        @include('admin::form.help-block')

    </div>
</div>
