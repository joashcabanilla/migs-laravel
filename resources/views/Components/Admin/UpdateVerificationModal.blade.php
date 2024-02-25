<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="updateModalLabel">Add Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closeIcon" aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="updateForm" method="POST">
                <input type="hidden" name="Id" id="VoterId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="Pbno">Pb No</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="Pbno" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="MemberId">MemberID</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="MemberId" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="Name">Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="Name" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="Name">Status</label>
                            <div class="form-group">
                                <select class="form-control" name="Status" required>
                                    @foreach($verificationStatus as $value)
                                        <option value="{{$value}}">{{strtoupper($value)}}</option>
                                    @endforeach
                                </select>

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