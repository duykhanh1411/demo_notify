<?php

/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 04/05/17
 * Time: 4:42 CH
 */
namespace App\Models\Interfaces;
use App\Models\PaginationInfo;

interface IStaffInterface extends IBaseInterface {
    public function func_insert($staff);

    public function func_update($staff);

    public function func_delete($id);

    public function func_getStaff($page);

    public function getAllCompany();

    public function updateUserImage($file);

    public function updateStaffImage($file);

    public function getSearchStaffList($page, $str);

    public function func_exportExcel($str);

    public function func_getAllStaffExport($strKeyword);
}