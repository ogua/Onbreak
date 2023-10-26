<div {!! admin_attrs($group_attrs) !!}>
    <div class="offset-sm-2 col-sm-7">
            <label class="col-form-label">{{$label}}</label>
        <div class="card card-solid card-default m-0">
            <!-- /.card-header -->
            <div class="card-body py-2 px-4">
                {!! $value !!}&nbsp;
            </div><!-- /.card-body -->
        </div>
        @include('admin::form.help-block')
    </div>
</div>
