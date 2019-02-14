<?php
/**
 * Created by PhpStorm.
 * User: ming
 * Date: 2019/2/8
 * Time: 下午3:54
 */
namespace app\index\model;
use think\Model;
use think\Db;

class Bank extends Model
{
    //查找所有lol账号
    public function lol_select() {
        return Db::table('num_bank')->where('app_id',1)->select();
    }
}