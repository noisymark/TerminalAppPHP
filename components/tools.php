<?php
class Tools{

    public static function numberRange($message,$min,$max){
        while(true){
            $i=readline($message);
            $i=(int)$i;
            if($i<$min || $i>$max){
                echo 'Input must be between ' . $min . ' & ' . $max . PHP_EOL;
                continue;
            }
            return $i;
        }
    }

    public static function textInput($message,$value=''){
        while(true){
            $s=readline($message);
            $s=trim($s);
            if(strlen($s)===0 && $value===''){
                echo 'REQUIRED INPUT!' . PHP_EOL;
                continue;
            }
            if(strlen($s)===0 && $value!==''){
                return $value;
            }
            return $s;
        }
    }

    public static function doubleInput($message){
        while(true){
            $s=readline($message);
            $s=(double)$s;
            if($s<=0){
                echo 'Number must be higher than 0' . PHP_EOL;
                continue;
            }
            return $s;
        }
    }
}
?>