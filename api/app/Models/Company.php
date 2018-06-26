<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 14/05/17
 * Time: 9:55 CH
 */

namespace App\Models;


use App\Models\Interfaces\ICompanyInterface;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;
use Excel;
use \stdClass;

class Company extends BaseModel implements ICompanyInterface
{
    protected $table = 'p01_tbl_company';

    public function func_insert($company)
    {
        DB::beginTransaction();
        try {
            DB::insert('insert into p01_tbl_company (name, city, zip, country, description) values (?,?,?,?,?)'
                , [$company->name, $company->city, $company->zip, $company->country, $company->description]);
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

    public function func_update($company)
    {
        DB::beginTransaction();
        try {
            DB::update('update p01_tbl_company set
                        name = ?, city = ?, zip = ?, country = ?, description= ? 
                        where id = ?'
                , [$company->name, $company->city, $company->zip, $company->country, $company->description, $company->id]
            );
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
            DB::delete('delete from p01_tbl_staff WHERE companyID=?', [$id]);
            DB::delete('delete from p01_tbl_company WHERE id=?', [$id]);
            DB::commit();
            return STR_TWO;
        } catch (Exception $ex) {
            DB::rollback();
            \Log::error($ex);
            return STR_TWO_ERROR;
        }
    }

    public function func_getCompany($page)
    {
        try {
            $this->PaginationInfo = new PaginationInfo();
            $this->PaginationInfo->setCurrentPage($page);
            $this->PaginationInfo->setTotalItems(DB::select('select count(*) as total from p01_tbl_company')[0]->total, $page);
            $this->PaginationInfo->setTotalPages($this->PaginationInfo->getTotalItems());
            $this->PaginationInfo->setNumOfRowsToSkip($page);

            //Get list company
            $companies = DB::select('select * from p01_tbl_company ORDER BY id limit ?,?'
                , [$this->PaginationInfo->getNumOfRowsToSkip(), $this->PaginationInfo->getPageSize()]
            );
            /*Add new object to list object*/
            /*$obj = new stdClass;
            $obj->Id = "addThem";
            $obj->Name= "addThem";
            array_push($staffs, $obj);*/
            return $companies;
        } catch (Exception $ex) {
            \Log::error($ex);
            return STR_FIVE_ERROR;
        }
    }

    public function func_getCompanyById($id)
    {
        try {
            $company = DB::select('select * from p01_tbl_company WHERE id =?', [$id]);
            return $company;
        } catch (Exception $ex) {
            \Log::error($ex);
            return STR_FIVE_ERROR;
        }

    }

    public function func_getAllCompanyExport()
    {
        try {
            $company = DB::select('select * from p01_tbl_company');
            return $company;
        } catch (Exception $ex) {
            \Log::error($ex);
            return STR_FIVE_ERROR;
        }
    }

    public function func_exportExcel()
    {
        /*$str = "word-break";
        $str = str_replace("'", "\'", $str);
        $strKeyword = '';
        $strList = explode(" ", $str);
        foreach ($strList as $i) {
            $strKeyword .= '"' . $i . '"';
        }
        echo($strKeyword);

        $company = DB::select("SELECT
                                    c.id AS id_company,
                                    c.name,
                                    c.city,
                                    c.zip,
                                    c.country,
                                    c.description,
                                    s.id AS id_staff,
                                    s.firstname,
                                    s.lastName,
                                    s.note,
                                    s.dateOfBirth,
                                    (SUM(MATCH (name , city , zip , country , description) AGAINST ('$strKeyword' IN BOOLEAN MODE)) + SUM(MATCH (firstname , lastName , note) AGAINST ('$strKeyword' IN BOOLEAN MODE))) AS score
                                FROM
                                  p01_tbl_company c
                                RIGHT JOIN
                                  p01_tbl_staff s ON s.companyId = c.id
                                WHERE
                                    MATCH (name , city , zip , country , description) AGAINST ('$strKeyword' IN BOOLEAN MODE)
                                    OR MATCH (firstname , lastName , note) AGAINST ('$strKeyword' IN BOOLEAN MODE)
                                GROUP BY s.id
                                ORDER BY score DESC");*/
        $companyList = $this->func_getAllCompanyExport();
        // Initialize the array which will be passed into the Excel
        // generator.
        $companyArray = [];

        // Define the Excel spreadsheet headers
        $companyArray[] = ['Id', 'Name', 'City', 'Zip', 'Country', 'Description'];

        // Convert each member of the returned collection into an array,
        // and append it to the company array.
        foreach ($companyList as $company) {
            /*  array_push($companyArray, $payment);*/
            $companyArray[] = json_decode(json_encode($company), True);;
        }

        // Generate and return the spreadsheet
        Excel::create('company', function ($excel) use ($companyArray) {
            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Company');
            $excel->setCreator('Laravel')->setCompany('AmagumoLab');
            $excel->setDescription('List Company');

            // Build the spreadsheet, passing in the company array
            $excel->sheet('sheet1', function ($sheet) use ($companyArray) {
                // format before add data(@ is format number)
                $sheet->setColumnFormat(['A' => '@']);
                // add data to excel file
                $sheet->fromArray($companyArray, null, 'A1', false, false);
                $sheet->cells('A1:F1', function ($cells) {
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
                $sheet->setBorder('A1:F' . count($companyArray), 'thin');
                /*$sheet->rows($companyArray);*/
            });
        })->download('pdf');
    }
}