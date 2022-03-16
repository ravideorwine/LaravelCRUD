<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Laravel 8 CRUD Tutorial From Scratch</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-2">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                    <h2>Laravel 8 CRUD Example Tutorial</h2>
                    </div>
                    <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('companies.create') }}"> Create Company</a>
                    </div>
                </div>
            </div>
            <?php 
            if ($message = Session::get('success')){
            ?>
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            <?php } ?>
            <div class="mb-5">
                <form action="{{ route('company.export') }}" method="get">
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="search..." name="text" id="custom-search" value="">
                    </div>
                    <button type="submit" class="btn btn-primary">Download</button>
                </form>  
            </div>
            <table class="table table-bordered yajra-datatable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Company Name</th>
                        <th>Company Email</th>
                        <th>Company Address</th>
                        <th>Image</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>                    
                </tbody>
            </table>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

        <script type="text/javascript">
            $(function () {                
                
                var table = $('.yajra-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    // searching: false,
                    dom: 'Bfrtip',
                    buttons: [
                        'excel'
                    ],
                    ajax: "{{ route('companies.index') }}",
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'address', name: 'address'},
                        {
                            data: 'image', 
                            name: 'image',
                            render: function(file_id) {
                                return '<img src="public/image/'+file_id+'" style="width:100px;">';
                            },
                        },
                        {data: 'created_at', name: 'created_at'},
                        {data: 'updated_at', name: 'updated_at'},
                        {
                            data: 'action', 
                            name: 'action', 
                            render: function(data, type, row) {    
                                return "<a href='javascript:void(0)' class='btn btn-success editButton' data-id="+row['id']+">Edit</a> <a href='javascript:void(0)' class='btn btn-danger deleteButton' data-id="+row['id']+">Delete</a>";
                            },
                        },
                    ],
                    "columnDefs": [                     
                    {
                        "targets": -1,
                        "orderable": false,
                        "searchable": false,
                    },
                ],
                    
                });

                
                $('#custom-search').keyup(function(){
                    table.search($(this).val()).draw() ;
                });

                $('.yajra-datatable tbody').on( 'click', '.editButton', function () {
                    var dataId  = $(this).attr("data-id");
                    var edit_url = 'http://127.0.0.1:8000/companies/'+dataId+'/edit';
                    window.location.href = edit_url;
                });

                $('.yajra-datatable tbody').on('click', '.deleteButton', function () {

                    var dataId = $(this).attr("data-id");
                    var token = $('meta[name="csrf-token"]').attr('content');

                    Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            type:"POST",
                            url: "{{ url('delete-company') }}",
                            data: { id: dataId , _token : token },
                            dataType: 'json',
                            success: function(){
                                table.draw();
                            }
                        });

                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        )
                        
                    }
                    })

                } );

                $("#custom-search").keyup(function() {
                    $searchText = $(this).val();                 

                });

            });
        </script>

   </body>
</html>