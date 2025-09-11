@extends('layout.admin.dashboard')
@section('content')
<div class="page-heading">
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>View Enquiry</h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{url('/admin/enquiries')}}">Enquiries</a></li>
          <li class="breadcrumb-item active" aria-current="page">View Enquiry</li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<section class="section">
  <form class="form w-100" id="pageForm" action="#">
    <div class="row">
      <div class="col-9 col-md-9">
        <div class="card">
          <div class="card-body">
            <div class="row"> 
              @if($rowData->product_id > 0)
              <div class="col-md-12">
                <div class="form-group">
                  <label for="basicInput"><b>Product :</b> {{Helper::getProduct($rowData->product_id,'title')}}</label>
                </div>
              </div>
              @endif
              <div class="col-md-12">
                <div class="form-group">
                  <label for="basicInput"><b>Name :</b> {{$rowData->name}}</label>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="basicInput"><b>Email :</b> {{$rowData->email}}</label>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="basicInput"><b>Contact :</b> {{$rowData->contact}}</label>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="basicInput"><b>Message :</b> {!! nl2br($rowData->message) !!}</label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </form>
</section>
</div>
@endsection 