<?php

namespace App\Http\Controllers;

use App\Models\Interfaces\ICompanyInterface;
use Illuminate\Http\Request;
use Mockery\Exception;

class CompanyController extends Controller
{
    private $companyBl = '';

    public function __construct(ICompanyInterface $ICompany)
    {
        $this->companyBl = $ICompany;
    }

    public function doCompanyGenerateAction(Request $request)
    {
        $result = STR_FOUR;
        $authen = $this->companyBl->getAuthenticate();
        if (!$authen['check']) {
            return response($authen['error'], 401);
        }
        try {
            switch ($request->Invoke) {
                //insert function
                case 0:
                    $result = $this->companyBl->func_insert($request);
                    break;
                //update function
                case 1:
                    $result = $this->companyBl->func_update($request);
                    break;
                //delete function
                case 2:
                    $result = $this->companyBl->func_delete($request->id);
                    break;
                //load list staff function
                case 5:
                    $result = array(
                        'data' => $this->companyBl->func_getCompany($request->page),
                        'currentPage' => $this->companyBl->getPaginationInfo()->CurrentPage,
                        'pageSize' => $this->companyBl->getPaginationInfo()->PageSize,
                        'totalItems' => $this->companyBl->getPaginationInfo()->TotalItems,
                        'totalPages' => $this->companyBl->getPaginationInfo()->TotalPages,
                    );
                    $result = response()->json($result);
                    break;
            }
        } catch (Exception $ex) {
            $result = STR_THREE;
            /*throwException($ex);*/
            \Log::error('khanhhd' . $ex);
            return response(STR_THREE, 500);
        }
        return $result;
    }

    public function getCompany(Request $request)
    {
        try {
           $result = $this->companyBl->func_getCompanyById($request->id);
        } catch (Exception $ex) {
            \Log::error('khanhhd' . $ex);
            return response(STR_THREE, 500);
        }
        return response()->json($result);
    }

    public function exportExcel(){
        try{
            $this->companyBl->func_exportExcel();
            return STR_ONE;
        }catch (Exception $ex){
            \Log::error('khanhhd' . $ex);
            return response(STR_THREE, 500);
        }
    }
}
