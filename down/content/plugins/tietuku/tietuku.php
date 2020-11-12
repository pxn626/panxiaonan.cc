<?php
/*
Plugin Name: 贴图库云存储
Version: 1.1.1
Plugin URL:http://open.tietuku.com/plugins#emlog
Description: 将您博客上传的图片存储在贴图库云存储中并返回外链，无限空间、无限流量、无限数量、无水印、永久保存、高速cdn外链。。。  
ForEmlog:5.2.0
Author: tietuku.com
Author URL: http://tietuku.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
class tietusdk{
	private $accesskey;
	private $secretkey;
	private $base64param;
	function __construct($ak,$sk){
		if($ak == ''||$sk =='')
			return false;
		$this->accesskey = $ak;
		$this->secretkey = $sk;

	}
	public function Dealparam($param){
		$this->base64param = $this->Base64(json_encode($param));
		return $this;
	}
	public function Token(){
		$sign = $this->Base64($this->Sign($this->base64param,$this->secretkey));
		$token = $this->accesskey.':'.$sign.':'.$this->base64param;
		return $token;
	}
	public function Sign($str, $key){
		$hmac_sha1_str = "";
		if (function_exists('hash_hmac')){
			$hmac_sha1_str = $this->Base64(hash_hmac("sha1", $str, $key, true));
		} else {
			$blocksize = 64;
			$hashfunc  = 'sha1';
			if (strlen($key) > $blocksize){
				$key = pack('H*', $hashfunc($key));
			}
			$key       		= str_pad($key, $blocksize, chr(0x00));
			$ipad      		= str_repeat(chr(0x36), $blocksize);
			$opad      		= str_repeat(chr(0x5c), $blocksize);
			$hmac      		= pack('H*', $hashfunc(($key ^ $opad) . pack('H*', $hashfunc(($key ^ $ipad) . $str))));
			$hmac_sha1_str	= $this->Base64($hmac);
		}
		return $hmac_sha1_str;
	}
	public function Base64($str){
		$find = array('+', '/');
		$replace = array('-', '_');
		return str_replace($find, $replace, base64_encode($str));

	}

}
function check_zzs($varnum){
 $string_var = "0123456789";
 $len_string = strlen($varnum);
 if(substr($varnum,0,1)=="0"){
  return false;
 }else{
  for($i=0;$i<$len_string;$i++){
   $checkint = strpos($string_var,substr($varnum,$i,1));
   if($checkint===false){
    return false;
   }
  }
 return true;
 }
}
function tietuku_showPanel(){
	require_once 'tietuku_config.php';
	$accesskey = $tietuku_config['accesskey'];
	$secretkey = $tietuku_config['secretkey'];
	$r_url = $tietuku_config['r_url'];
	$wailian = $tietuku_config['wailian'];
	if(empty($r_url)){
		$r_url=2;
	}
	if($wailian==2){
		$wailian='true';
	}else{
		$wailian='false';
	}
	$album = $tietuku_config['album'];
	echo "<span onclick=\"displayToggle('tietuku_upLoad', 0);\" class=\"show_advset\">贴 图 库</span>";
	if(empty($accesskey)||empty($secretkey)||!check_zzs($album)){
			$accesskey='a73ae6f4fe55ac56125c78a49033af5e17b998b5';
			$secretkey='966f69262732a26e95865490672186823de49f63';
	}else{
		$param['album'] = $album;
		$param['deadline'] = time()+3600;
	}
	$sdk = new tietusdk($accesskey,$secretkey);
	$Token=$sdk->Dealparam($param)->Token();
	$param['from']='web';
    $urltoken=$sdk->Dealparam($param)->Token();
	echo "<script>var token=\"".$Token."\",urltoken=\"".$urltoken."\",r_url=\"".$r_url."\",wailian=\"".$wailian."\",description=\"温馨提示：图片格式支持JPG、JPEG、GIF、PNG、BMP；一次可添加上传300张图片，单张图片不可超过10M。\",finderr=\"对不起，系统出现异常，查找图片失败！\",notabel=\"呃，看来这不是一个有效的图片地址！\",url_in=\"请输入网址：\",findimg=\"查找图片\",up=\"上传图片\",select=\"选择图片\",uploading=\"正在上传\",uploadfailed=\"上传失败\";</script><div id=\"tietuku_upLoad\" style=\"display: none;\"><iframe width=\"860\" height=\"280\" frameborder=\"0\" src=\"".BLOG_URL."content/plugins/tietuku/template/index.html?v=1.1.0\"></iframe></div>";
}
addAction('adm_writelog_head', 'tietuku_showPanel');
