@extends('template')

@section('titre')
Les produits
@endsection


@section('contenu')
<br>
<div class="col-6" style="margin:10px;">
    @if(session()->has('ok'))
    <div class="alert alert-success alert-dismissible">{!! session('ok') !!}</div>
    @endif
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Listes des produits</h3>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom du produit</th>
                    <th>Crée le ...</th>
                    <th>Modifié le ...</th>
                    <th>Description</th>
                    <th>Prix du produit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{!! $product->id !!}</td>
                    <td class="text-primary"><strong>{!! $product->name !!}</strong></td>
                    <td class="text-primary"><strong>{!! $product->created_at !!}</strong></td>
                    <td class="text-primary"><strong>{!! $product->updated_at !!}</strong></td>
                    <td class="text-primary"><strong>{!! $product->description !!}</strong></td>
                    <td class="text-primary"><strong>{!! $product->price !!}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
