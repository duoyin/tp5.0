<?php
namespace app\index\controller;
use think\Controller;
use think\captcha\Captcha;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }

    public function hello()
    {
        return $this->fetch();
    }
    //验证码
    public function verify()
    {
        $captcha = new Captcha();
        return $captcha->entry();
    }
    //验证码识别
    public function shibie()
    {
        $imagePath = 'images/10.png';
        $res = imagecreatefrompng($imagePath);
        $size = getimagesize($imagePath);
        echo "<img src='/$imagePath' /> <br />";
        for ($i = 0; $i < $size[1]; ++$i) {
            for ($j = 0; $j < $size[0]; ++$j) {
                $rgb = imagecolorat($res, $j, $i);
                $rgbarray = imagecolorsforindex($res, $rgb);
                if ($rgbarray['red'] < 200) {
                    $data[$i][$j] = 1;
                }else{
                    $data[$i][$j] = 0;
                }
            }
        }
        $code = $this->fen($data);
        foreach ($code as $key=>$value) {
            $code[$key] = $this->zheng($this->quZero($value));
            //$this->haha($code[$key]);
        }
        $this->haha($code[0]);
        foreach ($code[0] as $key=>$value) {
            $ye[$key]['y'] = $key;
            $num = 0;
            $sum = 0;
            foreach ($value as $key1=>$value1) {
                if ($value1==1) {
                    $sum += $key1;
                    $num++;
                }
            }
            $ye[$key]['x'] = $sum/$num;
        }
        //dump($ye);die;
        $ab = $this->getHuigui($ye);
        //$ab['b'] = 3/4.0;
        //求倾斜夹角
        //$jiajiao = atan($ab['b']);
        //echo $jiajiao;die;
        //echo sin(pi()/2);die;
        //echo pi()/2;
        //echo '<br>';
        //echo atan(3/4)+atan(4/3);die;

        //中间点的坐标
        $zhong_y = (count($code[0])-1)/2;
        $zhong_x = ($zhong_y-$ab['a'])/$ab['b'];
        //dump($ab);
//        foreach ($code[0] as $key=>$value) {
//            foreach ($value as $key1=>$value1) {
//                $chuli[$key][$key1] = 0;
//            }
//        }
        for ($i=0;$i<50;$i++) {
            for ($j=0;$j<50;$j++) {
                $chuli[$i][$j] = 0;
            }
        }
        $weizhi['z'] = 0;
        $weizhi['y'] = 0;
        $weizhi['s'] = 0;
        $weizhi['x'] = 0;
        $num = 0;
        foreach ($code[0] as $key=>$value) {
            foreach ($value as $key1=>$value1) {
                if ($value1==1) {
                    $num++;
                    $y = $key;
                    $x = $key1;
                    $suan_y = $x*$ab['b']+$ab['a'];
                    if ($suan_y>$y) {
                        $weizhi['z']++;
                    }
                    if ($suan_y<$y) {
                        $weizhi['y']++;
                    }
                    //平行线
                    $b_p = 1/$ab['b'];
                    $a_p = $zhong_y-$b_p*$zhong_x;
                    $ping_y = $x*$b_p+$a_p;
                    if ($ping_y>$y) {
                        $weizhi['s']++;
                    }
                    if ($ping_y<$y) {
                        $weizhi['x']++;
                    }
                    //echo $zhong_x;die;
//                    echo $key.'/'.$key1;
//                    echo '<br>';
//                    echo $y.'/'.$x;
//                    echo '<br>';
                    // $p = $this->getNewZuobiao($x,$y,$ab['b']);
                    //$p['x'] = (sin(atan($y/$x)+$jiajiao))*sqrt($x*$x*1.0+$y*$y)+$zhong_x;
                    //$p['y'] = (cos(atan($y/$x)+$jiajiao))*sqrt($x*$x*1.0+$y*$y)+$zhong_y;
                    //$p['x'] = ($y-$zhong_y)*cos($jiajiao)-($x-$zhong_x)*sin($jiajiao)+$zhong_y;
                    //$p['y'] = ($x-$zhong_x)*cos($jiajiao)+($y-$zhong_y)*sin($jiajiao)+$zhong_x;
                    // $x = round($p['x']);
                    // $y = round($p['y']);
                    //echo round($p['x']).'/'.round($p['y']);die;
                    // $chuli[$x][$y] = 1;
                }
            }
        }
        dump($num);
        dump($weizhi);die;
        //dump($chuli);die;
        $this->haha($chuli);
    }
    //规整二维数组
    public function zheng($data) {
        $i = 0;
        foreach ($data as $value) {
            foreach ($value as $value1) {
                $mmp[$i][] = $value1;
            }
            $i++;
        }
        return $mmp;
    }
    //直观输出二维数组
    public function haha($data) {
        foreach ($data as $i=>$value) {
            foreach ($value as $j=>$value1) {
                if ($value1 == 0) {
                    echo "0";
                }else{
                    echo "-";
                }
            }
            echo "<br>";
        }
    }
    //二维数组互换行列
    public function huan($data) {
        $i=0;
        foreach ($data as $value) {
            $j = 0;
            foreach ($value as $value1) {
                $p[$j][$i] = $value1;
                $j++;
            }
            $i++;
        }
        return $p;
    }
    //把一行全是0的行去掉
    public function quZero($data) {
        foreach ($data as $key=>$datum) {
            if (!in_array(1,$datum)) {
                unset($data[$key]);
            }
        }
        return $data;
    }
    //分割字符串
    public function fen($data) {
        $data = $this->huan($data);
        $i = 0;
        foreach ($data as $key=>$value) {
            if (in_array(1,$value)) {
                $code[$i][] = $value;
                unset($data[$key]);
            } else {
                if (isset($code[$i])) {
                    $i++;
                }
            }
        }
        foreach ($code as $key=>$value) {
            $code[$key] = $this->huan($value);
        }
        return $code;
    }
    /*
     *定义求线性回归A和B的函数
     *@param $zuobiaoArray坐标的三维数组
     */
    function getHuigui($zuobiaoArray){
        $y8 = 0;
        $x8 = 0;
        $x2 = 0;
        $xy = 0;
        $geshu = count($zuobiaoArray);
        for($i=0;$i<$geshu;$i++){
            $y8 = $y8+$zuobiaoArray[$i]['y'];
            $x8 = $x8+$zuobiaoArray[$i]['x'];
            $xy = $xy+$zuobiaoArray[$i]['y']*$zuobiaoArray[$i]['x'];
            $x2 = $x2 + $zuobiaoArray[$i]['x']*$zuobiaoArray[$i]['x'];;
        }
        $y8 = $y8/$geshu;
        $x8 = $x8/$geshu;

        $b = ($xy-$geshu*$y8*$x8)/($x2-$geshu*$x8*$x8);
        $a = $y8-$b*$x8;
        $re['a'] = $a;
        $re['b'] = $b;
        return $re;
        //y = b * x + a
    }
    /*
 *定义转化坐标的函数
 *@param $x x坐标即$i
 *@param $y y坐标，即j
 *@param $b 线性回归方程的b参数
 */
    public function getNewZuobiao($x,$y,$b){
        if($x == 0){
            if($y>0){
                $xianJiao = M_PI/2;
            }elseif($y<0){
                $xianJiao = -M_PI/2;
            }else{
                $p['x'] = 0;
                $p['y'] = 0;
                return $p;
            }
        }else{
            $xianJiao = atan($y/$x);
        }
        $jiao =$xianJiao-atan($b);
        $chang = sqrt($x*$x+$y*$y);
        $p['x'] = $chang*cos($jiao);
        $p['y'] = $chang*sin($jiao);
        return $p;
    }
}
