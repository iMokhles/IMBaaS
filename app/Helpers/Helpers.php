<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 28/07/2017
 * Time: 15:01
 */

namespace App\Helpers;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Helpers {

    public static function getSideMenuItems() {
        return self::all("sidemenu_classes");
    }

    /** Database */
    public static function parseSqlTable($table) {
        $f = explode('.', $table);
        if(count($f) == 1) {
            return array("table"=>$f[0], "database"=>env('DB_DATABASE'));
        } elseif(count($f) == 2) {
            return array("database"=>$f[0], "table"=>$f[1]);
        }elseif (count($f) == 3) {
            return array("table"=>$f[0],"schema"=>$f[1],"table"=>$f[2]);
        }
        return false;
    }
    public static function first($table,$id) {
        $table = self::parseSqlTable($table)['table'];
        if(is_int($id)) {
            return DB::table($table)->where('id',$id)->first();
        }elseif (is_array($id)) {
            $first = DB::table($table);
            foreach($id as $k=>$v) {
                $first->where($k,$v);
            }
            return $first->first();
        } else {
            return DB::table($table)->where('id',$id)->first();
        }
    }
    public static function all($table) {
        $table = self::parseSqlTable($table)['table'];
        return DB::table($table)->get();
    }
    public static function allWhere($table, $id) {
        $table = self::parseSqlTable($table)['table'];
        $table = DB::table($table);
        foreach($id as $k=>$v) {
            $table->where($k, $v);
        }

        return $table->get();
    }
    public static function delete($table,$id) {
        $table = self::parseSqlTable($table)['table'];
        if(is_int($id)) {
            return DB::table($table)->where('id',$id)->delete();
        }elseif (is_array($id)) {
            $first = DB::table($table);
            foreach($id as $k=>$v) {
                $first->where($k,$v);
            }
            return $first->delete();
        }
    }
    public static function insertToTable($table,$data=[]) {
        $data['id'] = DB::table($table)->max('id') + 1;
        if(!$data['created_at']) {
            if(Schema::hasColumn($table,'created_at')) {
                $data['created_at'] = date('Y-m-d H:i:s');
            }
        }
        if(DB::table($table)->insert($data)) return $data['id'];
        else return false;
    }
    public static function updateRecord($table, $id, $data=[]) {
        if(!$data['updated_at']) {
            if(Schema::hasColumn($table,'updated_at')) {
                $data['updated_at'] = Carbon::now();
            }
        }
        if(is_int($id)) {
            $record_updated = DB::table($table)->where('id',$id)->update($data);
            if($record_updated) return true;
            else return false;
        } else {
            $record_updated = DB::table($table);
            foreach($id as $k=>$v) {
                $record_updated->where($k,$v);
            }
            $record_updated->update($data);
            if($record_updated) return true;
            else return false;
        }
    }
    public static function getStringAfter($symbol, $fullString) {
        return substr($fullString, strpos($fullString, $symbol)+1);
    }
    public static function getStringBefore($symbol, $fullString) {
        return substr($fullString, 0, strpos($fullString, $symbol));
    }
    public static function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
    public static function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
}