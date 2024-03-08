<div class="modal fade" id="itemModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="itemModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="itemModalLabel">RECEIVE GA ITEMS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closeIcon" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="itemForm" method="POST">
                <input type="hidden" name="VoterId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="Pbno">Pbno</label>
                            <div class="form-group">
                                <input type="text" class="form-control font-weight-bold" id="Pbno" name="Pbno" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="MemberId">Member ID</label>
                            <div class="form-group">
                                <input type="text" class="form-control font-weight-bold" id="MemberId" name="MemberId" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="Name">Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control font-weight-bold" id="Name" name="Name" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="Branch">Branch</label>
                            <div class="form-group">
                                <input type="text" class="form-control font-weight-bold" id="Branch" name="Branch" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="RegisterVoteMethod">Vote Method</label>
                            <div class="form-group">
                                <input type="text" class="form-control font-weight-bold" id="RegisterVoteMethod" name="RegisterVoteMethod" autocomplete="false" readonly>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="icheck-success">
                                <input type="checkbox" id="foodStub" name="foodStub" checked>
                                <label for="foodStub">₱100 FOOD STUB</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="icheck-success">
                                <input type="checkbox" id="tshirt" name="tshirt" checked>
                                <label for="tshirt">T-SHIRT</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="icheck-success">
                                <input type="checkbox" id="rice" name="rice" checked>
                                <label for="rice">2KLS BIGAS</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="icheck-success">
                                <input type="checkbox" id="savings" name="savings" checked>
                                <label for="savings">₱300 SAVINGS</label>
                            </div>
                        </div>
                        <div class="col-6 d-none itemsTicket">
                            <div class="icheck-success">
                                <input type="checkbox" id="ticket" name="ticket" checked>
                                <label for="ticket">RAFFLE TICKET</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary font-weight-bold">Register</button>
                    <a type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="reportModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="reportModalLabel">GENERATE REPORT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closeIcon" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="reportForm" method="POST" action="{{route("print.summaryGaItems")}}" target="_blank">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="filetype">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 pb-3">
                            <label for="reportType">Select Report</label>
                            <select class="form-control" id="reportType" name="reportType" required autocomplete="false">
                                <option value="1">List of registered members for the current user</option>
                                <option value="2">GA items Summary</option>
                                <option value="3">Election Summary</option>
                            </select>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label for="voteMethod">Vote Method</label>
                            <div class="form-group">
                                <select class="form-control" id="voteMethod" name="voteMethod">
                                    <option value=""> -- Select Vote Method -- </option>
                                    <option value="online">ONLINE</option>
                                    <option value="f2f">FACE TO FACE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label for="Date">Date</label>
                            <div class="form-group">
                                <input type="date" class="form-control" id="Date" name="date">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    @if(Auth::user()->UserType == 1)
                        <a class="btn btn-primary font-weight-bold d-none" id="printExcel">Generate Excel</a>
                    @endif
                    <button type="submit" class="btn btn-primary font-weight-bold" id="printPDF">Generate PDF</button>
                    <a type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>