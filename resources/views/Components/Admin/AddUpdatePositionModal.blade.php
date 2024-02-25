<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="addModalLabel">Add Position</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closeIcon" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addForm" method="POST">
                <input type="hidden" name="Id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="PositionLevel">Position Level</label>
                            <div class="form-group">
                                <input type="number" class="form-control" id="PositionLevel" name="PositionLevel" autocomplete="false" placeholder="Position Level *" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="VoteLimit">Vote Limit</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Vote Limit *" id="VoteLimit" name="VoteLimit" autocomplete="false" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="Description">Description</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="Description" name="Description" autocomplete="false" placeholder="Description *" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary font-weight-bold">Submit</button>
                    <a type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>