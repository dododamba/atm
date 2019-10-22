@extends('layout.app')
@section('content')
    <VueUploadMultipleImage></VueUploadMultipleImage>
@endsection
@section('js')
    <script>
        title = `creation des annonces`;
        cumb = `Creation annonce`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection