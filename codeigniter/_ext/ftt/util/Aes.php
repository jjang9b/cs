<?php
class Aes
{
  public static function createIV($source = MCRYPT_RAND, $cipher = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_CBC)
  {
    srand();
    $iv_size = mcrypt_get_iv_size($cipher, $mode);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    return $iv;
  }

  public static function encrypt ($key, $iv, $value, $cipher = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_CBC)
  {
    if ( is_null ($value) )
      $value = '';

    $value = self::toPkcs7 ($value, strlen($iv));

    $output = mcrypt_encrypt ($cipher, $key, $value, $mode, $iv);

    return base64_encode ($output);
  }

  public static function decrypt ($key, $iv, $value, $cipher = MCRYPT_RIJNDAEL_256, $mode = MCRYPT_MODE_CBC)
  {
    if ( is_null ($value) )
      $value = "" ;

    $value = base64_decode ($value);

    $output = mcrypt_decrypt ($cipher, $key, $value, $mode, $iv);

    return self::fromPkcs7 ($output, strlen($iv));
  }

  public static function hex2bin($hexdata)
  {
    $bindata='';
    $dataSize = strlen($hexdata);
    for ($i=0;$i<$dataSize;$i+=2)
      $bindata.=chr(hexdec(substr($hexdata,$i,2)));

    return $bindata;
  }

  public static function toPkcs7($value, $ivsize)
  {
    if ( is_null ($value) )
      $value = '';

    $padSize = $ivsize - (strlen ($value) % $ivsize);

    return $value . str_repeat (chr ($padSize), $padSize);
  }

  public static function fromPkcs7($value, $ivsize)
  {
    $valueLen = strlen ($value);

    if ( $valueLen % $ivsize > 0 )
      $value = '';

    $padSize = ord ($value{$valueLen - 1});

    if ( ($padSize < 1) or ($padSize > $ivsize) )
      $value = '';

    for ($i = 0; $i < $padSize; $i++)
    {
      if ( ord ($value{$valueLen - $i - 1}) != $padSize )
        $value = '';
    }

    return substr ($value, 0, $valueLen - $padSize);
  }
}
