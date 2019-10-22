@extends('layout.app')
@section('content')
    <positionannonce></positionannonce>
@endsection
@section('js')
    <script>
        title = `PositionAnnonce`;
        cumb = `Liste des Positions Disponibles`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection
