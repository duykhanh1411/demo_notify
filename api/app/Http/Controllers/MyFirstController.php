<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Interfaces\IStaffInterface;
use Illuminate\Http\Request;

use App\Http\Requests;
use Mockery\Exception;

class MyFirstController extends Controller
{
    //
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private $staffBL = '';

    public function __construct(IStaffInterface $IStaff)
    {
        $this->staffBL = $IStaff;
    }

    public function doTest(Request $request)
    {
        $result = STR_FOUR;
        $authen = $this->staffBL->getAuthenticate();
        if (!$authen['check']) {
            return response($authen['error'], 401);
        }
        try {
            switch ($request->Invoke) {
                //insert function
                case 0:
                    $result = $this->staffBL->func_insert($request);
                    break;
                //update function
                case 1:
                    $result = $this->staffBL->func_update($request);
                    break;
                //delete function
                case 2:
                    $result = $this->staffBL->func_delete($request->id);
                    break;
                //load list staff function
                case 5:
                    $result = array(
                        'data' => $this->staffBL->func_getStaff($request->page),
                        'currentPage' => $this->staffBL->getPaginationInfo()->CurrentPage,
                        'pageSize' => $this->staffBL->getPaginationInfo()->PageSize,
                        'totalItems' => $this->staffBL->getPaginationInfo()->TotalItems,
                        'totalPages' => $this->staffBL->getPaginationInfo()->TotalPages,
                    );
                    $result = response()->json($result);
                    break;
            }
        } catch (Exception $ex) {
            $result = STR_THREE;
            \Log::error('khanhhd' . $ex);
            return response(STR_THREE, 500);
        }
        return $result;
    }

    public function getAllCompany()
    {
        try {
            return response()->json($this->staffBL->getAllCompany());
        } catch (Exception $ex) {
            \Log::error('khanhhd' . $ex);
            return response("", 500);
        }
    }

    public function uploadFile(Request $request)
    {
        try {
            \Log::debug('khanhhd' .  ini_get('upload_max_filesize'));
            $file = $request->file;
            $result = $this->staffBL->updateUserImage($file);
            return response()->json($result);
        } catch (Exception $ex) {
            \Log::error('khanhhd' . $ex);
            return response("", 500);
        }
    }

    public function uploadFileStaff(Request $request)
    {
        try {
            \Log::debug('khanhhd' .  ini_get('upload_max_filesize'));
            $file = $request->file;
            $result = $this->staffBL->updateStaffImage($file);
            return response()->json($result);
        } catch (Exception $ex) {
            \Log::error('khanhhd' . $ex);
            return response("", 500);
        }
    }

    public function searchStaff(Request $request)
    {
        try {
            $result = array(
                'data' => $this->staffBL->getSearchStaffList($request->page, $request->keyword),
                'currentPage' => $this->staffBL->getPaginationInfo()->CurrentPage,
                'pageSize' => $this->staffBL->getPaginationInfo()->PageSize,
                'totalItems' => $this->staffBL->getPaginationInfo()->TotalItems,
                'totalPages' => $this->staffBL->getPaginationInfo()->TotalPages,
            );
            $result = response()->json($result);
        } catch (Exception $ex) {
            \Log::error('khanhhd' . $ex);
            return response("", 500);
        }
        return $result;
    }

    public function exportExcel(Request $request)
    {
        try {
            $this->staffBL->func_exportExcel($request->str);
            return STR_ONE;
        } catch (Exception $ex) {
            \Log::error('khanhhd' . $ex);
            return response("", 500);
        }
    }
}