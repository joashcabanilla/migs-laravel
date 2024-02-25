<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="addModalLabel">Add Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closeIcon" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form id="findForm" action="POST">
                    <div class="row">
                        <div class="col-9">
                            <label for="findVoterId">Voter Id</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="findVoterId" name="findVoterId" autocomplete="false" placeholder="Voter Id *" required>
                                <div class="invalid-feedback font-weight-bold"></div>
                            </div>
                        </div>
        
                        <div class="col-3">
                            <label for="findBtn">&nbsp;</label>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary font-weight-bold" id="findBtn">
                                    <i class="fa fa-search"></i> Find
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <form id="addForm" method="POST">
                <input type="hidden" name="Id" id="VoterId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="Pbno">Pb No</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="Pbno" name="Pbno" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="MemberId">MemberID</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="MemberId" name="MemberId" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="Name">Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="Name" name="Name" autocomplete="false" readonly>
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