<div {!! admin_attrs($group_attrs) !!}>
    
    <div class="offset-sm-2 col-sm-7">
        <label for="{{$id}}" class="col-form-label">{{$label}}</label>
        <div class="input-group" style="width: 300px;">
            <span class="input-group-prepend">
                <span class="input-group-text py-0">
                   <img @el src="{{ captcha_src() }}" style="height:30px;cursor: pointer;"  title="Click to refresh"/>
                </span>
            </span>
            <input {!! $attributes !!} />
        </div>
        @include('admin::form.error')
        @include('admin::form.help-block')
    </div>
</div>

<script>
    @el.click(function () {
        $(this).attr('src', $(this).attr('src')+'?'+Math.random());
    });
</script>
