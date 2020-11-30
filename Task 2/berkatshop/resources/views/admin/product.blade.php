@extends('admin.layouts.v1.main_template')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group pull-right">
                <a href="javascript:void(0)" class="btn btn-sm btn-success" id="createPeople"><i class="fas fa-plus"></i> Add</a>
            </div>
            <table id="peopletable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="peopleformmodal" tabindex="-1" aria-labelledby="userformmodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4 id="modalHeading"></h4>
                    </div>
                    @widget('button', ['type' => 'close', 'size' => 'btn-md', 'data-dismiss' => 'modal'])
                </div>
                <div class="modal-body">
                    <form action="" method="POST" id="peopleForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                @widget('formInput', ['id' => 'name', 'name' => 'name', 'label' => 'Product Name'])
                            </div>
                            <div class="col-md-6">
                                @widget('formInput', ['type' => 'number', 'id' => 'price', 'name' => 'price', 'label' => 'Product Price',])
                            </div>
                        </div>

                        @widget('button', ['type' => 'save', 'id' => 'saveBtn', 'value' => 'create'])
                        @widget('button', ['type' => 'reset'])
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="peopleshowmodal" tabindex="-1" aria-labelledby="peopleshowmodal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4 id="modalShowHeading"></h4>
                    </div>
                    @widget('button', ['type' => 'close', 'size' => 'btn-md', 'data-dismiss' => 'modal'])
                </div>
                <div class="modal-body">
                    @widget('viewTable', ['data' => [
                    'name' => 'Product Name',
                    'price' => 'Product Price',
                    'createddate' => 'Created Date',
                    'updateddate' => 'Updated Date',
                    ]])
                </div>
            </div>
        </div>
    </div>
@endsection

@section('contentjs')
    <script type="text/javascript">
        var pTable = $('#peopletable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url("/admin/products")}}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'price', name: 'price'},
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

        $('#createPeople').click(function (){
            $('#modalHeading').html('Create New Product');

            $('#saveBtn').val('create-product').html('Create');
            $('#peopleformmodal').modal('show');
        });

        $("#peopleformmodal").on("hidden.bs.modal", function () {
            $('#id').val('').trigger('change');
            $('#peopleForm').trigger('reset');
            $('#name-error').html('');
            $('#price-error').html('');
        });


        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Saving..');
            if (this.value === 'create-product') {
                $.ajax({
                    url: "/admin/products",
                    type: 'post',
                    dataType: "JSON",
                    data: $('#peopleForm').serialize(),
                    success: function (response) {
                        if (response.errors){
                            if (response.errors.name) $('#name-error').html(response.errors.name[0]);
                            if (response.errors.price) $('#price-error').html(response.errors.price[0]);
                            $('#saveBtn').html('Create');
                        } else {
                            $('#peopleForm').trigger('reset');
                            $('#peopleformmodal').modal('hide');
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
                    url: "/admin/products/" + id,
                    type: 'put',
                    dataType: "JSON",
                    data: $('#peopleForm').serialize(),
                    success: function (response) {
                        if (response.errors){
                            if (response.errors.name) $('#name-error').html(response.errors.name[0]);
                            if (response.errors.price) $('#price-error').html(response.errors.price[0]);
                            $('#saveBtn').html('Create');
                        } else {
                            $('#peopleForm').trigger('reset');
                            $('#peopleformmodal').modal('hide');
                            pTable.draw();
                        }
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); // this line will save you tons of hours while debugging
                        $('#saveBtn').html('Create');
                    }
                });
            }

        });

        $('body').on('click', '.viewProduct', function () {
            var id = $(this).data('id');
            $.ajax(
                {
                    url: "/admin/products/view/"+id,
                    type: 'get', // replaced from put
                    success: function (response)
                    {
                        $('#showName').html(response.name);
                        $('#showPrice').html(response.price);
                        $('#showCreateddate').html(function (){
                            var date = new Date(response.created_at);
                            return date.getFullYear()+"/"+date.getMonth()+"/"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
                        });
                        $('#showUpdateddate').html(function (){
                            var date = new Date(response.updated_at);
                            return date.getFullYear()+"/"+date.getMonth()+"/"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
                        });
                        $('#peopleshowmodal').modal('show');
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // this line will save you tons of hours while debugging
                        // do something here because of error
                    }
                });
        }).on('click', '.editProduct', function () {
            var id = $(this).data('id');
            $.ajax(
                {
                    url: "/admin/products/edit/"+id,
                    type: 'get', // replaced from put
                    success: function (response)
                    {
                        $('#saveBtn').val(id).html('Update');
                        $('#modalHeading').html('Update Product ' + response.name);
                        $('#name').val(response.name);
                        $('#price').val(response.price);
                        $('#peopleformmodal').modal('show');
                    },
                    error: function(response) {
                        console.log(response); // this line will save you tons of hours while debugging
                        // do something here because of error
                    }
                });
        }).on('click', '.deleteProduct', function () {
            var id = $(this).data('id');
            $.ajax(
                {
                    url: "/admin/products/delete/"+id,
                    type: 'delete', // replaced from put
                    success: function (response)
                    {
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
