<?php
/*
 * 此文件用于验证短信服务API接口，供开发时参考
 * 执行验证前请确保文件为utf-8编码，并替换相应参数为您自己的信息，并取消相关调用的注释
 * 建议验证前先执行Test.php验证PHP环境
 *
 * 2017/11/30
 */

namespace Aliyun\DySDKLite\Sms;

require_once "SignatureHelper.php";

use Aliyun\DySDKLite\SignatureHelper;

session_start();
if (!isset($_SESSION['push-username'])) {
    echo "<script>alert('用户未登录，请先登录！')</script>";
   header("Location: ../index.php");
    exit();
}

outputMessage('下单成功，宣网人正在加急赶来的路上，不要着急，千万不要重复下单哦~', 'push_userpage.php');
exit();
//改好之后记得把这两句话删掉哈！

include('connect.php');//引入conn对象
if ($_SESSION['potType'] != 'other')
    $potType = $_SESSION['potType'];
else
    $potType = "（其它）" . $_SESSION['comment'];
//$potType = $row['potType'];
$params = array();
$sql = /** @lang MySQL */
    "SELECT * FROM register WHERE pullAccess=1";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)) {
    $params["PhoneNumbers"] = $row['phone'];
    $params['TemplateParam'] = array(
        "username" => $row['name'],
        "name" => $_SESSION['name'],
        "dp_name" => $_SESSION['dp_name'],
        "potType" => $potType,
        "ddl" => $_SESSION['ddl']
    );
//    echo print_r($params).'|';
    echo print_r(sendSms($params)).'<br>';
//    echo sendSms($params);
}
unset ($_SESSION['name']);
unset ($_SESSION['dp_name']);
unset ($_SESSION['ddl']);
unset ($_SESSION['name']);
unset ($_SESSION['comment']);
unset ($_SESSION['pushpot']);
outputMessage('下单成功，宣网人正在加急赶来的路上，不要着急，千万不要重复下单哦~', 'push_userpage.php');

//header("Location: pushfile.php");
/**
 * 发送短信
 */
function sendSms($params)
{


    // *** 需用户填写部分 ***
    // fixme 必填：是否启用https
    $security = false;

    // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
    $accessKeyId = "LTAI4G2SdVKf1xbpGxSWJwUQ";
    $accessKeySecret = "LtTURPKnjJJT3ifwSNOmEXpN8NhBZj";

    // fixme 必填: 短信接收号码
//    $params["PhoneNumbers"] = "17300989938";

    // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
    $params["SignName"] = "CKCSU";

    // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
    $params["TemplateCode"] = "SMS_212486841";

    // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
//    $params['TemplateParam'] = Array (
//        "username" => "黄文翀",
//        "dp_name" => "宣传与网络中心",
//        "potType" => "测试",
//        "name" => "短信发送模块测试",
//        "ddl" => "2021-03-31"
//    );

    // fixme 可选: 设置发送短信流水号
    $params['OutId'] = "12345";

    // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
    $params['SmsUpExtendCode'] = "1234567";


    // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
    if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
        $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
    }

    // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
    $helper = new SignatureHelper();

    // 此处可能会抛出异常，注意catch
    $content = $helper->request(
        $accessKeyId,
        $accessKeySecret,
        "dysmsapi.aliyuncs.com",
        array_merge($params, array(
            "RegionId" => "cn-hangzhou",
            "Action" => "SendSms",
            "Version" => "2017-05-25",
        )),
        $security
    );

    return $content;
}

function outputMessage($text, $jumpto)
{
    $_SESSION['outputText'] = $text;
    $_SESSION['jumptoUrl'] = $jumpto;
    header('Location: output.php');
}


//
//ini_set("display_errors", "on"); // 显示错误提示，仅用于测试时排查问题
//// error_reporting(E_ALL); // 显示所有错误提示，仅用于测试时排查问题
//set_time_limit(0); // 防止脚本超时，仅用于测试使用，生产环境请按实际情况设置
//header("Content-Type: text/plain; charset=utf-8"); // 输出为utf-8的文本格式，仅用于测试
//
//// 验证发送短信(SendSms)接口
//print_r(sendSms($params));