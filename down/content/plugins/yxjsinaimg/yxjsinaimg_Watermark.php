<?php

/**
 * 图片加水印（适用于png/jpg/gif格式）
 * @author flynetcn or Youngxj blog@youngxj.cn
 * @param  [type]  $srcImg   原图片
 * @param  [type]  $waterImg 水印图片
 * @param  [type]  $savepath 保存路径
 * @param  [type]  $savename 保存名字
 * @param  integer $positon  水印位置
 *                           1:顶部居左, 2:顶部居右, 3:居中, 4:底部局左, 5:底部居右, 6:全屏, 7:随机
 * @param  integer $alpha    透明度
 *                           0:完全透明, 100:完全不透明 imagecopy不支持透明度
 * @return [type]            状态
 *                           -1:原文件不存在, -2:水印图片不存在, -3:原文件图像对象建立失败
 *                           -4:水印文件图像对象建立失败 -5:加水印后的新图片保存失败
 */
function img_water_mark($srcImg, $waterImg, $savepath=null, $savename=null, $positon=5, $alpha=30)
{
 $temp = pathinfo($srcImg);
 $name = @$temp[basename];
 $path = @$temp[dirname];
 $exte = @$temp[extension];
 $savename = $savename ? $savename : $name;
 $savepath = $savepath ? $savepath : $path;
 $savefile = $savepath ."/". $savename;
 $srcinfo = @getimagesize($srcImg);
 if (!$srcinfo) {
  return -1;
}
$waterinfo = @getimagesize($waterImg);
if (!$waterinfo) {
  return -2;
}
$srcImgObj = image_create_from_ext($srcImg);
if (!$srcImgObj) {
  return -3;
}
$waterImgObj = image_create_from_ext($waterImg);
if (!$waterImgObj) {
  return -4;
}
switch ($positon) {
 case 1: $x = $y=0; break;
 case 2: $x = $srcinfo[0]-$waterinfo[0]; $y = 0; break;
 case 3: $x = ($srcinfo[0]-$waterinfo[0])/2; $y = ($srcinfo[1]-$waterinfo[1])/2; break;
 case 4: $x = 0; $y = $srcinfo[1]-$waterinfo[1]; break;
 case 5: $x = $srcinfo[0]-$waterinfo[0]; $y = $srcinfo[1]-$waterinfo[1]; break;
 case 6: $x1 = $y1=0;
 $x2 = $srcinfo[0]-$waterinfo[0]; $y2 = 0;
 $x3 = ($srcinfo[0]-$waterinfo[0])/2; $y3 = ($srcinfo[1]-$waterinfo[1])/2;
 $x4 = 0; $y4 = $srcinfo[1]-$waterinfo[1];
 $x5 = $srcinfo[0]-$waterinfo[0]; $y5 = $srcinfo[1]-$waterinfo[1];
 break;
 case 7: $x = rand(0,$srcinfo[0]-$waterinfo[0]); $y = rand(0,$srcinfo[1]-$waterinfo[1]); break;
 default: $x = $y=0;
}
if($positon=='6'){
  imagecopy($srcImgObj, $waterImgObj, $x1, $y1, 0, 0, $waterinfo[0], $waterinfo[1]);
  imagecopy($srcImgObj, $waterImgObj, $x2, $y2, 0, 0, $waterinfo[0], $waterinfo[1]);
  imagecopy($srcImgObj, $waterImgObj, $x3, $y3, 0, 0, $waterinfo[0], $waterinfo[1]);
  imagecopy($srcImgObj, $waterImgObj, $x4, $y4, 0, 0, $waterinfo[0], $waterinfo[1]);
  imagecopy($srcImgObj, $waterImgObj, $x5, $y5, 0, 0, $waterinfo[0], $waterinfo[1]);
}else{
  imagecopy($srcImgObj, $waterImgObj, $x, $y, 0, 0, $waterinfo[0], $waterinfo[1]);
}
//imagecopymerge($srcImgObj, $waterImgObj, $x, $y, 0, 0, $waterinfo[0], $waterinfo[1],$alpha);
switch ($srcinfo[2]) {
 case 1: imagegif($srcImgObj, $savefile); break;
 case 2: imagejpeg($srcImgObj, $savefile); break;
 case 3: imagepng($srcImgObj, $savefile); break;
 default: return -5;
}
imagedestroy($srcImgObj);
imagedestroy($waterImgObj);
return $savefile;
}

function image_create_from_ext($imgfile)
{
 $info = getimagesize($imgfile);
 $im = null;
 switch ($info[2]) {
   case 1: $im=imagecreatefromgif($imgfile); break;
   case 2: $im=imagecreatefromjpeg($imgfile); break;
   case 3: $im=imagecreatefrompng($imgfile); break;
 }
 return $im;
}


/**
 * 文字水印
 * @author Youngxj blog@youngxj.cn
 * @param  [type] $scrImg    源图片
 * @param  [type] $content   文字水印
 *                           支持\r\n换行
 * @param  string $fontSize  文字大小
 * @param  string $fontAngle 文字角度
 * @param  [type] $savepath  保存路径
 * @param  [type] $savename  保存名称
 * @param  string $positon   水印位置
 *                           1:顶部居左, 2:顶部居右, 3:居中, 4:底部局左, 5:底部居右, 6:全屏, 7:随机
 * @param  string $alpha     透明度
 *                           0:完全透明, 100:完全不透明 imagecopy不支持透明度
 * @param  string $font      字体文件
 * @param  string $color1    rgb颜色1
 * @param  string $color2    rgb颜色2
 * @param  string $color3    rgb颜色3
 *                           字体颜色只能用rgb
 * @return [type]            状态
 *                           -1：图片文件不存在，-6：字体文件不存在，-5：图片保存失败
 */
