{{-- <div class="modal" id="add_project_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Project</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
data-toggle="modal" data-target="#exampleModalLong" --}}


<!-- User Modal -->
<div class="modal fade" id="add_project_modal" tabindex="-1" role="dialog" aria-labelledby="add-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md vw-50" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-modal-label">Add Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0 pb-0" id="attachment-body-content">
                {{-- <form id="user-form" class="form-horizontal" method="POST" action=""> --}}
                @csrf
                <div class="card mb-0">
                    {{-- <div class="card-header">
                            <h2 class="m-0">Edit</h2>
                        </div> --}}
                    <div class="card-body">
                        <div class="form-group">
                            <label class="col-form-label" for="modal-input-name">Name</label>
                            <input type="text" name="userName" class="form-control" id="modal-input-name" required>
                        </div>
                        <!-- id -->
                        <div class="form-group">
                            <label class="col-form-label" for="modal-input-description">Description</label>
                            <input type="text" name="fname" class="form-control" id="modal-input-description" required>
                        </div>
                        <!-- /id -->
                        <!-- name -->
                        {{-- <div class="form-group">
                                <label class="col-form-label" for="modal-input-name">นามสกุล</label>
                                <input type="text" name="lname" class="form-control" id="modal-input-lastName" required>
                            </div> --}}
                        <!-- /name -->
                        <!-- description -->
                        {{-- <div class="form-group">
                                <label class="col-form-label" for="modal-input-description">เบอร์โทรศัพท์</label>
                                <input type="text" name="phone" class="form-control" id="modal-input-phone" required>
                            </div> --}}
                        {{-- department --}}
                        {{-- <div class="form-group">
                                <label class="col-form-label" for="modal-input-description">สังกัด</label>
                                <input type="text" name="department" class="form-control" id="modal-input-department" required>
                            </div> --}}
                        {{-- <div class="form-group">
                                <label class="col-form-label" for="modal-input-description">ประเภท</label>
                                {{-- <input type="text" name="permission" class="form-control" id="modal-input-permission"
                                    required> --}}
                        {{-- <select class="form-control" id="modal-input-permission" required>
                                        <option value="1">Admin (ผู้ดูแลระบบ)</option>
                                        <option value="2">Board (ผู้บริหาร)</option>
                                        <option value="3">User (บุคลากรต่างๆ ของคลัง)</option>
                                    </select>
                            </div> --}}
                    </div>
                </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button id="add_project" type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>
<!-- /User Modal -->
{{-- @include('sweetalert::alert') --}}
<script>
    //add project
    $('#add_project').click(function(e) {
        e.preventDefault();
        const token = $.cookie('token');
        const name = $('#modal-input-name').val();
        const des = $('#modal-input-description').val();
        const formData = {
            name: name,
            description: des
        }
        Swal.fire({
            title: 'Please check the information!!',
            text: 'Make sure the information is correct before recording',
            icon: 'warning',
            showConfirmButton: true,
            showCancelButton: true,
            focusConfirm: true,
            cancelButtonColor: '#f5365c'
        }).then(function(confirm) {
            if (!confirm.value) {
                return
            }
            $.ajax({
                type: "POST",
                url: "/api/project/add",
                data: formData,
                headers: {
                    'Authorization': 'Bearer ' + token,
                },
                dataType: "json",
                success: function(data) {
                    $.cookie('token', data.data.token);
                    $.cookie('name', data.data.name);
                    $.cookie('description', data.data.description);
                    window.location = 'index'
                    console.log(data)
                }
            });
        });
    });
</script>
