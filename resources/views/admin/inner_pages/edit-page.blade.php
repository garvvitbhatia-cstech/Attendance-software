@extends('layout.admin.dashboard')
@section('content')

<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Edit Inner Page</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{url('/admin/inner-pages')}}">Inner Pages</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Inner Page</li>
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
              <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation"> <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home"
                                                    role="tab" aria-controls="home" aria-selected="true">General Info</a> </li>
                <li class="nav-item" role="presentation"> <a class="nav-link" id="seo-tab" data-bs-toggle="tab" href="#seo"
                                                    role="tab" aria-controls="seo" aria-selected="false">SEO Info</a> </li>
              </ul>
              <hr />
              <div class="tab-content mt-5" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="basicInput">Title</label>
                        <input type="text" class="form-control" placeholder="Enter Title" value="{{$rowData->title}}" name="title" id="title">
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="basicInput">Description</label>
                        <textarea class="form-control editorBox" placeholder="Enter Description" name="description" id="description">{{$rowData->description}}</textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="basicInput">Heading</label>
                        <input type="text" class="form-control" placeholder="Enter Heading" value="{{$rowData->heading}}" name="heading" id="heading">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="basicInput">Sub Heading</label>
                        <input type="text" class="form-control" placeholder="Enter Sub Heading" value="{{$rowData->sub_heading}}" name="sub_heading" id="sub_heading">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Banner</label>
                        <input type="file" class="form-control" name="banner" id="banner" accept="image/*">
                        <input type="hidden" name="old_banner" value="{!! $rowData->banner !!}" />
                      </div>
                    </div>
                    @if($rowData->banner != "")
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="basicInput">&nbsp;</label>
                        <img src="{{URL::asset('public/admin/images/banners')}}/{!! $rowData->banner !!}"  style="max-width:100px;height: auto;"> 
                       </div>
                    </div>
                    @endif
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="basicInput">Banner Status</label>
                        <div class="form-check">
                          <input type="checkbox" class="form-check-input" id="banner_status" name="banner_status" {{$rowData->
                          banner_status == '1'?'checked':''}} value="1">
                          <label class="form-check-label" for="banner_status">Active</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade " id="seo" role="tabpanel" aria-labelledby="seo-tab">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="basicInput">SEO Title</label>
                        <input type="text" class="form-control" placeholder="Enter SEO Title" value="{{$rowData->seo_title}}" name="seo_title" id="seo_title">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="basicInput">SEO Description</label>
                        <textarea class="form-control" rows="6" placeholder="Enter SEO Description" name="seo_description" id="seo_description">{{$rowData->seo_description}}</textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="basicInput">SEO Keywords</label>
                        <textarea class="form-control" rows="6" placeholder="Enter SEO Keywords" name="seo_keyword" id="seo_keyword">{{$rowData->seo_keyword}}</textarea>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="basicInput">SEO Robots</label>
                        <select id="robot_tags" name="robot_tags" value="index,nofollow" class="form-select">
                          <option {{$rowData->robot_tags == 'index,follow'?'selected':''}} value="index,follow">index,follow</option>
                          <option {{$rowData->robot_tags == 'index,nofollow'?'selected':''}} value="index,nofollow">index,nofollow</option>
                          <option {{$rowData->robot_tags == 'noindex,follow'?'selected':''}} value="noindex,follow">noindex,follow</option>
                          <option {{$rowData->robot_tags == 'noindex,nofollow'?'selected':''}} value="noindex,nofollow">noindex,nofollow</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 col-md-3 ">
          <div class="card">
            <div class="col-md-12">
              <div class="text-left  p-3 p-l-20"> 
                
                <!--begin::Submit button-->
                
                <button type="button" id="form_submit" class="btn btn-sm btn-primary fw-bolder me-3 my-2"> <span class="indicator-label" id="formSubmit">Submit</span> <span class="indicator-progress d-none">Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span> </button>
                
                <!--end::Submit button--> 
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>
</div>
<!-- end plugin js --> 

<script type="text/javascript">
    $(document).ready(function () {
		$('.numberonly').keypress(function(e){
			var charCode = (e.which) ? e.which : event.keyCode
			if(String.fromCharCode(charCode).match(/[^0-9+]/g))
			return false;
		});
    });
    let saveDataURL = "{{url('/admin/edit-inner-page/'.$row_id)}}";
    let returnURL = "{{url('/admin/inner-pages')}}";
</script> 
<script src="{{ asset('public/admin/js/pages/inner_pages/edit-page.js') }}"></script> 
@endsection