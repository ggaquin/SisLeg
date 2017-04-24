<?php

namespace AppBundle\Popo;
use AppBundle\Popo\ImageConfig;


class Image{

	/**
	 * @var string
	 */
	private $fileName;
	 /**
	  *@var \AppBundle\Popo\ImageConfig
	  */
	private $imageConfig;

	/**
     * Constructor
     */
    public function __construct($fileName,$caption,$size,$width,$key,$type)
    {
        $this->fileName=$fileName;
        $this->imageConfig=new ImageConfig($caption,$size,$width,$key,$type);
    }

	/**
	 * Get imageConfig
	 * @return \AppBundle\Popo\ImageConfig
	 */
	public function getImageConfig(){
		return $this->imageConfig;
	}

	/**
	 * Set imageConfig
	 * @param \AppBundle\Popo\ImageConfig $imageConfig
	 * @return Image
	 */
	public function setImageConfig($imageConfig){
		$this->imageConfig=$imageConfig;
		return $this;
	}
	
	/**
	 * Get fileName
	 * @return string
	 */
	public function getFileName(){
		return $this->fileName;
	}

	/**
	 * Set fileName
	 * @param string $fileName
	 * @return Image
	 */
	public function setFileName($fileName){
		$this->fileName=$fileName;
		return $this;
	}

}