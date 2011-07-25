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
     * Storage account information
     */
    public $blob = null;
    public $table = null;



    /**
     * Constructor
     * Set the root directry to read from for the image gallery
     * 
     * @param String $rootDirPath path to root directory where the images are placed
     * 
     * @return Void
     */
    function __construct($rootDirPath = "myuploads")
    {
        $this->rootDirPath = $rootDirPath;
    }

    /**
     * Set up the image gallery
     * 
     * @param Object $blob Blob object
     * 
     * @return Array
     */
    public function setupGallery($blob)
    {
        if (is_object($blob)) {
            $this->blob = $blob;
        } else {
            throw new Exception("Bad paramater");
        }
             
        if (!$this->blob->containerExists($this->rootDirPath)) {
            $this->blob->createContainer($this->rootDirPath);
        }
         
        $pictures = (array)$this->blob->listBlobs($this->rootDirPath);
        $arrPictures = array();
        foreach ($pictures as $picItem) {
            $arrPictures[] =  $picItem->Url;
        }
        return $arrPictures;
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
        if (!$this->blob->blobExists(
            $this->rootDirPath, 
            $this->targetfile['name']
        )
        ) {
            $result = $this->blob->putBlob(
                $this->rootDirPath, 
                $this->targetfile['name'], 
                $this->targetfile['tmp_name']
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
        if ($this->blob->blobExists($this->rootDirPath, $this->targetfile['name'])) {
            $this->blob->deleteBlob($this->rootDirPath, $this->targetfile['name']);
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
        if (! in_array($this->getFileExt($picture['name']), $this->knownExt)) {
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
