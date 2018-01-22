@extends('menu.index')
@section('content')
<perfil :data="{{ json_encode($v_datos) }}"></perfil>
@endsection