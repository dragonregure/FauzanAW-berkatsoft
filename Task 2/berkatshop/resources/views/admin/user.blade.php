@extends('admin.layouts.v1.main_template')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group pull-right">
                <a href="javascript:void(0)" class="btn btn-sm btn-success" id="createUser"><i class="fas fa-plus"></i> Add</a>
            </div>
            <table id="usertable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="modal fade" id="userformmodal" tabindex="-1" aria-labelledby="userformmodal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <h4 id="modalHeading"></h4>
                    </div>
                    @widget('button', ['type' => 'close', 'size' => 'btn-md', 'data-dismiss' => 'modal'])
                </div>
                <div class="modal-body">
                    <form action="{{url('admin/users')}}" method="POST" id="userForm">
                        @csrf
                        @widget('formInput', ['id' => 'username', 'name' => 'username', 'label' => 'Username',])

                        <div class="row">
                            <div class="col-md-6">
                                @widget('formInput', ['type' => 'email', 'id' => 'email', 'name' => 'email', 'label' => 'Email',])
                            </div>
                            <div class="col-md-6">
                                @widget('formInput', ['id' => 'phone', 'name' => 'phone', 'label' => 'Phone',])
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                @widget('formInput', ['type' => 'password', 'id' => 'password', 'name' => 'password', 'label' => 'Password',])
                            </div>
                            <div class="col-md-6">
                                @widget('formInput', ['type' => 'password', 'id' => 'password-confirm', 'name' => 'password_confirmation', 'label' => 'Password Confirmation',])
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                @widget('formInput', ['id' => 'role', 'name' => 'role', 'label' => 'Role',])
                            </div>
                            <div class="col-md-6">
                                @widget('formInput', ['type' => 'number', 'id' => 'level', 'name' => 'level', 'label' => 'Level',])
                            </div>
                        </div>

                        @widget('button', ['type' => 'save', 'id' => 'saveBtn', 'value' => 'create'])
                        @widget('button', ['type' => 'reset'])
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="usershowmodal" tabindex="-1" aria-labelledby="usershowmodal" aria-hidden="true">
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
                        'username' => 'Username',
                        'email' => 'Email',
                        'phone' => 'Phone',
                        'role' => 'Role',
                        'level' => 'Level',
                        'status' => 'Status',
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
        var uTable = $('#usertable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url("/admin/users") }}",
            columns: [
                {data: 'username', name: 'username'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'role', name: 'role', orderable: false},
                {data: 'level', name: 'level'},
                {data: 'action', name: 'action', orderable: false, searchable: false, margin: 'center'},
            ],
            responsive: true,
            autoWidth: false
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //EVENT SHOW CREATE MODAL
        $('#createUser').click(function (){
            $('#saveBtn').val('create-user').html('Create');
            $('#userForm').trigger('reset');
            $('#modalHeading').html('Create New Customer');
            $('#userformmodal').modal('show');
        });

        //EVENT CLOSE MODAL
        $("#userformmodal").on("hidden.bs.modal", function () {
            $('#username-error').html('');
            $('#email-error').html('');
            $('#phone-error').html('');
            $('#password-error').html('');
            $('#password-confirm-error').html('');
        });

        //EVENT SAVE DATA
        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $('#username-error').html('');
            $('#email-error').html('');
            $('#phone-error').html('');
            $('#password-error').html('');
            $('#password-confirm-error').html('');
            $(this).html('Saving..');

            if (this.value === 'create-user') {
                $.ajax({
                    url: "/admin/users",
                    type: 'post',
                    dataType: "JSON",
                    data: $('#userForm').serialize(),
                    success: function (response) {
                        if (response.errors){
                            if (response.errors.username) $('#username-error').html(response.errors.username[0]);
                            if (response.errors.email) $('#email-error').html(response.errors.email[0]);
                            if (response.errors.phone) $('#phone-error').html(response.errors.phone[0]);
                            if (response.errors.password) $('#password-error').html(response.errors.password[0]); $('#password-confirm-error').html(response.errors.password[0]);
                            $('#saveBtn').html('Create');
                        } else {
                            $('#userForm').trigger('reset');
                            $('#userformmodal').modal('hide');
                            uTable.draw();
                        }
                    },
                    error: function (response) {
                        console.log('Error: ' + response);
                        $('#saveBtn').html('Create');
                    }
                });
            } else {
                var id = this.value;
                $.ajax({
                    url: "/admin/users/" + id,
                    type: 'put',
                    dataType: "JSON",
                    data: $('#userForm').serialize(),
                    success: function (response) {
                        if (response.errors){
                            if (response.errors.username) $('#username-error').html(response.errors.username[0]);
                            if (response.errors.email) $('#email-error').html(response.errors.email[0]);
                            if (response.errors.phone) $('#phone-error').html(response.errors.phone[0]);
                            if (response.errors.password) $('#password-error').html(response.errors.password[0]); $('#password-confirm-error').html(response.errors.password[0]);
                            $('#saveBtn').html('Update');
                        } else {
                            $('#userForm').trigger('reset');
                            $('#userformmodal').modal('hide');
                            uTable.draw();
                        }
                    },
                    error: function (response) {
                        console.log('Error: ' + response);
                        $('#saveBtn').html('Update');
                    }
                });
            }

        });

        //EVENT VIEW, EDIT AND DELETE BUTTON
        $('body').on('click', '.editUser', function () {
            var id = $(this).data('id');
            $.ajax(
                {
                    url: "/admin/users/edit/"+id,
                    type: 'get', // replaced from put
                    dataType: "JSON",
                    data: {
                        "id": id // method and token not needed in data
                    },
                    success: function (response)
                    {
                        $('#userForm').trigger('reset');
                        $('#saveBtn').val(id).html('Update');
                        $('#modalHeading').html('Update Customer ' + response.username);
                        $('#username').val(response.username);
                        $('#email').val(response.email);
                        $('#phone').val(response.phone);
                        $('#role').val(response.role);
                        $('#level').val(response.level);
                        $('#userformmodal').modal('show');
                    },
                    error: function(response) {
                        console.log(response); // this line will save you tons of hours while debugging
                        // do something here because of error
                    }
                });
        }).on('click', '.deleteUser', function () {
            var id = $(this).data('id');
            $.ajax(
                {
                    url: "/admin/users/delete/"+id,
                    type: 'delete', // replaced from put
                    dataType: "JSON",
                    data: {
                        "id": id // method and token not needed in data
                    },
                    success: function (response)
                    {
                        uTable.draw();
                        console.log(response); // see the reponse sent
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // this line will save you tons of hours while debugging
                        // do something here because of error
                    }
                });
        }).on('click', '.viewUser', function () {
            var id = $(this).data('id');
            $.ajax(
                {
                    url: "/admin/users/view/"+id,
                    type: 'get', // replaced from put
                    dataType: "JSON",
                    data: {
                        "id": id // method and token not needed in data
                    },
                    success: function (response)
                    {
                        $('#modalShowHeading').html('Detail User ' + response.username);
                        $('#showUsername').html(response.username);
                        $('#showEmail').html(response.email);
                        $('#showPhone').html(response.phone);
                        $('#showRole').html(response.role);
                        $('#showLevel').html(response.level);
                        $('#showStatus').html(function (){
                            var string = 'ACTIVE';
                            if (response.status === 0) string = 'INACTIVE';
                            return string;
                        });
                        $('#showCreateddate').html(function (){
                            var date = new Date(response.created_at);
                            return date.getFullYear()+"/"+date.getMonth()+"/"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
                        });
                        $('#showUpdateddate').html(function (){
                            var date = new Date(response.updated_at);
                            return date.getFullYear()+"/"+date.getMonth()+"/"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
                        });
                        $('#usershowmodal').modal('show');
                    },
                    error: function(response) {
                        console.log(response); // this line will save you tons of hours while debugging
                        // do something here because of error
                    }
                });
        });
    </script>
@endsection
