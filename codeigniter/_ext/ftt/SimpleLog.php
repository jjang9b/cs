<?php
class SimpleLog
{
  private $sFileName;

  public function setFile($sFileName)
  {
    $this->sFileName = $sFileName;
  }

  public function save($mData, $sSeparator='|', $bDateTime=true, $bAddNewLine=false)
  {
    if (empty($this->sFileName))
      return 0;

    if (is_array($mData))
      $sLog = implode($sSeparator, $mData).($bAddNewLine ? "\n" : '');
    else if (is_object($mData))
      $sLog = implode($sSeparator, get_object_vars($mData)).($bAddNewLine ? "\n" : '');
    else
      $sLog = $mData;

    if ($bDateTime)
      $sLog = date("Y-m-d H:i:s").' '.$sLog;

    $CI =& get_instance();
    $CI->load->library('ftt/io/DirectoryUtil');
    $CI->load->library('ftt/io/FileUtil');
    $CI->fileutil->setFile($this->sFileName);

    return $CI->fileutil->write($sLog, FILE_APPEND | LOCK_EX, 0002, $CI->directoryutil);
  }

}
