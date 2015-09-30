<?php 

/*
 * author: Solon Ring
 * time: 2011-11-02
 * 发博时间计算(年，月，日，时，分，秒)
 * $createtime 可以是当前时间
 * $gettime 你要传进来的时间
 */

class Mygettime{
        function  __construct($createtime,$gettime) {
            $this->createtime = $createtime;
            $this->gettime = $gettime;
    }
    function getSeconds()
    {
            return $this->createtime-$this->gettime;
        }
    function getMinutes()
       {
       return ($this->createtime-$this->gettime)/(60);
       }
      function getHours()
       {
       return ($this->createtime-$this->gettime)/(60*60);
       }
      function getDay()
       {
        return ($this->createtime-$this->gettime)/(60*60*24);
       }
      function getMonth()
       {
        return ($this->createtime-$this->gettime)/(60*60*24*30);
       }
       function getYear()
       {
        return ($this->createtime-$this->gettime)/(60*60*24*30*12);
       }

       function index()
       {
            if($this->getYear() > 1)
            {
                 if($this->getYear() > 2)
                    {
                        return date("Y-m-d",$this->gettime);
                        exit();
                    }
                return intval($this->getYear())." 年前";
                exit();
            }
             elseif($this->getMonth() > 1)
            {
                return intval($this->getMonth())." 月前";
                exit();
            }
             elseif($this->getDay() > 1)
            {
                return intval($this->getDay())." 天前";
                exit();
            }
             elseif($this->getHours() > 1)
            {
                return intval($this->getHours())." 小时前";
                exit();
            }
             elseif($this->getMinutes() > 1)
            {
                return intval($this->getMinutes())." 分钟前";
                exit();
            }
           elseif($this->getSeconds() > 1)
            {
                return intval($this->getSeconds()-1)." 秒前";
                exit();
            }
             else
            {
                return "刚刚";
                exit();
            }
       }
  }

  