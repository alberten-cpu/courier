@extends('layouts.adheader')
<style>
.switch {
  position: relative;
  
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
@section('content')
 <!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
      <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Area</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.addareadb') }}" method="post">
              @if(Session::get('success'))
             <div class="alert alert-success">
                {{ Session::get('success') }}
             </div>
           @endif

           @if(Session::get('fail'))
             <div class="alert alert-danger">
                {{ Session::get('fail') }}
             </div>
           @endif
  
              @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="area">Area</label>
                    <input type="text" name="area" class="form-control" id="area" placeholder="Enter Area" required value="{{ old('area') }}">
                </div>
                <div class="form-group">
                    <label for="Zone">Zone</label>
                    <input type="text" class="form-control" name="zone" id="gst" placeholder="Enter Zone" required value="{{ old('Zone') }}">
                </div>
                
                <div class="form-group">
                  <label>Status</label>
                  <select name="stat" class="form-control select2" style="width: 100%;" required value="{{ old('stat') }}">
                    <option selected disabled>Select</option>
                    <option value="enable">Enable</option>
                    <option value="disable">Disable</option>
                  </select>
                </div>
                  
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    @endsection