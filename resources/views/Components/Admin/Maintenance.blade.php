<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card card-primary card-outline elevation-2 p-3">
                <div class="row">
                    <div class="col-12">
                        <h5 class="font-weight-bold">ELECTION STATUS</h5>
                    </div>
                    <div class="col-12 mt-2">
                        <form id="electionStatusForm" method="POST">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="electionStatus">STATUS</label>
                                        <select class="form-control" id="electionStatus" name="ElectionStatus">
                                            <option value="OPEN" {{$electionStatus == "OPEN" ? "selected" : ""}}>OPEN</option>
                                            <option value="CLOSED" {{$electionStatus == "CLOSED" ? "selected" : ""}}>CLOSED</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="saveBtn">&nbsp;</label>
                                    <div class="form-group">
                                        <button class="btn btn-primary font-weight-bold" id="saveBtn"><i class="fas fa-save"></i> SAVE</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="card card-primary card-outline elevation-2 p-3">
                <div class="row">
                    <div class="col-12">
                        <h5 class="font-weight-bold">BATCH IMPORT DATA</h5>
                    </div>
                    <div class="col-12 mt-2">
                        <form id="importDatabaseForm" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="databaseTable">Select Table</label>
                                        <select class="form-control" id="databaseTable" name="table" required>
                                            <option value="">-- Select Table --</option>
                                            @foreach($tables as $value)
                                                <option value="{{$value}}">{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="batchInsert">Batch Insert</label>
                                        <input type="number" class="form-control" id="batchInsert" name="batchInsert" required min="1" max="50">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="input-group mt-2">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="tableFile" name="file" accept=".csv">
                                            <label class="custom-file-label" for="tableFile">Upload Excel File</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-3 container-progress d-none">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary progress-bar-striped" style="width: 0%;">0%</div>
                                    </div>
                                    <h4 class="font-wieght-bold mt-2"></h4>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-primary font-weight-bold float-right d-none" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>