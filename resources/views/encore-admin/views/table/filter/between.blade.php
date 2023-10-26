<div class="form-group row">
    @if((new \Jenssegers\Agent\Agent())->isMobile())
    <div class="col-12" style="width: 390px">
    @else
    <div class="col-8" style="width: 390px">
    @endif
            <label class="col-form-label">{{$label}}</label>
        <div class="input-group">
            <input type="text" class="form-control" placeholder="{{$label}}" name="{{$name['start']}}" value="{{ request()->input("{$column}.start", \Illuminate\Support\Arr::get($value, 'start')) }}">
            <span class="input-group-addon" style="border-left: 0; border-right: 0;">-</span>
            <input type="text" class="form-control" placeholder="{{$label}}" name="{{$name['end']}}" value="{{ request()->input("{$column}.end", \Illuminate\Support\Arr::get($value, 'end')) }}">
        </div>
    </div>
</div>
