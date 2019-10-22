@extends('layout.app')
@section('title')
User role
@stop

@section('content')

<div class="col-lg-12 col-md-12 col-xs-12">
        <div class="dashboard-list-box">
            <h4 class="gray">Roles</h4>
            <div class="table-box">
            <table class="basic-table booking-table">
                    <thead>
                            <tr>
                                <th>ID</th><th>Nom</th><th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
            
                        @foreach($roles as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td><a href="{{ url('role', $item->id) }}">{{ $item->name }}</td>
                                <td>
                                    <span class="paid t-box"><a href="{{ url('role/' . $item->id . '/edit') }}" style="color : #ffffff;">Editer</a></span>
                                    <span class="pending t-box"><a href="{{ url('role/' . $item->id . '/permissions') }}" style="color : #ffffff;" >Permissions</a> </span>
                                    <span class="cancel t-box"><a href="{{ url('role/' . $item->id . '/permissions') }}" style="color : #ffffff;" >Supprimer</a> </span>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
            </table>
            </div>
        </div>
        <div class="pagination-container">
            <nav class="pagination">
                <ul>
                    <li><a href="#" class="current-page">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#"><i class="sl sl-icon-arrow-right"></i></a></li>
                </ul>
            </nav>
        </div>
    </div>


@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#tblroles').DataTable({
                columnDefs: [{
                    targets: [0],
                    visible: false,
                    searchable: false
                    },
                ],
                order: [[0, "asc"]],
            });
        });
     $(".deleteconfirm").on("click", function(){
            return confirm("Are you sure to delete this Role");
        });
    </script>
@endsection
