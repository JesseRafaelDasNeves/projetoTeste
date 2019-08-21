@extends('layouts.app')

@section('content')

@if(isset($success))
    <div class="alert alert-success alert-dismissible fade show" role="alert" >
        {{$success}}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="btn-group-sm" >
    <a href="{{route('marcas.create', ['currentPage' => $currentPage])}}" class="btn btn-primary">Incluir</a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th style="width: 200px;" scope="col">Código</th>
            <th scope="col">Descrição</th>
            <th style="width: 150px" scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($marcas))
            @foreach($marcas as $marca)
            <tr>
                <td>{{$marca->codigo}}</td>
                <td>{{$marca->nome}}</td>
                <td>
                    <div class="btn-group-sm">
                        <a href="{{route('marcas.edit', ['id' => $marca->id, 'currentPage' => $currentPage])}}" class="btn btn-secondary">Alterar</a>
                        <a href="{{route('marcas.show', ['id' => $marca->id, 'currentPage' => $currentPage])}}" class="btn btn-danger">Excluir</a>
                    </div>
                </td>
            </tr>
            @endforeach
        @endif

    </tbody>
</table>

{{$marcas->links()}}

@endsection