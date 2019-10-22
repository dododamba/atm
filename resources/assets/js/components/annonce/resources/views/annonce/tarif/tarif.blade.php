@extends('layout.app')
@section('content')
    <tarif></tarif>
@endsection
@section('js')
    <script>
        title = `Annonce`;
        cumb = `Liste des Annonce`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection