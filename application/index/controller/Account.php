<?php
/**
 * Created by PhpStorm.
 * User: ming
 * Date: 2019/2/8
 * Time: 下午3:37
 */
namespace app\index\controller;
use app\index\model\Bank;
use think\Controller;

class Account extends Controller
{
    //实例化Bank类（账号密码存储表）
    private $bank;

    public function __construct()
    {
        parent::__construct();
        $this->bank = new Bank();
    }
    //展现所有lol账号信息
    public function lol_show()
    {
        $lol_info = $this->bank->lol_select();
        $this->assign('lol_info',$lol_info);
        return $this->fetch();
    }
}
