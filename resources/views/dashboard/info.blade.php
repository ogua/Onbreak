<div class="row">

    @hasanyrole('Administrator')
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totuses }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <a href="#" class="small-box-footer">
                    {{ trans('Formfields.Moreinfo') }} <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totproduct }}</h3>
                <p>Total Products</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar"></i>
            </div>
            <a href="#" class="small-box-footer">
                Moreinfo <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    @endhasanyrole


    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $saleperday }}</h3>
                <p>Sales Per Day</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar"></i>
            </div>
            <a href="#" class="small-box-footer">
                Moreinfo <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>


    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $salepermonth }}</h3>
                <p>Sales Per Month</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar"></i>
            </div>
            <a href="#" class="small-box-footer">
                Moreinfo <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

</div>


<div class="row">


    @can('viewlasttermarrears')
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('Formfields.LastTermArrears') }}</span>
                    <span class="info-box-number">{{ Admin::user()->school->currency ?? 'Gh¢' }}
                        {{ number_format($arrears ?: 0, 2) }}</span>
                </div>
            </div>
        </div>
    @endcan

    {{-- @endif --}}

    @can('viewexpectedfees')

        @if (Admin::user()->uniqueid == 'd5604b40-025d-456a-ba25-69f5f0e2c265')
            @php
                $oxfordtotal = (int) $expectedfees + (int) $arrears;
            @endphp
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ trans('Formfields.ExpectedFees') }}</span>
                        <span class="info-box-number">{{ Admin::user()->school->currency ?? 'Gh¢' }}
                            {{ number_format($expectedfees ?: 0, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-4">
		<div class="info-box">
			<span class="info-box-icon bg-info"><i class="fas fa-dollar-sign"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Expected Fees + Last Term Arrers</span>
				<span class="info-box-number">{{ Admin::user()->school->currency ?? 'Gh¢' }} {{number_format($oxfordtotal ? : 0,2)}}</span>
			</div>
		</div>
	</div> --}}
        @else
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ trans('Formfields.ExpectedFees') }}</span>
                        <span class="info-box-number">{{ Admin::user()->school->currency ?? 'Gh¢' }}
                            {{ number_format($expectedfees ?: 0, 2) }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if (Admin::user()->uniqueid == '23cd37b8-9657-420c-b9d2-6651f5c080ce')
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ trans('Formfields.ofeeamount') }}</span>
                        <span class="info-box-number">{{ Admin::user()->school->currency ?? 'Gh¢' }}
                            {{ number_format($otherfeetotal ?: 0, 2) }}</span>
                    </div>
                </div>
            </div>
        @endif
    @endcan

    @can('viewtotalfeesreceivedthisterm')
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('Formfields.TotalFeesReceivedThisTerm') }}</span>
                    <span class="info-box-number">{{ Admin::user()->school->currency ?? 'Gh¢' }}
                        {{ number_format($totaltermnow ?: 0, 2) }}</span>
                </div>
            </div>
        </div>
    @endcan

    @can('viewexpectedowings')
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-teal"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('Formfields.ExpectedOwings') }}</span>
                    @php
                        $totalowe = $arrears + $amountleft;
                    @endphp
                    <span class="info-box-number">{{ Admin::user()->school->currency ?? 'Gh¢' }}
                        {{ number_format($totalowe ?: 0, 2) }}</span>
                </div>
            </div>
        </div>
    @endcan

    @can('viewtotalfeespayablethismonth')
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('Formfields.TotalFeesPayableThisMonth') }}</span>
                    <span class="info-box-number">{{ Admin::user()->school->currency ?? 'Gh¢' }}
                        {{ number_format($totalmonth ?: 0, 2) }}</span>
                </div>
            </div>
        </div>
    @endcan

    @can('viewtotalfeesreceivedtoday')
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('Formfields.TotalFeesReceivedToday') }}</span>
                    <span class="info-box-number">{{ Admin::user()->school->currency ?? 'Gh¢' }}
                        {{ number_format($totaltoday ?: 0, 2) }}</span>
                </div>
            </div>
        </div>
    @endcan


</div>

{{-- <div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Expense Report</h5>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-footer">
				<div class="row">
					<div class="col-sm-3 col-6">
						<div class="description-block border-right">
							<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 17%</span>
							<h5 class="description-header">$35,210.43</h5>
							<span class="description-text">TOTAL REVENUE</span>
						</div>
					</div>
					<div class="col-sm-3 col-6">
						<div class="description-block border-right">
							<span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0%</span>
							<h5 class="description-header">$10,390.90</h5>
							<span class="description-text">TOTAL COST</span>
						</div>
					</div>
					<div class="col-sm-3 col-6">
						<div class="description-block border-right">
							<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> 20%</span>
							<h5 class="description-header">$24,813.53</h5>
							<span class="description-text">TOTAL PROFIT</span>
						</div>
					</div>
					<div class="col-sm-3 col-6">
						<div class="description-block">
							<span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> 18%</span>
							<h5 class="description-header">1200</h5>
							<span class="description-text">GOAL COMPLETIONS</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> --}}



<div class="row">
    {{-- @can('viewaccountmanagement')
	<div class="col-md-8">
		<div class="card card-primary card-outline">
			<div class="card-body">
				<canvas id="myChart" style="height:230px"></canvas>
			</div>
		</div>
	</div>
	@endcan --}}

    @can('viewtotalattendance')
        <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
                <span class="info-box-icon"><i class="fas fa-user-check"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('Formfields.TotalAttendance') }}</span>
                    <span class="info-box-number">{{ $totalattendance }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
    @endcan


    @can('viewtotalabsenttoday')
        <div class="col-md-4">

            <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="fas fa-times"></i></span>
                @php
                    $totlabsent = $totalstudents - $totalattendance;
                @endphp
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('Formfields.TotalAbsent') }}</span>
                    <span class="info-box-number">{{ $totlabsent }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    @endcan

    @can('viewtotalmale')
        <div class="col-md-4">
            <div class="info-box mb-3 bg-success">
                <span class="info-box-icon"><i class="far fa-user"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('Formfields.TotalMale') }}</span>
                    <span class="info-box-number">{{ $totalmale }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
    @endcan

    @can('viewtotalfemale')
        <div class="col-md-4">
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
                <span class="info-box-icon"><i class="fas fa-female"></i></span>
                @php
                    $totolfemale = $totalstudents - $totalmale;
                @endphp
                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('Formfields.TotalFemale') }}</span>
                    <span class="info-box-number">{{ $totolfemale }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    @endcan

    @can('viewtotalclasses')
        <div class="col-md-4">
            <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="fas fa-university"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">{{ trans('Formfields.TotalClasses') }}</span>
                    <span class="info-box-number">{{ $totalclasses }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    @endcan
</div>