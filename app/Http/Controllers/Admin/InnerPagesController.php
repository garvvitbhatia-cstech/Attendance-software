<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\InnerPages;
use App\RouteHelper;
use App\Models\TokenHelper;
use App\Models\Responses;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Session;
use Validator;
use Mail;
use URL;
use Cookie;
use Illuminate\Validation\Rule;

class InnerPagesController extends Controller {
    private static $InnerPages;
    public function __construct() {
        self::$InnerPages = new InnerPages();
    }

    #admin dashboard page
    public function getList(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        return view('/admin/inner_pages/index');
    }

    public function listPaginate(Request $request) {
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        $query = self::$InnerPages->where('status', '!=', 3);
        if ($request->input('title') && $request->input('title') != "") {
            $title = $request->input('title');
            $query->where('title', 'like', '%' . $title . '%');
        }
        $records = $query->orderBy('id', 'DESC')->paginate(20);
        return view('/admin/inner_pages/paginate', compact('records'));
    }

    #edit Service Type
    public function editPage(Request $request, $row_id) {
        $RowID = base64_decode($row_id);
        if (!$request->session()->has('admin_email')) {
            return redirect('/admin/');
        }
        if ($request->input()) {
            $validator = Validator::make($request->all(), ['title' => 'required'], ['title.required' => 'Please enter title.']);
            if ($validator->fails()) {
                $errors = $validator->errors();
                if ($errors->first('title')) {
                    return json_encode(array('heading' => 'Error', 'msg' => $errors->first('title')));
                    die;
                }
            } else {
                #profile pic upload
                if (isset($request->banner) && $request->banner->extension() != "") {
                    $validator = Validator::make($request->all(), ['banner' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
                    if ($validator->fails()) {
                        $errors = $validator->errors();
                        return json_encode(array('heading' => 'Error', 'msg' => $errors->first('banner')));
                        die;
                    } else {
                        $actual_image_name = str_shuffle(mt_rand() . time()) . '.' . $request->banner->extension();
                        $destination = base_path() . '/public/admin/images/banners/';
                        $request->banner->move($destination, $actual_image_name);
                        if ($request->input('old_banner') != "") {
                            if (file_exists($destination . $request->input('old_banner'))) {
                                unlink($destination . $request->input('old_banner'));
                            }
                        }
                    }
                } else {
                    $actual_image_name = $request->input('old_banner');
                }
                $banner_status = 2;
                if ($request->input('banner_status')) {
                    $banner_status = 1;
                }
                $setData['id'] = $RowID;
                $setData['title'] = $request->input('title');
                $setData['heading'] = $request->input('heading');
                $setData['sub_heading'] = $request->input('sub_heading');
                $setData['description'] = $request->input('description');
                $setData['banner'] = $actual_image_name;
                $setData['banner_status'] = $banner_status;
                $setData['seo_title'] = $request->input('seo_title');
                $setData['seo_description'] = $request->input('seo_description');
                $setData['seo_keyword'] = $request->input('seo_keyword');
                $setData['robot_tags'] = $request->input('robot_tags');
                self::$InnerPages->UpdateRecord($setData);
                echo json_encode(array('heading' => 'Success', 'msg' => 'Inner page details updated successfully'));
                die;
            }
        }
        $rowData = self::$InnerPages->where(array('id' => $RowID))->first();
        if (isset($rowData->id)) {
            return view('/admin/inner_pages/edit-page', compact('rowData', 'row_id'));
        } else {
            return redirect('/admin/inner_pages');
        }
    }
}
