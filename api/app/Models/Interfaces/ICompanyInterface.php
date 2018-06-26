<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 14/05/17
 * Time: 9:44 CH
 */

namespace App\Models\Interfaces;


interface ICompanyInterface extends IBaseInterface
{
    public function func_insert($company);

    public function func_update($company);

    public function func_delete($id);

    public function func_getCompany($page);

    public function func_getCompanyById($id);

    public function func_exportExcel();

    public function func_getAllCompanyExport();
}