<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 05/05/17
 * Time: 2:53 CH
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PaginationInfo extends Model
{
    public $PageSize;
    public $TotalItems=0;
    public $CurrentPage;
    public $NumOfRowsToSkip;
    public $TotalPages;

    /**
     * PaginationInfo constructor.
     */
    public function __construct()
    {
        $this->CurrentPage =1;
        $this->PageSize =10;
    }

    /**
     * @return mixed
     */
    public function getTotalPages($TotalItems)
    {
        return $this->TotalPages;
    }

    /**
     * @param mixed $TotalPages
     */
    public function setTotalPages($TotalItems)
    {
        if($this->PageSize==0){
            $this->TotalPages = 0;
        }else{
            $this->TotalPages= ceil($TotalItems/ $this->PageSize);
        }
    }

    /**
     * @return mixed
     */
    public function getNumOfRowsToSkip()
    {
        return $this->NumOfRowsToSkip;
    }

    /**
     * @param mixed $NumOfRowsToSkip
     */
    public function setNumOfRowsToSkip($CurrentPage)
    {
        $this->NumOfRowsToSkip = ($CurrentPage - 1) * $this->PageSize;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->CurrentPage;
    }

    /**
     * @param mixed $CurrentPage
     */
    public function setCurrentPage($CurrentPage)
    {
        $this->CurrentPage = $CurrentPage;
    }

    /**
     * @return mixed
     */
    public function getTotalItems()
    {
        return $this->TotalItems;
    }

    /**
     * @param mixed $TotalItems
     */
    public function setTotalItems($TotalItems,$CurrentPage)
    {
        $this->TotalItems = $TotalItems;
        if($TotalItems <= $this->PageSize *($CurrentPage -1)){
            $this->setCurrentPage($CurrentPage-1);
        }
    }

    /**
     * @return mixed
     */
    public function getPageSize()
    {
        return $this->PageSize;
    }

    /**
     * @param mixed $PageSize
     */
    public function setPageSize($PageSize)
    {
        $this->PageSize = $PageSize;
    }

}