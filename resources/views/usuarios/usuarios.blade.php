@extends('menu.index')
@section('content')
	<usuario :data="{{ json_encode($data) }}"></usuario>
@endsection