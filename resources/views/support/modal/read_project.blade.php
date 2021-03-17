<div class="modal fade" id="add-type-modal" tabindex="-1" role="dialog" aria-labelledby="edit-modal-label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered vw-50" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" style="color: black;">CASE DETAIL</h3>
            </div>
            <div class="container">
                <h4 style="color: black;">Detail</h4>
                <div class="description"></div>
                <h4 style="color: black;">Death-line</h4>
                <div class="endCaseDate"></div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="deletedData()" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    function deletedData(){
        $('.detail').remove();
        $('.endCase').remove();
        window.location.reload();
    }
</script>