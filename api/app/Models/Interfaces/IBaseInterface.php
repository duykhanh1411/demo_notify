<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 14/05/17
 * Time: 9:45 CH
 */

namespace App\Models\Interfaces;


interface IBaseInterface
{
    public function getPaginationInfo();

    public function setPaginationInfo($PaginationInfo);

    public function getAuthenticate();
}