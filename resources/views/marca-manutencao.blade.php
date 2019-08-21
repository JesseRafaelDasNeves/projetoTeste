@extends('layouts.app')

@section('content')

    @if(isset($marca))
    <h5><b>{{$nomeFormulario}}</b></h5>
    @endif

    @if(isset($errors) && count($errors) > 0)

    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}.</li>
            @endforeach
        </ul>
    </div>

    @endif

    @switch($tipoForm)
        @case(10)
            <form method="post" action="{{route('marcas.store', ['currentPage' => $currentPage])}}">
        @break
        @case(11)
            <form method="post" action="{{route('marcas.update', ['id' => $marca->id, 'currentPage' => $currentPage])}}">
            @method('PUT')
        @break
        @case(12)
            <form method="post" action="{{route('marcas.destroy', ['id' => $marca->id, 'currentPage' => $currentPage])}}">
            @method('DELETE')
        @break
    @endswitch

    @csrf

    <div class="form-group">
        <label>Código:</label>
        <input type="text" name="codigo" {{$readonly}} class="form-control" value="{{$marca->codigo}}">
    </div>

    <div class="form-group">
        <label>Nome:</label>
        <input type="text" name="nome" {{$readonly}} class="form-control" value="{{$marca->nome}}">
    </div>

    <div class="btn-group-sm">

        @switch($tipoForm)
            @case(12)
                <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
            @break
            @default
                <button type="submit" class="btn btn-primary">Confirmar</button>
        @endswitch

        <a class="btn btn-primary" href="{{route('marcas.index')}}" role="button">Cancelar</a>
    </div>
</form>

@endsection