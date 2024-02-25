<div class="card card-primary card-outline elevation-2 p-3">
    <div class="row">    
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label for="filterBranch">Branch</label>
            <div class="form-group">
                <select class="form-control" id="filterBranch" name="branch">
                    <option value=""> -- Select Branch -- </option>
                    @foreach($branch as $value)
                            <option value="{{$value->Branch}}">{{strtoupper($value->Branch)}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label for="filterStatus">Status</label>
            <div class="form-group">
                <select class="form-control" id="filterStatus" name="status">
                    <option value=""> -- Select Status -- </option>
                    @if(!isset($verificationStatus))
                        @foreach($status as $value)
                            <option value="{{$value->Status}}">{{$value->Status == "MIGS" ?strtoupper($value->Status) : "NON-MIGS"}}</option>
                        @endforeach
                    @else
                        @foreach($verificationStatus as $value)
                            <option value="{{$value}}">{{strtoupper($value)}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div> 
        <div class="col-lg-4 col-md-4 col-sm-12">
            <label for="clearFilter"> &nbsp;</label>
            <div class="form-group">
                <button class="btn btn-sm btn-primary font-weight-bold" id="clearFilter"><i class="fas fa-filter"></i> Clear Filter</button>
            </div> 
        </div>    
    </div>
</div>