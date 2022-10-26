<x-print-layout>
	{{-- <x-slot name="css">
		<link rel="stylesheet" href="{{ asset('css/print-style.css') }}">
	</x-slot> --}}

	<section class="print-preview-a4">
		<header>
			<x-para-clinic.print-header :row="$row" title="Invoice">
			</x-para-clinic.print-header>
		</header>
		<section class="prescription-body">
			<table class="my-2">
				<tr class="text-center">
					<th class="text-center" style="text-align: center;">N&deg;</th>
					<th>Service</th>
					<th>Description</th>
					<th style="text-align: center;" width="50px">QTY</th>
					<th style="text-align: center;" width="100px">Price</th>
					<th style="text-align: center;" width="150px">Total</th>
				</tr>
				@foreach ($row->detail as $i => $detail)
					<tr>
						<td class="text-center">{{ str_pad(++$i, 2, '0', STR_PAD_LEFT) }}</td>
						<td>{{ $detail->service_name }}</td>
						<td>{{ $detail->description }}</td>
						<td style="text-align: center;">{{ $detail->qty }}</td>
						<td style="text-align: center;">{{ $detail->price }}</td>
						<th style="text-align: center;">{{ number_format($detail->total, 2) }} USD</th>
					</tr>
				@endforeach
				<tr>
					<td colspan="3" class="text-right">Total USD: </td>
					<th colspan="3" style="text-align: right;">USD {{ number_format($row->total, 2) }}</th>
				</tr>
				<tr>
					<td colspan="3" class="text-right">Echange Rate : </td>
					<th colspan="3" style="text-align: right;">KHR/USD {{ number_format($row->exchange_rate, 0) }}</th>
				</tr>
				<tr>
					<td colspan="3" class="text-right">Total KHR : </td>
					<th colspan="3" style="text-align: right;">KHR {{ number_format($row->total * $row->exchange_rate, 0) }}</th>
				</tr>
			</table>
		</section>
		
		<!-- <div class="bring-this-back">(សូមយកវេជ្ជបញ្ជានេះមកជាមួយ ពេលពិនិត្យលើកក្រោយ)</div> -->
	</section>
</x-print-layout>