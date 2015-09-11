<?php
class DirectoryUtil
{
  private $sDirPath;

  public function __construct()
  {
    $this->sDirPath = '';
  }

  public function setPath($sDirPath)
  {
    $this->sDirPath = trim($sDirPath);
  }

  public function exist()
  {
    return is_dir($this->sDirPath);
  }

  public function getRealPath()
  {
    return realpath($this->sDirPath);
  }

  public function delete($bForce=false)
  {
    if (empty($this->sDirPath))
      return false;

    $aPath = explode(DIRECTORY_SEPARATOR, $this->sDirPath);
    if (count($arrPath) < 3) // defence code
      return false;

    if ($bForce)
    {
      exec('rm -rf '.$this->sDirPath);
      $bResult = true;
    }
    else
    {
      $bResult = rmdir($this->sDirPath);
    }

    return $bResult;
  }

  public function rename($sNewName)
  {
    return rename($this->sDirPath, $sNewName);
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
