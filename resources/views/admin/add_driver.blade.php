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
                <h3 class="card-title">Add Driver</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('admin.adddriverdb') }}" method="post">
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
                    <label for="fname">First Name</label>
                    <input type="text" name="fname" class="form-control" id="dname" placeholder="Enter First Name" required value="{{ old('fname') }}">
                  </div>
                  <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" name="lname" id="lname" placeholder="Enter Last Name" required value="{{ old('lname') }}">
                  </div>
                  <div class="form-group">
                    <label for="pno">Pager Number</label>
                    <input type="text" class="form-control" name="pno" id="pno" placeholder="Enter Pager Number" required value="{{ old('pno') }}">
                  </div>
                  <div class="form-group">
                    <label for="phno">Phone Number</label>
                    <input type="phone" class="form-control" name="phno" id="phno" placeholder="Enter Phone Number" value="{{ old('phno') }}">
                  </div>
                  <div class="form-group">
                    <label for="mobno">Mobile Number</label>
                    <input type="phone" class="form-control" name="mobno" id="mobno" placeholder="Enter Mobile Number" required value="{{ old('mobno') }}">
                  </div>
                  <div class="form-group">
                    <label for="mail">Email Address</label>
                    <input type="email" class="form-control" name="email" id="mail" placeholder="Enter Email Address" value="{{ old('email') }}">
                    <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                  </div>
                  <div class="form-group">
                    <label for="gst">GST Numner</label>
                    <input type="text" class="form-control" name="gst" id="gst" placeholder="Enter GST Numner" required value="{{ old('gst') }}">
                  </div>
                  <div class="form-group">
                    <label>Street Address 1</label>
                    <textarea class="form-control" name="sadr1" rows="3" placeholder="Enter Street Address 1" required value="{{ old('sadr1') }}"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Street Address 2</label>
                    <textarea class="form-control" name="sadr2" rows="3" placeholder="Enter Street Address 2" value="{{ old('sadr2') }}"></textarea>
                  </div>
                  <div class="form-group">
                  <label>Street Area</label>
                  <select name="area" class="form-control select2" style="width: 100%;" required value="{{ old('area') }}">
                    <option selected="selected">Alabama</option>
                    <option>Alaska</option>
                    <option>California</option>
                    <option>Delaware</option>
                    <option>Tennessee</option>
                    <option>Texas</option>
                    <option>Washington</option>
                  </select>
                </div>
                <div class="form-group">
                      <label for="radioSuccess2">Company Driver :  </label>
                      <div class="icheck-success d-inline">
                        <input type="radio" name="cd" id="radioSuccess2" value="{{ old('cd') }}">
                        <label for="radioSuccess2">Yes</label>
                      </div>
                      <div class="icheck-danger d-inline">
                        <input type="radio" name="cd" id="radioSuccess3" value="{{ old('cd') }}">
                        <label for="radioSuccess3">No</label>
                      </div>
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