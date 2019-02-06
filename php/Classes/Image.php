*<?php
namespace BHuffman1\ArtLocale;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * Framework for Image class
 *
 * @author William Isengard <wisengard@cnm.edu>
 * @version 1.0.0
 **/
//Note FIXME do we want to have these states as protected or public instead?
class Image implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this image; this is the primary key
	 * @var Uuid $imageId
	 **/
	private $imageId;
	/**
	 * id for this image's gallery; this is a foreign key
	 * @var Uuid $imageGalleryId
	 **/
	private $imageGalleryId;
	/**
	 * id for this image's profile; this is a foreign key
	 * @var Uuid $imageProfileId
	 **/
	private $imageProfileId;
	/**
	 * Date image was created
	 * @var string $imageDate;
	 **/
	private $imageDate;
	/**
	 * Title of image
	 * @var string $imageTitle;
	 **/
	private $imageTitle;
	/**
	 * Url of image
	 * @var string $imageUrl;
	 **/
	private $imageUrl;

//	START OF CONSTRUCTOR
	/**
	 * constructor for each new image object/ instance/ record
	 *
	 * @param Uuid|string $newImageId new id of this image or null if a new image FIXME would it really be null?
	 * @param Uuid|string $newImageGalleryId id of the gallery that has this image
	 * @param Uuid|string $newImageProfileId id of the profile that created this image
	 * @param string $newImageDate date image was activated
	 * @param string $newImageTitle title of image
	 * @param string $newImageUrl image's url
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newImageId, $newImageGalleryId, $newImageProfileId, string $newImageDate, string $newImageTitle, string $newImageUrl) {
		try {
			$this->setImageId($newImageId);
			$this->setImageGalleryId($newImageGalleryId);
			$this->setImageProfileId($newImageProfileId);
			$this->setImageDate($newImageDate);
			$this->setImageTitle($newImageTitle);
			$this->setImageUrl($newImageUrl);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	//	END OF CONSTRUCTOR

//	START OF ACCESSOR & MUTATOR imageId
	/**
	 * accessor method for image id
	 *
	 * @return Uuid value of image id
	 **/
//	FIXME noticed that Will's mutator method for gallery Id targets a string not a Uuid. Which is correct?
	public function getImageId() : Uuid {
		return($this->imageId);
	}
	/**
	 * mutator method for image id
	 *
	 * @param Uuid|string $newImageId new value of image id
	 * @throws \RangeException if $newImageId is not positive
	 * @throws \TypeError if $newImageId is not a uuid or string
	 **/
	public function setImageId( $newImageId) : void {
		try {
			$uuid = self::validateUuid($newImageId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the author id
		$this->imageId = $uuid;
	}
//	END OF ACCESSOR & MUTATOR imageGalleryId

//	START OF ACCESSOR & MUTATOR imageGalleryId
	/**
	 * @return Uuid value of the gallery Id
	 **/
	public function getImageGalleryId() : Uuid {
		return($this->imageGalleryId);
	}
	/**
	 * mutator method for image gallery id
	 *
	 * @param Uuid|string $newImageGalleryId new value of image gallrey id
	 * @throws \RangeException if $newImageGalleryId is not positive
	 * @throws \TypeError if $newImageGalleryId is not a uuid or string
	 **/
//	FIXME noticed that Will's mutator may have an error, the "public function setGalleryProfileId ($newGalleryId)" s.b. "($newGalleryProfileId)
	public function setImageGalleryId( $newImageGalleryId) : void {
		try {
			$uuid = self::validateUuid($newImageGalleryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the author id
		$this->imageGalleryId = $uuid;
	}
//	//	END OF ACCESSOR & MUTATOR imageProfileId

//	START OF ACCESSOR & MUTATOR imageProfileId
	/**
	 * @return Uuid value of the profile Id
	 **/
	public function getImageProfileId() : Uuid {
		return($this->imageProfileId);
	}
	/**
	 * mutator method for image profile id
	 *
	 * @param Uuid|string $newImageProfileId new value of image profile id
	 * @throws \RangeException if $newImageProfileId is not positive
	 * @throws \TypeError if $newImageProfileId is not a uuid or string
	 **/
	public function setImageProfileId( $newImageProfileId) : void {
		try {
			$uuid = self::validateUuid($newImageProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the author id
		$this->imageProfileId = $uuid;
	}
//	//	END OF ACCESSOR & MUTATOR imageProfileId

	/**
	 * accessor method for image date
	 *
	 * @return \DateTime value of image date
	 **/
	public function getImageDate() : \DateTime {
		return($this->imageDate);
	}

	//	START OF ACCESSOR & MUTATOR imageDate
	/**
	 * mutator method for image creation date
	 *
	 * @param \DateTime|string|null $newImageDate image date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newImageDate is not a valid object or string
	 * @throws \RangeException if $newImageDate is a date that does not exist
	 **/
	public function setImageDate($newImageDate = null) : void {
		// base case: if the date is null, use the current date and time
		if($newImageDate === null) {
			$this->imageDate = new \DateTime();
			return;
		}

		// store the like date using the ValidateDate trait
		try {
			$newImageDate = self::validateDateTime($newImageDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->imageDate = $newImageDate;
	}
//	//	END OF ACCESSOR & MUTATOR imageDate