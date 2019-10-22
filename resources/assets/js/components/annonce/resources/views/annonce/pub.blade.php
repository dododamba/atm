@extends('layout.app')
@section('content')
    <publicite></publicite>
@endsection
@section('js')
    <script>
        title = `publicite`;
        cumb = `Liste des pubs`;
        $('.pagetitle').append(title);
        $('#breadcumb').append(cumb);

    </script>
@endsection
