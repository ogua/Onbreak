<div class="form-group row">
    @if((new \Jenssegers\Agent\Agent())->isMobile())
    <div class="col-12">
    @else
    <div class="col-8">
    @endif
        <label class="col-form-label">{{$label}}</label>
        @include($presenter->view())
    </div>
</div>
