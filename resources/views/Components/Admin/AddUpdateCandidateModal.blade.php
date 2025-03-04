<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="addModalLabel">Add Candidate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="modal-closeIcon" aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="Id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center mb-2">
                            <div class="img-fluid elevation-2 CandidatePicture">
                                <img class="" id="CandidatePicture" src="{{asset('image/uploadicon.png')}}" alt="Picture" width="100" height="100">
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="input-group mt-2">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="Picture" name="file" accept="image/jpeg, image/png, image/jpg" required>
                                    <label class="custom-file-label" for="Picture">Upload Picture</label>
                                </div>
                            </div>
                            <div class="invalid-feedback font-weight-bold candidatePictureInvalid"></div>
                        </div>

                        <div class="col-12">
                            <label for="FirstName">First Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="First Name *" id="FirstName" name="FirstName" autocomplete="false" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="MiddleName">Middle Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Middle Name" id="MiddleName" name="MiddleName" autocomplete="false">
                            </div>
                        </div>

                        
                        <div class="col-12">
                            <label for="LastName">Last Name</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Last Name *" id="LastName" name="LastName" autocomplete="false" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="Education">Educational Attainment</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Educational Attainment *" id="Education" name="Education" autocomplete="false" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="Position">Position</label>
                            <div class="form-group">
                                <select class="form-control" id="Position" name="Position" required>
                                    <option value=""> -- Select Position -- </option>
                                    @foreach($position as $value)
                                            <option value="{{$value->Id}}">{{strtoupper($value->Description)}}</option>
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