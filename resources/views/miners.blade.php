@extends('base')

@section('head')
	<script type="text/javascript" src="{!! asset('js/miners.js') !!}"></script>
@endsection

@section('content')
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{!! url('/miners/refreshHost/') !!}" class="btn btn-success">Check hosts</a>
			<button onclick="refreshData();" class="btn btn-primary">Refresh data</button>
		</div>
	</div>

	@if($hosts)
		<table class="table table-striped table-hover">
			<caption class="text-right">
				Total rows: <span class="badge">{!! $count !!}</span>
			</caption>
			<thead>
			<tr>
				<th>#</th>
				<th>IP</th>
				<th>Elapsed</th>
				<th>HW</th>
				<th>GH/S</th>
				<th>Updated</th>
				<th></th>
			</tr>
			</thead>
			<tbody>

			@foreach ($hosts as $idx => $host)
				<tr{!! ($host->active ? '' : ' class="danger"') !!}>
					<td>{{$idx+1}}</td>
					<td>{{$host->ip}}</td>
					<td>{{$host->elapsed}}</td>
					<td>{{$host->hw}}</td>
					<td>{{$host->ghs_5s}}</td>
					<td>{{$host->updated_at}}</td>
					<td>
						<a href="{!! url('/miners/'. $host->id .'/refreshInfo/') !!}" class="btn btn-xs btn-primary">Refresh data</a>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>

	@else
		<h2>Список пуст!</h2>
	@endif

@endsection