<?php

namespace AppBundle\Popo;

class ImageConfig{
	
	/**
	 * @var string
	 */
	private $caption;
	/**
	 * @var integer
	 */
	private $size;
	/**
	 * @var string
	 */
	private $width;
	/**
	 * @var string
	 */
	private $key;
	/**
	* @var string
	*/
	private $type;

	/**
     * Constructor
     */
    public function __construct($caption,$size,$width,$key,$type)
    {
        $this->caption=$caption;
        $this->size=$size;
        $this->width=$width;
        $this->key=$key;
        $this->type=$type;
    }

	/**
	 * Get caption
	 * @return string
	 */
	public function getCaption(){
		return $this->caption;
	}

	/**
	 * Set caption
	 * @param string $caption
	 * @return ImageConfig
	 */
	public function setCaption($caption){
		$this->caption=$caption;
		return $this;
	}

	/**
	 * Get size
	 * @return integer
	 */
	public function getSize(){
		return $this->size;
	}

	/**
	 * Set size
	 * @param integer $size
	 * @return ImageConfig
	 */
	public function setSize($size){
		$this->size=$size;
		return $this;
	}

	/**
	 * Get width
	 * @return string
	 */
	public function getWidth(){
		return $this->width;
	}

	/**
	 * Set width
	 * @param string $width
	 * @return ImageConfig
	 */
	public function setWidth($width){
		$this->width=$width;
		return $this;
	}

	/**
	 * Get key
	 * @return string
	 */
	public function getKey(){
		return $this->key;
	}

	/**
	 * Set key
	 * @param string $key
	 * @return ImageConfig
	 */
	public function setKey($key){
		$this->key=$key;
		return $this;
	}

	/**
	 * Get type
	 * @return string
	 */
	public function getType(){
		return $this->type;
	}

	/**
	 * Set type
	 * @param string $type
	 * @return ImageConfig
	 */
	public function setType($type){
		$this->type=$type;
		return $this;
	}

}