<style>
    .autocomplete {
        position: relative;
    }
    .autocomplete-items {
        position: absolute;
        border: 1px solid #d4d4d4;
        border-bottom: none;
        border-top: none;
        z-index: 99;
        /*position the autocomplete items to be the same width as the container:*/
        top: 100%;
        left: 0;
        right: 0;
    }
    .autocomplete-items div {
        padding: 10px;
        cursor: pointer;
        background-color: #fff;
        border-bottom: 1px solid #d4d4d4;
    }
    .autocomplete-items div:hover {
        /*when hovering an item:*/
        background-color: #e9e9e9;
    }
    .autocomplete-active {
        /*when navigating through the items using the arrow keys:*/
        background-color: DodgerBlue !important;
        color: #ffffff;
    }
</style>

<!-- User Modal -->
<div class="modal fade" id="add_case_modal" tabindex="-1" role="dialog" aria-labelledby="add-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md vw-50" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-case-modal-label">Add Case</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0 pb-0" id="attachment-body-content">
                @csrf
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="form-group autocomplete">
                            <label class="col-form-label" for="modal-input-case-member-project-id">Username</label>
                            <input type="text" name="case_member_id" class="form-control" autocomplete="off"
                                id="modal-input-case-member-project-id" required>
                        </div>
                        <!-- id -->
                        <div class="form-group">
                            <label class="col-form-label" for="modal-input-case-name">Subject</label>
                            <input type="text" name="case_name" class="form-control" id="modal-input-case-name"
                                required>
                        </div>
                        <!-- /id -->
                        <div class="form-group">
                            <label class="col-form-label" for="modal-input-case-detial">Detial</label>
                            <input type="text" name="case_detial" class="form-control" id="modal-input-case-detial"
                                required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="modal-input-case-end">EndCase</label>
                            <div class='input-group date' id='datetimepicker1'>
                            <input id="modal-input-case-end" type='text' class="form-control" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                            </div>
                            {{-- <input type="text" name="case_end" class="form-control" id="modal-input-case-end" required> --}}
                        </div>
                    </div>
                </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button id="add_case" type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </div>
</div>