<?php
class FileUtil
{
  private $sFileName;

  public function __construct()
  {
    $this->sFileName = '';
  }

  public function setFile($sFileName)
  {
    $this->sFileName = trim($sFileName);
  }

  public function exist()
  {
    return file_exists($this->sFileName);
  }

  public function size()
  {
    return filesize($this->sFileName);
  }

  public function chmod($nMode=0755)
  {
    return @chmod($sFilePath, $nMode);
  }

  public function delete()
  {
    if (unlink($this->sFileName) === false)
      return false;

    return true;
  }

  public function write($mixData, $nFlag=0, $nUmask=0002, $oDirUtil=NULL)
  {
    if (isset($oDirUtil))
    {
      $oDirUtil->setPath(dirname($this->sFileName));
      if (!$oDirUtil->exist())
        $oDirUtil->make(0777, 0000);
    }

    $nOldUmask = umask($nUmask);
    $nBytes = file_put_contents($this->sFileName, $mixData, $nFlag);
    umask($nOldUmask);

    return $nBytes;
  }

  public function read($nOffset, $nSize)
  {
    return file_get_contents($this->strFile, false, NULL, $nOffset, $nSize);
  }

  public function readAll()
  {
    return file_get_contents($this->sFileName);
  }

  public function readArray()
  {
    return file($this->sFileName);
  }


  public function make($nMode=0777, $nUmask=0000)
  {
    if (empty($this->sDirPath))
      return false;

    if (substr($this->sDirPath, 0, 1) != DIRECTORY_SEPARATOR) // only absolute path
      return false;

    $aSplitPath = explode(DIRECTORY_SEPARATOR, trim($this->sDirPath, DIRECTORY_SEPARATOR));
    $nSize = count($aSplitPath);

    $aPathAll = array();
    $sTmpPath = '';
    for ($i = 0; $i < $nSize; $i++)
    {
      $sTmpPath .= DIRECTORY_SEPARATOR.$aSplitPath[$i];
      $aPathAll[$i] = $sTmpPath;
    }

    $sCurPath = '';
    $nExistPos = $nSize - 1;
    for (; $nExistPos >= 0; $nExistPos--)
    {
      if (file_exists($aPathAll[$nExistPos]))
      {
        $sCurPath = $aPathAll[$nExistPos];
        break;
      }
    }

    $nOldUmask = umask($nUmask);
    for ($i = $nExistPos+1; $i < $nSize; $i++)
    {
      $sCurPath .= DIRECTORY_SEPARATOR.$aSplitPath[$i];

      if (!mkdir($sCurPath, $nMode))
      {
        umask($nOldUmask);
        return false;
      }
    }

    umask($nOldUmask);
    return true;
  }
}
