<?php
namespace app\index\controller;
use think\Controller;
use think\captcha\Captcha;

class Index extends Controller
{
    public function index()
    {
        phpinfo();die;
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
    public function dddd() {
        //return [101,73,86,88];
        [70,88,93,65];
        return [66,58,52,72];
    }
    //验证码识别
    public function shibie()
    {
        $imagePath = 'images/17.png';
        //$daan = array('J','N','W');
        //$this->stude($imagePath,$daan);die;
        $res = imagecreatefrompng($imagePath);
        $size = getimagesize($imagePath);
        echo "<img src='/$imagePath' /> <br />";
        for ($i = 0; $i < $size[1]; ++$i) {
            for ($j = 0; $j < $size[0]; ++$j) {
                $rgb = imagecolorat($res, $j, $i);
                $rgbarray = imagecolorsforindex($res, $rgb);
                if ($rgbarray['red'] < 180) {
                    $data[$i][$j] = 1;
                }else{
                    $data[$i][$j] = 0;
                }
            }
        }
        $code = $this->fen($data);
        foreach ($code as $key=>$value) {
            $code[$key] = $this->zheng($this->quZero($value));
        }
        foreach ($code as $aige) {
            foreach ($aige as $key=>$value) {
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
            $ab = $this->getHuigui($ye);
            //中间点的坐标
            $zhong_y = (count($aige)-1)/2;
            $zhong_x = ($zhong_y-$ab['a'])/$ab['b'];
            $weizhi['z'] = 0;
            $weizhi['y'] = 0;
            $weizhi['s'] = 0;
            $weizhi['x'] = 0;
            $num = 0;
            foreach ($aige as $key=>$value) {
                foreach ($value as $key1=>$value1) {
                    if ($value1==1) {
                        $num++;
                        $y = $key;
                        $x = $key1;
                        $suan_y = $x*$ab['b']+$ab['a'];
                        if ($suan_y>$y) {
                            if ($ab['b']>0) {
                                $weizhi['z']++;
                            } else {
                                $weizhi['y']++;
                            }
                        }
                        if ($suan_y<$y) {
                            if ($ab['b']>0) {
                                $weizhi['y']++;
                            } else {
                                $weizhi['z']++;
                            }
                        }
                        //平行线
                        $b_p = 1/$ab['b'];
                        $a_p = $zhong_y-$b_p*$zhong_x;
                        $ping_y = $x*$b_p+$a_p;
                        if ($ping_y>$y) {
                            if ($b_p>0) {
                                $weizhi['s']++;
                            } else {
                                $weizhi['x']++;
                            }
                        }
                        if ($ping_y<$y) {
                            if ($b_p>0) {
                                $weizhi['x']++;
                            } else {
                                $weizhi['s']++;
                            }
                        }
                    }
                }
            }
            dump($weizhi);
//            echo $this->duibi($weizhi);
//            echo '<br>';
        }
    }
    //对比
    public function duibi($weizhi) {
        $file='code/4ttf.php';
        $handle=fopen($file,'r');
        $array=unserialize(fread($handle,filesize($file)));
        $eq = 100000000;
        foreach ($array as $key=>$item) {
            //dump($weizhi);
            //dump($item);die;
            $sum = pow(($item['s']-$weizhi['s']),2)+pow(($item['x']-$weizhi['x']),2)+pow(($item['z']-$weizhi['z']),2)+pow(($item['y']-$weizhi['y']),2);
            //echo $sum.'/';
            if ($sum < $eq) {
                $eq = $sum;
                //dump($eq);
                $daan = $key;
            }
        }
        return $daan;
    }
    //存储数据
    public function stude($imagePath,$daan) {
        //dump($cacheArray);die;
        $res = imagecreatefrompng($imagePath);
        $size = getimagesize($imagePath);
        echo "<img src='/$imagePath' /> <br />";
        for ($i = 0; $i < $size[1]; ++$i) {
            for ($j = 0; $j < $size[0]; ++$j) {
                $rgb = imagecolorat($res, $j, $i);
                $rgbarray = imagecolorsforindex($res, $rgb);
                if ($rgbarray['red'] < 180) {
                    $data[$i][$j] = 1;
                }else{
                    $data[$i][$j] = 0;
                }
            }
        }
        $code = $this->fen($data);
        foreach ($code as $key=>$value) {
            $code[$key] = $this->zheng($this->quZero($value));
        }
        //$this->haha($code[2]);
        foreach ($code as $mp=>$aige) {
            foreach ($aige as $key=>$value) {
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
            $ab = $this->getHuigui($ye);

            //中间点的坐标
            $zhong_y = (count($aige)-1)/2;
            $zhong_x = ($zhong_y-$ab['a'])/$ab['b'];
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
            foreach ($aige as $key=>$value) {
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
                    }
                }
            }
            $file='code/4ttf.php';
            $handle=fopen($file,'r');
            $array=unserialize(fread($handle,filesize($file)));
            if (isset($array[$daan[$mp]])) {
                $k = $array[$daan[$mp]];
                $weizhi['s'] = ($k['s']+$weizhi['s'])/2;
                $weizhi['x'] = ($k['x']+$weizhi['x'])/2;
                $weizhi['z'] = ($k['z']+$weizhi['z'])/2;
                $weizhi['y'] = ($k['y']+$weizhi['y'])/2;
            }
            $array[$daan[$mp]]=array('s'=>$weizhi['s'],'x'=>$weizhi['x'],'z'=>$weizhi['z'],'y'=>$weizhi['y']);
            //dump($array);die;
            //缓存
            if(false!==fopen($file,'w+')){
                file_put_contents($file,serialize($array));//写入缓存
            }
//            die;
//            $this->haha($aige);
//            dump($weizhi);die;
        }
        //dump($chuli);die;
        //$this->haha($chuli);
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
    public function study() {
        $imagePath = 'images/11.png';
        $daan = array('D','V','D');
        $this->stude($imagePath,$daan);
    }
}
