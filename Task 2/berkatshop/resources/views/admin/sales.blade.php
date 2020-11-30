@extends('admin.layouts.v1.main_template')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group pull-right">
                <a href="javascript:void(0)" class="btn btn-sm btn-success" id="createPost"><i class="fas fa-plus"></i> Add</a>
            </div>
            <table id="posttable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Username</th>
                    <th>Product</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="postformmodal" tabindex="-1" aria-labelledby="postformmodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4 id="modalHeading"></h4>
                    </div>
                    @widget('button', ['type' => 'close', 'size' => 'btn-md', 'data-dismiss' => 'modal'])
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="postForm">
                        @csrf

                        <div class="form-group">
                            <label for="id">Username</label>
                            <select name="userId" id="userId" class="form-control">
                                <option value="">Select User</option>
                                @foreach($userData as $key)
                                    <option value="{{$key->id}}">{{$key->username}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                <small id="userId-error"></small>
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="id">Product</label>
                            <select name="productId[]" id="productId" class="form-control" multiple="multiple">
                                @foreach($productData as $key)
                                    <option value="{{$key->id}}">{{$key->name}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                <small id="productId-error"></small>
                            </span>
                        </div>


                        @widget('button', ['type' => 'save', 'id' => 'saveBtn', 'value' => 'create'])
                        @widget('button', ['type' => 'reset'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('contentjs')
    <script type="text/javascript">
        var pTable = $('#posttable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url("/admin/sales")}}",
            columns: [
                {data: 'invoice_number', name: 'invoice_number'},
                {data: 'username', name: 'username'},
                {data: 'productname', name: 'productname'},
                {data: 'action', name: 'action'},
            ],
            responsive: true,
            autoWidth: false
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#createPost').click(function () {
            $('#modalHeading').html('Create Order');
            $('#userId').select2({
                theme: 'bootstrap4'
            });
            $('#productId').select2({
                theme: 'bootstrap4'
            });
            $('#saveBtn').val('create-order').html('Create');
            $('#postformmodal').modal('show');
        });

        $("#postformmodal").on("hidden.bs.modal", function () {
            $('#userId').val('').trigger('change');
            $('#productId').val('').trigger('change');
            $('#postForm').trigger('reset');
            $('#userId-error').html('');
            $('#productId-error').html('');
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Saving..');
            if (this.value === 'create-order') {
                $.ajax({
                    url: "/admin/sales",
                    type: 'post',
                    dataType: "JSON",
                    data: $('#postForm').serialize(),
                    success: function (response) {
                        if (response.errors){
                            if (response.errors.userId) $('#userId-error').html(response.errors.userId[0]);
                            if (response.errors.productId) $('#productId-error').html(response.errors.productId[0]);
                            $('#saveBtn').html('Create');
                        } else {
                            console.log(response);
                            $('#postformmodal').modal('hide');
                            pTable.draw();
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); // this line will save you tons of hours while debugging
                        $('#saveBtn').html('Create');
                    }
                });
            } else {
                var id = this.value;
                $.ajax({
                    url: "/admin/sales/" + id,
                    type: 'put',
                    dataType: "JSON",
                    data: $('#peopleForm').serialize(),
                    success: function (response) {
                        if (response.errors){
                            if (response.errors.userId) $('#userId-error').html(response.errors.userId[0]);
                            if (response.errors.productId) $('#productId-error').html(response.errors.productId[0]);
                            $('#saveBtn').html('Create');
                        } else {
                            console.log(response);
                            $('#postformmodal').modal('hide');
                            pTable.draw();
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); // this line will save you tons of hours while debugging
                        $('#saveBtn').html('Assign');
                    }
                });
            }

        });

        $('body').on('click', '.deleteOrder', function () {
            var id = $(this).data('id');
            $.ajax(
                {
                    url: "/admin/sales/delete/"+id,
                    type: 'delete', // replaced from put
                    success: function (response)
                    {
                        $(document).Toasts('create', {
                            title: 'Success',
                            body: response.message,
                            autohide: true,
                            delay: 2500,
                        })
                        pTable.draw();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // this line will save you tons of hours while debugging
                        // do something here because of error
                    }
                });
        });
    </script>
@endsection
