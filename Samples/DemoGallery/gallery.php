<?php
/**
 * DemoGallery.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   DemoGallery
 * @author    Sourabh Kulkarni <v-sokulk@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD Licence
 * @version   SVN: 1.0
 * @link      https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer
 */

/**
 * DemoGallery.
 *
 * Core Gallery Class.
 *
 * @category  PHP
 * @package   DemoGallery
 * @author    Sourabh Kulkarni <v-sokulk@microsoft.com>
 * @copyright 2011 Copyright © Microsoft Corporation. All Rights Reserved
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD Licence
 * @version   Release: 1.0.0
 * @link      https://github.com/Interop-Bridges/Cloud-Rules-for-PHP_CodeSniffer
 */

class DemoGallery
{

    /**
     *
     * Stores default gallery path.
     * @var String
     */
    protected $rootDirPath = null;
    
    /**
     *
     * Stores default gallery path.
     * @var array
     */
    protected $knownExt = array("jpg", "jpeg", "gif", "png");

    protected $imagesGallery = array();

    /**
     *
     * overrite the picture or not?
     * @var boolean
     */
    private $_overritePic = false;

    /**
     * Constructor
     * Set the root directry to read from for the image gallery
     * 
     * @param String $rootDirPath path to root directory where the images are placed
     * 
     * @return Void
     */
    function __construct($rootDirPath = ".")
    {
        $this->rootDirPath = $rootDirPath;
    }


    /**
     * detects all the known images in the root directory and records the
     * in $imagesGallery array.
     *
     * @return Array
     */
    public function setupGallery()
    {
        try
        {
            $folder = opendir($this->rootDirPath); // open the set root directory
            while ($file = readdir($folder)) {
                if (in_array($this->getFileExt($file), $this->knownExt)) {
                    array_push($this->imagesGallery, $file);
                }
            }
            closedir($folder);//release resource
            return $this->imagesGallery;
        }
        catch(Exception $e)
        {
            echo $e->getMessage();
        }
    }
    
    /**
     * detects extension of the file
     * 
     * @param String $file filename
     *
     * @return String
     */
    public function getFileExt($file)
    {
        $parts = explode(".", $file);
        $ext = strtolower($parts[count($parts) - 1]);
        return $ext;
    }
    
    /**
     * uploads file to current directory
     * 
     * @param File $targetFile target file
     *
     * @return String
     */
    public function upload($targetFile)
    {
        $this->targetfile = $targetFile;
        $this->fileLocation 
            = $this->rootDirPath .DIRECTORY_SEPARATOR. $this->targetfile['name'];

        if (!file_exists($this->fileLocation)) {
            $result = move_uploaded_file(
                $this->targetfile['tmp_name'], 
                $this->fileLocation
            );
            if ($result) {
                return 'Picture was successfully uploaded to the Gallery';
            } else {
                return 'Picture could not be uploaded'.print_r($_FILES, 1);
            }
        } else {
            return 'File by this name already exists';
        }
    }
    
    /**
     * overrides existing file
     * 
     * @param File $targetFile target file
     *
     * @return String
     */
    public function overwrite($targetFile)
    {
        $this->targetfile = $targetFile;
        $this->fileLocation 
            = $this->rootDirPath .DIRECTORY_SEPARATOR. $this->targetfile['name'];

        if (file_exists($this->fileLocation)) {
            unlink($this->fileLocation);
        }
        return $this->upload($this->targetfile);
    }
   
    /**
     * Add the picture to gallery
     * 
     * @param File $picture picture to add
     *
     * @return String
     */
    function addToGallery($picture)
    {
        if (!in_array($this->getFileExt($picture['name']), $this->knownExt)) {
            return "File not supported";
        }
        if ($this->getOverritePic() == false) {
            return $this->upload($picture);
        } else {
             return $this->overwrite($picture);
        }
    }
  
    /**
     *  Get Overwrite Flag value
     *  
     *  @return overwrite flag
     */
    function getOverritePic()
    {
        return $this->_overritePic;
    }
    
    /**
     *  Set Overwrite Flag value
     *  
     *  @param Int $value overwrite flag value
     *  
     *  @return Void
     */
    function setOverritePic($value)
    {
        $this->_overritePic = $value;
    }
}
?>
