<?php

class Fingerprint {

  public static function generate($sHashKey, $sData)
  {
    $nTimestamp = time();
    $sHash = self::hash($sHashKey, $sData, $nTimestamp);
    return sprintf("%s%x", $sHash, $nTimestamp);
  }

  public static function verify($sFingerprint, $sHashKey, $sData, $nAllowSeconds=30)
  {
    $sHash = substr($sFingerprint, 0, 32);
    $nTimestamp = hexdec(substr($sFingerprint, 32));

    if ($sHash == '') return false;
    if ($nTimestamp <= 0) return false;
    if (abs(time() - $nTimestamp) > $nAllowSeconds) return false;
    if (self::hash($sHashKey, $sData, $nTimestamp) != $sHash) return false;
      
    return true;
  }

  private static function hash($sHashKey, $sData, $nTimestamp)
  {
    $sHash = hash('sha256', "{$sHashKey}{$sData}{$nTimestamp}");
    return substr($sHash, 4, 32);
  }
}
