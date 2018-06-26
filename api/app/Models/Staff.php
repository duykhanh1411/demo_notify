<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 04/05/17
 * Time: 2:39 CH
 */

namespace App\Models;

use App\Models\Interfaces\IStaffInterface;
use Illuminate\Database\Eloquent\Model;
use Mockery\Exception;
use \stdClass;
use JWTAuth;
use Illuminate\Support\Facades\DB;
use DateTime;
use Excel;

class Staff extends BaseModel implements IStaffInterface
{
    protected $table = 'p01_tbl_staff';

    public function func_insert($staff)
    {
        DB::beginTransaction();
        try {
            DB::insert('insert into p01_tbl_staff (dateOfBirth, firstname, lastName, note, companyId, image) values (?,?,?,?,?,?)'
                , [$staff->dateOfbirth, $staff->firstname, $staff->lastName, $staff->note, $staff->companyId, $staff->image]);
            /*$id = DB::table('staff')->insertGetId(
                array('Name' => ''+$name)
            );*/
            DB::commit();
            return STR_ZERO;
        } catch (Exception $ex) {
            DB::rollback();
            \Log::error($ex);
            return STR_ZERO_ERROR;
        }
    }

    public function func_update($staff)
    {
        DB::beginTransaction();
        try {
            DB::update('update p01_tbl_staff set dateOfBirth= ?, firstname= ?, lastName= ?, note= ?, companyId= ?, image=?
                        where id = ?'
                , [$staff->dateOfbirth, $staff->firstname, $staff->lastName, $staff->note, $staff->companyId, $staff->image, $staff->id]);
            DB::commit();
            return STR_ONE;
        } catch (Exception $ex) {
            DB::rollback();
            \Log::error($ex);
            return STR_ONE_ERROR;
        }
    }

    public function func_delete($id)
    {
        DB::beginTransaction();
        try {
            DB::delete('delete from p01_tbl_staff WHERE id=?', [$id]);
            DB::commit();
            return STR_TWO;
        } catch (Exception $ex) {
            DB::rollback();
            \Log::error($ex);
            return STR_TWO_ERROR;
        }
    }

    public function func_getStaff($page)
    {
        try {
            //set info paging
            $this->PaginationInfo = new PaginationInfo();
            $this->PaginationInfo->setCurrentPage($page);
            $this->PaginationInfo->setTotalItems(DB::select('select count(*) as total from p01_tbl_staff')[0]->total, $page);
            $this->PaginationInfo->setTotalPages($this->PaginationInfo->getTotalItems());
            $this->PaginationInfo->setNumOfRowsToSkip($page);

            //get list with limit 10 record on page
            $staffs = DB::select('SELECT s.id, s.dateOfBirth, s.firstname, s.lastName, s.note, s.companyId, s.dateOfBirth, s.image, c.name as companyName
                                FROM p01_tbl_staff s left JOIN p01_tbl_company c
                                ON s.companyId = c.id
                                ORDER BY s.id limit ?,?'
                , [$this->PaginationInfo->getNumOfRowsToSkip(), $this->PaginationInfo->getPageSize()]);
            /*Add new object to list object*/
            /*$obj = new stdClass;
            $obj->Id = "addThem";
            $obj->Name= "addThem";
            array_push($staffs, $obj);*/
            $staffListData = array();

            //format dateOfBirth is display value on list view
            //format dateOfBirthValue is value load to control
            foreach ($staffs as $staff) {
                $obj = new stdClass;
                $obj = $staff;
                if ($obj->dateOfBirth != "") {
                    $obj->dateOfBirthValue = date_format(new DateTime($staff->dateOfBirth), "Y-m-d");
                    $obj->dateOfBirth = date_format(new DateTime($staff->dateOfBirth), "d/m/Y");
                } else $obj->dateOfBirthValue = null;
                if ($obj->image != "") {
                    $obj->imageUrl = 'api\public\staffs' . '\\' . $obj->image;
                } else $obj->imageUrl = null;
                array_push($staffListData, $obj);
            }
            return $staffListData;
        } catch (Exception $ex) {
            \Log::error($ex);
            return STR_FIVE_ERROR;
        }
    }

    //Get data for combobox
    public function getAllCompany()
    {
        $company = DB::select('select id, name from p01_tbl_company ORDER BY id');
        /* $obj = new stdClass;
         $obj->id = 0;
         $obj->name = "";
         array_push($company, $obj);*/
        return $company;
    }

    //upload file image to p01_p01_user
    public function updateUserImage($file)
    {
        DB::beginTransaction();
        try {
            $infoUser = JWTAuth::parseToken()->authenticate();
            DB::update('update p01_user set image= ? where id = ?', [$file->getClientOriginalName(), $infoUser->id]);
            DB::commit();
            /* $result = "Upload success";*/
        } catch (Exception $ex) {
            \Log::error($ex);
            DB::rollback();
            return STR_FIVE_ERROR;
        }
        $destinationPath = public_path() . "\uploads";
        $file->move($destinationPath, $file->getClientOriginalName());
        $imageUrl = 'api\public\uploads' . '\\' . $file->getClientOriginalName();
        $result = array(
            'error' => "0",
            'userName' => $infoUser->name,
            'imageUrl' => $imageUrl
        );
        return $result;
    }

    //upload file image to p01_user
    public function updateStaffImage($file)
    {
        $destinationPath = public_path() . "\staffs";
        $file->move($destinationPath, $file->getClientOriginalName());
        $imageUrl = 'api\public\staffs' . '\\' . $file->getClientOriginalName();
        $result = array(
            'error' => "0",
            'imageUrl' => $imageUrl,
            'imageStaff' => $file->getClientOriginalName()
        );
        return $result;
    }

    //Search keyword
    public function getSearchStaffList($page, $str)
    {
        try {
            /*$str = "word-break";*/
            $str = str_replace("'", "\'", $str);
            $strKeyword = '';
            $strList = explode(" ", $str);
            foreach ($strList as $i) {
                $strKeyword .= '"' . $i . '"';
            }
            //set info paging
            $this->PaginationInfo = new PaginationInfo();
            $this->PaginationInfo->setCurrentPage($page);
            $this->PaginationInfo->setTotalItems(
                DB::select("SELECT 
                COUNT(*) AS total
                FROM
                    (SELECT 
                       s.id
                     FROM
                       p01_tbl_company c
                     RIGHT JOIN p01_tbl_staff s ON s.companyId = c.id
                     WHERE
                       MATCH (name , city , zip , country , description) AGAINST ('$strKeyword' IN BOOLEAN MODE)
                       OR MATCH (firstname , lastName , note) AGAINST ('$strKeyword' IN BOOLEAN MODE)
                     GROUP BY s.id) AS staff")[0]->total
                , $page
            );
            $this->PaginationInfo->setTotalPages($this->PaginationInfo->getTotalItems());
            $this->PaginationInfo->setNumOfRowsToSkip($page);

            //get list with limit 10 record on page
            $staffs = DB::select("SELECT
                                    s.id AS id_staff,
                                    s.firstname,
                                    s.lastName,
                                    s.note,
                                    s.dateOfBirth,
                                    s.image,
                                    c.id AS id_company,
                                    c.name,
                                    c.city,
                                    c.zip,
                                    c.country,
                                    c.description,
                                    (SUM(MATCH (name , city , zip , country , description) AGAINST ('$strKeyword' IN BOOLEAN MODE)) + SUM(MATCH (firstname , lastName , note) AGAINST ('$strKeyword' IN BOOLEAN MODE))) AS score
                                FROM
                                  p01_tbl_company c
                                RIGHT JOIN
                                  p01_tbl_staff s ON s.companyId = c.id
                                WHERE
                                    MATCH (name , city , zip , country , description) AGAINST ('$strKeyword' IN BOOLEAN MODE)
                                    OR MATCH (firstname , lastName , note) AGAINST ('$strKeyword' IN BOOLEAN MODE)
                                GROUP BY s.id
                                ORDER BY score DESC
                                LIMIT ?,?", [$this->PaginationInfo->getNumOfRowsToSkip(), $this->PaginationInfo->getPageSize()]);
            $staffListData = array();
            /*format dateOfBirth is display value on list view
            format dateOfBirthValue is value load to control*/
            foreach ($staffs as $staff) {
                $obj = new stdClass;
                $obj = $staff;
                if ($obj->dateOfBirth != "") {
                    $obj->dateOfBirthValue = date_format(new DateTime($staff->dateOfBirth), "Y-m-d");
                    $obj->dateOfBirth = date_format(new DateTime($staff->dateOfBirth), "d/m/Y");
                } else $obj->dateOfBirthValue = null;
                if ($obj->image != "") {
                    $obj->imageUrl = 'api\public\staffs' . '\\' . $obj->image;
                } else $obj->imageUrl = null;
                array_push($staffListData, $obj);
            }
            return $staffListData;

        } catch (Exception $ex) {
            \Log::error($ex);
            return STR_FIVE_ERROR;
        }
    }

    //Export Excel for search keyword
    public function func_exportExcel($str)
    {
        $str = str_replace("'", "\'", $str);
        $strKeyword = '';
        $strList = explode(" ", $str);
        foreach ($strList as $i) {
            $strKeyword .= '"' . $i . '"';
        }
        $staffList = $this->func_getAllStaffExport($strKeyword);
        // Initialize the array which will be passed into the Excel
        // generator.
        $staffArray = [];

        // Define the Excel spreadsheet headers
        $staffArray[] = [
            'Id Staff'
            , 'First Name'
            , 'Last Name'
            , 'Note'
            , 'Date Of Birth'
            , 'Image'
            , 'Id Company'
            , 'Company Name'
            , 'City'
            , 'Zip Code'
            , 'Country'
            , 'Description'
            , 'Score'
        ];

        // Convert each member of the returned collection into an array,
        // and append it to the company array.
        foreach ($staffList as $staff) {
            /*  array_push($companyArray, $payment);*/
            $staffArray[] = json_decode(json_encode($staff), True);;
        }

        // Generate and return the spreadsheet
        Excel::create('company', function ($excel) use ($staffArray) {
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Company');
            $excel->setCreator('Laravel')->setCompany('AmagumoLab');
            $excel->setDescription('List Company');

            // Build the spreadsheet, passing in the company array
            $excel->sheet('sheet1', function ($sheet) use ($staffArray) {
                // format before add data(@ is format number)
                $sheet->setColumnFormat([
                    'A' => '@',
                    'E' => 'dd/mm/yyyy',
                ]);

                // add data to excel file
                $sheet->fromArray($staffArray, null, 'A1', false, false);
                $sheet->cells('A1:M1', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFont(array(
                        'family' => 'Calibri',
                        'size' => '15',
                        'bold' => true
                    ));
                    $cells->setFontColor('#ffffff');
                    $cells->setBackground('#578ebe');
                    $cells->setBorder('solid', 'solid', 'solid', 'solid');
                    // manipulate the range of cells
                });
                $sheet->setBorder('A1:M' . count($staffArray), 'thin');
                /*$sheet->rows($companyArray);*/
            });
        })->download('xlsx');
    }

    //Get data for export Excel
    public function func_getAllStaffExport($strKeyword)
    {
        try {
            $staffList = DB::select("SELECT
                                    s.id AS id_staff,
                                    s.firstname,
                                    s.lastName,
                                    s.note,
                                    s.dateOfBirth,
                                    s.image,
                                    c.id AS id_company,
                                    c.name,
                                    c.city,
                                    c.zip,
                                    c.country,
                                    c.description,
                                    (SUM(MATCH (name , city , zip , country , description) AGAINST ('$strKeyword' IN BOOLEAN MODE)) + SUM(MATCH (firstname , lastName , note) AGAINST ('$strKeyword' IN BOOLEAN MODE))) AS score
                                FROM
                                  p01_p01_tbl_company c
                                RIGHT JOIN
                                  p01_tbl_staff s ON s.companyId = c.id
                                WHERE
                                    MATCH (name , city , zip , country , description) AGAINST ('$strKeyword' IN BOOLEAN MODE)
                                    OR MATCH (firstname , lastName , note) AGAINST ('$strKeyword' IN BOOLEAN MODE)
                                GROUP BY s.id
                                ORDER BY score DESC");
            return $staffList;
        } catch (Exception $ex) {
            \Log::error($ex);
            return STR_FIVE_ERROR;
        }
    }
}