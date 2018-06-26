<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 14/05/17
 * Time: 9:50 CH
 */

namespace App\Models;


use App\Models\Interfaces\IBaseInterface;
use Illuminate\Database\Eloquent\Model;
use JWTAuth;
use Illuminate\Support\Facades\DB;

define("STR_ZERO_ERROR", "00");
define("STR_ONE_ERROR", "01");
define("STR_TWO_ERROR", "02");
define("STR_FIVE_ERROR", "05");
class BaseModel extends Model implements IBaseInterface
{
    public $PaginationInfo;

    /**
     * @return mixed
     */
    public function getPaginationInfo()
    {
        return $this->PaginationInfo;
    }

    /**
     * @param mixed $PaginationInfo
     */
    public function setPaginationInfo($PaginationInfo)
    {
        $this->PaginationInfo = $PaginationInfo;
    }

    public function getAuthenticate()
    {
        try {
            if (!$infoUser = JWTAuth::parseToken()->authenticate()) {
                $result = array(
                    'check' => false,
                    'error' => "401",
                );
                return $result;
            }
            //echo $token = JWTAuth::getToken(); // Lay nguyen chuoi Token
            compact('infoUser');
            $result = array(
                'check' => true,
                'error' => "0",
                'id' => $infoUser->id,
                'name' => $infoUser->name,
                'email' => $infoUser->email,
                'password' => $infoUser->password,
            );
            /*  echo response()->json(compact('infoUser'));*/
            return $result;
        } catch (Exception $ex) {
            \Log::error($ex);
            $result = array(
                'check' => false,
                'error' => "500",
            );
            return $result;
        }
    }
}