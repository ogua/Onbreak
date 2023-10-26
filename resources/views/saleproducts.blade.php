<style>
	.tdborder{
		border: none;
	}
</style>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>S.N</th>
			<th>Img</th>
			<th>Name</th>
			<th>Price</th>
			<th>Qty</th>
			<th>Discount</th>
			<th>Total</th>
			<th></th>
		</tr>
	</thead>
	<tbody>

		@php
		  $subtotal = 0;
		@endphp

		@forelse($getproduct as $prod)
		<tr>
			<td>{{ $loop->iteration }}</td>
			<td>
				@if($prod->product->img)

				<img src="{{ asset('storage') }}/{{ $prod->product->img }}" width="80" height="80">

				@else

				<img src="{{ URL::to('images/logo.png') }}" width="80">

				@endif
			</td>
			<td>{{ $prod->product->name }} - {{ $prod->product->ptype }} </td>
			<td>Gh¢{{ $prod->price }}</td>
			<td>{{ $prod->qty }}</td>
			<td>{{ $prod->dscnt }}</td>
			@php
			$subtotal+=$prod->total;
			@endphp
			<td>Gh¢{{ $prod->total }}</td>
			<td><a href="#" class="delproduct btn btn-danger" data-cid="{{ $prod->id }}" data-title="{{ $prod->product->name }} - {{ $prod->product->ptype }}"><i class="fas fa-minus"></i></a></td>
		</tr>

		@empty

		<tr>
			<td colspan="8">
				<div class="alert alert-danger">No Record!</div>
			</td>
		</tr>
		@endforelse

		<tr>
			<td colspan="3"></td>
			<td colspan="5">Sub Total: Gh¢ <input type="text" id="dissubtot" value="{{ $subtotal }}" class="form-control" readonly></td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<td colspan="5">Discount (%): <input type="text" id="discont" class="form-control" value="0"></td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<td colspan="5">Total: <input type="text" id="distot" class="form-control" value="{{ $subtotal }}" readonly></td>
		</tr>
		<tr>
			<td colspan="3"></td>
			<td colspan="5">
				<ul class="list-unstyled" style="display: flex;align-items: center;justify-content: center;">
				<li class="mr-2"><a href="#" id="confirmsales" class="btn btn-info">Confirm Sales</a></li>
				{{-- <li><a href="#" class="btn btn-success">Print Bill</a></li> --}}
			</ul>
			</td>
		</tr>
	</tbody>
</table>