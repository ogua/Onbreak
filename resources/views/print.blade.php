<link rel="stylesheet" href="{{ URL::to('bower_components/css/bootstrap.mins.css')}}">

<table class="table table-bordered">
	<thead>
		<tr>
			<th colspan="5">Supermarket Billing System</th>
		</tr>
	</thead>
	<thead>
		<tr>
			<th>S.N</th>
			<th>Name</th>
			<th>Price</th>
			<th>Qty</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>

		@php
		  $subtotal = 0;
		@endphp

		@forelse($getproduct->sales as $prod)
		<tr>
			<td>{{ $loop->iteration }}</td>
			<td>{{ $prod->product->name }} - {{ $prod->product->ptype }} </td>
			<td>Gh¢{{ $prod->price }}</td>
			<td>{{ $prod->qty }}</td>
			@php
			$subtotal+=$prod->total;
			@endphp
			<td>Gh¢{{ $prod->total }}</td>
		</tr>

		@empty

		<tr>
			<td colspan="5">
				<div class="alert alert-danger">No Record!</div>
			</td>
		</tr>
		@endforelse

		<tr>
			<td colspan="2"></td>
			<td colspan="3">Sub Total: Gh¢{{ $getproduct->subtotal }}</td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="3">Discount: ({{ $getproduct->discount }}%)</td>
		</tr>
		<tr>
			<td colspan="2"></td>
			<td colspan="3">Total: Gh¢{{ $getproduct->total }} </td>
		</tr>
		<tr>
			<td colspan="5">
				<p class="text-center">Cashier: {{ $getproduct->user->name }}</p>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				<p class="text-center">Thank You For Shopping With Us!</p>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				<p class="text-center">Printed on: {{ date('Y-m-d H:i:s') }}</p>
			</td>
		</tr>
	</tbody>
</table>