function text_water_mark($scrImg,$content,$fontSize='20',$fontAngle='0',$savepath=null, $savename=null,$positon='5',$alpha='80',$font='STLITI.TTF',$color1='0x00',$color2='0x00',$color3='0x00'){
  $floatWidth = '20';
  $floatHeight = '20';
  $savefile = $savepath.'/'.$savename;
  $dst_path = $scrImg;
  // 计算字体所占宽高
  $fontBox = calculateTextBox($fontSize,$fontAngle,$font,$content);
  // 获取图片宽高类型
  $infoImg = getimagesize($dst_path);
  if(!$infoImg){
    return '-1';
  }
  if(!file_exists($font)){
    return '-6';
  }
  list($dst_w, $dst_h, $dst_type) = $infoImg;

  $dst = imagecreatefromstring(file_get_contents($dst_path));
  $black = imagecolorallocate($dst, $color1, $color2, $color3);


  switch ($positon) {
   case 1: $x = 0+$floatWidth;$y=$fontBox['height']+$floatHeight; break;
   case 2: $x = $dst_w-$fontBox['width']-$floatWidth; $y = $fontBox['height']+$floatHeight; break;
   case 3: $x = ($dst_w-$fontBox['width'])/2; $y = ($dst_h-$fontBox['height'])/2; break;
   case 4: $x = 0+$floatWidth; $y = $dst_h-$fontBox['height']; break;
   case 5: $x = $dst_w-$fontBox['width']-$floatWidth; $y = $dst_h-$fontBox['height']; break;
   case 6: $x1 = 0+$floatWidth;$y1=$fontBox['height']+$floatHeight;
   $x2 = $dst_w-$fontBox['width']-$floatWidth; $y2 = $fontBox['height']+$floatHeight;
   $x3 = ($dst_w-$fontBox['width'])/2; $y3 = ($dst_h-$fontBox['height'])/2;
   $x4 = 0+$floatWidth; $y4 = $dst_h-$fontBox['height'];;
   $x5 = $dst_w-$fontBox['width']-$floatWidth; $y5 = $dst_h-$fontBox['height'];
   break;
   case 7: $x = rand(0,$dst_w-$fontBox['width']-$floatWidth); $y = rand(0,$dst_h-$fontBox['height']-$floatHeight); break;
   default: $x = $y=0;
 }
 if($positon=='6'){
  imagefttext($dst, $fontSize, $fontAngle, $x1, $y1, $black, $font, $content);
  imagefttext($dst, $fontSize, $fontAngle, $x2, $y2, $black, $font, $content);
  imagefttext($dst, $fontSize, $fontAngle, $x3, $y3, $black, $font, $content);
  imagefttext($dst, $fontSize, $fontAngle, $x4, $y4, $black, $font, $content);
  imagefttext($dst, $fontSize, $fontAngle, $x5, $y5, $black, $font, $content);
}else{
  imagefttext($dst, $fontSize, $fontAngle, $x,$y, $black, $font, $content);
}

switch ($dst_type) {
  case 1:
  imagegif($dst,$savefile);break;
  case 2:
  imagejpeg($dst,$savefile);break;
  case 3:
  imagepng($dst,$savefile);break;
  default:return -5;break;
}
imagedestroy($dst);
return $savefile;
}


/**
 * 文字宽高计算(官方算法)
 * @param  [type] $font_size  [description]
 * @param  [type] $font_angle [description]
 * @param  [type] $font_file  [description]
 * @param  [type] $text       [description]
 * @return [type]             [description]
 */
function calculateTextBox($font_size, $font_angle, $font_file, $text) { 
  $box   = imagettfbbox($font_size, $font_angle, $font_file, $text); 
  if( !$box ) 
    return false; 
  $min_x = min( array($box[0], $box[2], $box[4], $box[6]) ); 
  $max_x = max( array($box[0], $box[2], $box[4], $box[6]) ); 
  $min_y = min( array($box[1], $box[3], $box[5], $box[7]) ); 
  $max_y = max( array($box[1], $box[3], $box[5], $box[7]) ); 
  $width  = ( $max_x - $min_x ); 
  $height = ( $max_y - $min_y ); 
  $left   = abs( $min_x ) + $width; 
  $top    = abs( $min_y ) + $height;  
  $img     = @imagecreatetruecolor( $width << 2, $height << 2 ); 
  $white   =  imagecolorallocate( $img, 255, 255, 255 ); 
  $black   =  imagecolorallocate( $img, 0, 0, 0 ); 
  imagefilledrectangle($img, 0, 0, imagesx($img), imagesy($img), $black); 
  imagettftext( $img, $font_size, 
    $font_angle, $left, $top, 
    $white, $font_file, $text); 
  $rleft  = $w4 = $width<<2; 
  $rright = 0; 
  $rbottom   = 0; 
  $rtop = $h4 = $height<<2; 
  for( $x = 0; $x < $w4; $x++ ) 
    for( $y = 0; $y < $h4; $y++ ) 
      if( imagecolorat( $img, $x, $y ) ){ 
        $rleft   = min( $rleft, $x ); 
        $rright  = max( $rright, $x ); 
        $rtop    = min( $rtop, $y ); 
        $rbottom = max( $rbottom, $y ); 
      } 
      imagedestroy( $img ); 
      return array(
        "left"   => $left - $rleft, 
        "top"    => $top  - $rtop, 
        "width"  => $rright - $rleft + 1, 
        "height" => $rbottom - $rtop + 1 ); 
    } 