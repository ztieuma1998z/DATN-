<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index (Request $request)
    {

        $kw_name = $request->kw_name;
        $kw_course = $request->kw_course;
        $kw_email = $request->kw_email;
        $kw_phone = $request->kw_phone;
        $kw_date_from = $request->kw_date_from;
        $kw_date_to = $request->kw_date_to;
        $kw_consultants = $request->kw_consultants;
        $kw_status = $request->kw_status;

        $customers = Customer::with('admin:id,full_name')->with('course:id,name,price');
        if(trim($kw_name)){
            $customers->where('full_name','like','%'.$kw_name.'%' );
        }

        if($kw_course){
            $customers->where('course_id',$kw_course);
        }

        if(trim($kw_email)){
            $customers->where('email',$kw_email);
        }

        if(trim($kw_phone)){
            $customers->where('phone',$kw_phone);
        }

        if($kw_date_from){
            $customers->where('created_at','>=', $kw_date_from." 00:00:00");
        }

        if($kw_date_to){
            $customers->where('created_at','<=', $kw_date_to." 23:59:59");
        }

        if($kw_consultants){
            $customers->where('admin_id', $kw_consultants);
        }

        if($kw_status){
            $customers->where('status', $kw_status);
        }

        $courses = Course::all();
        $customers = $customers->get();
        return view('admin.customer.index', compact('customers','courses'));
    }

    public function status ($id)
    {
        $customer = Customer::find($id);
        if ($customer->status == 1) {
            $customer->status = 2;
            $customer->admin_id = \Auth::user()->id;
            $customer->save();
            return redirect()->back()->with('success', 'Cập nhật trạng thái thành công !');
        }

        if($customer->admin_id == \Auth::user()->id) {
            if ($customer->status == 2){
                $customer->status = 3;
                $customer->admin_id = \Auth::user()->id;
                $customer->save();
                return redirect()->back()->with('success', 'Cập nhật trạng thái thành công !');
            }

            return redirect()->back()->with('warning', 'Không thể hoàn tác !');
        }else{
            return redirect()->back()->with('warning', 'Bạn không có quyền tư vấn !');
        }
    }

    public function delete ($id)
    {
        if ($id) {
            Customer::destroy($id);
            return redirect()->back()->with('success', 'Xóa khách hàng thành công !');
        }
    }
}
