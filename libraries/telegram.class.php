<?php
class Telegram
{
    public static function SendMessage($token,$id,$message)
    {     
        $sendto ="https://api.telegram.org/bot"."$token/"."sendmessage?chat_id=".$id."&text=".$message;
       
        file_get_contents($sendto);
    }

    public static function SendPhoto($token,$id,$image,$caption)
    {      
        $url ="https://api.telegram.org/bot"."$token/"."sendPhoto?chat_id=".$id."&photo=".$image."&caption=$caption";
        echo "<br/>" . $url. "<hr/>";
        file_get_contents($url);
    }

    public static function SendVideo($token,$id,$video,$caption)
    {
        $url ="https://api.telegram.org/bot"."$token/"."sendVideo?chat_id=".$id."&video=".$video."&caption=$caption";
        file_get_contents($url); 
    }

    public static function SendAudio($token,$id,$audio,$caption)
    {
        $url ="https://api.telegram.org/bot"."$token/"."sendaudio?chat_id=".$id."&audio=".$audio."&caption=$caption";
        file_get_contents($url); 
    }


    public static function SendFile($token,$id,$file,$caption)
    {
        $url ="https://api.telegram.org/bot"."$token/"."sendPhoto?chat_id=".$id."&photo=".$file."&caption=$caption";
        file_get_contents($url); 
    }
}

//sendTelegramByImage("123456789:34lk434u543bjkb4jkb43","@test_chanel12","http://it-w3.ir/Content/Home/img/HomeImage/726372_d129.jpg","توضیحات مربوط به عکس");
?>