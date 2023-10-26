<div {!! admin_attrs($group_attrs) !!}>

    

    <div class="offset-sm-2 col-sm-7">
        <label for="{{$id}}" class="col-form-label">{{$label}}</label>
        <div class="input-group" style="width: 150px">
            <input type="text" id="{{$id}}" name="{{$name}}" value="{{ $value }}" class="form-control {{$class}}" placeholder="0" style="text-align:right;" {!! $attributes !!} />
            <span class="input-group-addon">%</span>
        </div>
        @include('admin::form.error')
        @include('admin::form.help-block')

    </div>
</div>
