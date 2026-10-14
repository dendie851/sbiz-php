<?php 
/*******************************************************************************                                                      
* Lib:      Stuff Photo Class                                                  
* Version:  1.0.1 	                                                           
* Date:     27-09-2026                                                         
* Author:   Dendie                                                             
* License:  Freeware                                                           
*		       				      						   
* This class for handling photo of stuff module					   	   
*		       				      						   
* You can  use, modification and distribution 								   	                                                                  
*******************************************************************************/

if (!class_exists('photo')) {
	class photo 
	{		
		/* max photo per stuff */
		const MAX_PHOTO = 5;

		/* max size per photo in byte (500 KB) */
		const MAX_SIZE = 512000;

		/* max width/height of thumbnail in pixel */
		const THUMBNAIL_SIZE = 150;

		/* allowed image extension */
		public static $allowedExtension = array('jpg', 'jpeg', 'png');

		/* allowed image mime type */
		public static $allowedMime = array('image/jpeg', 'image/png');

		/**
		 * relative path of photo folder (from application root)
		 */
		public static function getPhotoPath() {
			return 'stuff/photo';
		}

		/**
		 * relative path of thumbnail folder (from application root)
		 */
		public static function getThumbnailPath($pStuffId) {
			return self::getPhotoPath().'/photo_'.$pStuffId.'/thumbnail';
		}

		/**
		 * path of photo folder in server (absolute)
		 */
		public static function getPhotoDir($pStuffId) {
			return dirname(__FILE__).'/photo/photo_'.$pStuffId;
		}

		/**
		 * path of thumbnail folder in server (absolute)
		 */
		public static function getThumbnailDir($pStuffId) {
			return self::getPhotoDir($pStuffId).'/thumbnail';
		}

		/**
		 * relative path of a photo file (to be saved on database)
		 */
		public static function getPhotoFile($pStuffId, $pStuffPhotoId, $pExtension) {
			return self::getPhotoPath().'/photo_'.$pStuffId.'/photo_'.$pStuffId.'_'.$pStuffPhotoId.'.'.$pExtension;
		}

		/**
		 * relative path of a thumbnail file (to be saved on database)
		 */
		public static function getThumbnailFile($pStuffId, $pStuffPhotoId, $pExtension) {
			return self::getThumbnailPath($pStuffId).'/photo_'.$pStuffId.'_'.$pStuffPhotoId.'.'.$pExtension;
		}

		/**
		 * create folder of photo and thumbnail, return true if folder ready
		 */
		public static function createDir($pStuffId) {
			$status = true;
			$photoDir = self::getPhotoDir($pStuffId);
			$thumbnailDir = self::getThumbnailDir($pStuffId);

			if(!is_dir($photoDir)) {
				if(!mkdir($photoDir, 0777, true)) {
					$status = false;
				}
			}

			if($status == true) {
				if(!is_dir($thumbnailDir)) {
					if(!mkdir($thumbnailDir, 0777, true)) {
						$status = false;
					}
				}
			}

			return $status;
		}

		/**
		 * remove folder of photo and thumbnail of a stuff
		 */
		public static function removeDir($pStuffId) {
			$photoDir = self::getPhotoDir($pStuffId);
			$thumbnailDir = self::getThumbnailDir($pStuffId);

			self::removeFolderContent($thumbnailDir);
			self::removeFolderContent($photoDir);

			if(is_dir($thumbnailDir)) {
				@rmdir($thumbnailDir);
			}

			if(is_dir($photoDir)) {
				@rmdir($photoDir);
			}

			return true;
		}

		/**
		 * remove all file inside a folder (not the folder itself)
		 */
		public static function removeFolderContent($pDir) {
			if(!is_dir($pDir)) {
				return false;
			}

			$listFile = glob($pDir.'/*');

			if(is_array($listFile)) {
				foreach($listFile as $valFile) {
					if(is_file($valFile)) {
						@unlink($valFile);
					}
				}
			}

			return true;
		}

		/**
		 * get extension of file name, return lower case extension
		 */
		public static function getExtension($pFileName) {
			return strtolower(pathinfo($pFileName, PATHINFO_EXTENSION));
		}

		/**
		 * validation of uploaded file, return error message or empty string
		 */
		public static function validateFile($pTmpName, $pFileName, $pFileSize) {
			if(strlen(trim($pFileName)) < 1) {
				return 'Silakan memilih foto yang akan diunggah';
			}

			$extension = self::getExtension($pFileName);

			if(!in_array($extension, self::$allowedExtension)) {
				return 'Format foto tidak diperbolehkan, hanya diperbolehkan JPG, JPEG atau PNG';
			}

			if($pFileSize > self::MAX_SIZE) {
				return 'Ukuran foto '.$pFileName.' melebihi batas maksimal 200 KB';
			}

			if($pFileSize < 1) {
				return 'Foto '.$pFileName.' tidak terbaca, silakan ulangi memilih foto';
			}

			$info = @getimagesize($pTmpName);

			if($info == false) {
				return 'File '.$pFileName.' bukan merupakan file foto yang sah';
			}

			if(!in_array($info['mime'], self::$allowedMime)) {
				return 'Jenis foto '.$pFileName.' tidak diperbolehkan, hanya diperbolehkan JPG, JPEG atau PNG';
			}

			return '';
		}

		/**
		 * count photo of stuff that still not deleted
		 */
		public static function countPhoto($pCon, $pStuffId) {
			$query = "select count(id) as jml 
				from stuff_photo
				where stuff_id = '$pStuffId'
				  and is_delete = '0'";
			$tmp = mysqli_query($pCon, $query) or die (mysqli_error($pCon));
			$data = mysqli_fetch_array($tmp);

			return $data['jml'];
		}

		/**
		 * validation of photo amount, return error message or empty string
		 */
		public static function validateAmount($pCon, $pStuffId, $pAmountUploaded) {
			$amountExist = self::countPhoto($pCon, $pStuffId);

			if(($amountExist + $pAmountUploaded) > self::MAX_PHOTO) {
				return 'Maksimal foto yang dapat disimpan adalah '.self::MAX_PHOTO.' foto, saat ini sudah terdapat '.$amountExist.' foto';
			}

			return '';
		}

		/**
		 * save original photo and its thumbnail, return true if success
		 */
		public static function savePhoto($pTmpName, $pStuffId, $pStuffPhotoId, $pExtension) {
			if(!self::createDir($pStuffId)) {
				return false;
			}

			$photoFile = self::getPhotoDir($pStuffId).'/photo_'.$pStuffId.'_'.$pStuffPhotoId.'.'.$pExtension;
			$thumbnailFile = self::getThumbnailDir($pStuffId).'/photo_'.$pStuffId.'_'.$pStuffPhotoId.'.'.$pExtension;

			if(!move_uploaded_file($pTmpName, $photoFile)) {
				return false;
			}

			if(!self::createThumbnail($photoFile, $thumbnailFile, $pExtension)) {
				return false;
			}

			return true;
		}

		/**
		 * create thumbnail of a photo, return true if success
		 */
		public static function createThumbnail($pSourceFile, $pDestinationFile, $pExtension) {
			$info = @getimagesize($pSourceFile);

			if($info == false) {
				return false;
			}

			$widthSource = $info[0];
			$heightSource = $info[1];

			if($widthSource < 1 || $heightSource < 1) {
				return false;
			}

			if($widthSource >= $heightSource) {
				$widthThumbnail = self::THUMBNAIL_SIZE;
				$heightThumbnail = (int) round(($heightSource / $widthSource) * self::THUMBNAIL_SIZE);
			} else {
				$heightThumbnail = self::THUMBNAIL_SIZE;
				$widthThumbnail = (int) round(($widthSource / $heightSource) * self::THUMBNAIL_SIZE);
			}

			if($widthThumbnail < 1) {
				$widthThumbnail = 1;
			}

			if($heightThumbnail < 1) {
				$heightThumbnail = 1;
			}

			$imageSource = self::createImageFromFile($pSourceFile, $pExtension);

			if($imageSource == false) {
				return false;
			}

			$imageThumbnail = imagecreatetruecolor($widthThumbnail, $heightThumbnail);

			if($pExtension == 'png') {
				imagealphablending($imageThumbnail, false);
				imagesavealpha($imageThumbnail, true);
				$transparent = imagecolorallocatealpha($imageThumbnail, 255, 255, 255, 127);
				imagefilledrectangle($imageThumbnail, 0, 0, $widthThumbnail, $heightThumbnail, $transparent);
			}

			imagecopyresampled($imageThumbnail, $imageSource, 0, 0, 0, 0, $widthThumbnail, $heightThumbnail, $widthSource, $heightSource);

			if($pExtension == 'png') {
				$status = @imagepng($imageThumbnail, $pDestinationFile, 9);
			} else {
				$status = @imagejpeg($imageThumbnail, $pDestinationFile, 90);
			}

			imagedestroy($imageSource);
			imagedestroy($imageThumbnail);

			return $status;
		}

		/**
		 * create image resource from file based on extension
		 */
		public static function createImageFromFile($pFile, $pExtension) {
			if($pExtension == 'png') {
				return @imagecreatefrompng($pFile);
			}

			return @imagecreatefromjpeg($pFile);
		}

		/**
		 * delete original photo and its thumbnail file from server
		 */
		public static function deletePhotoFile($pPhoto, $pPhotoThumbnail) {
			$rootDir = dirname(__FILE__).'/../';

			if(strlen(trim($pPhoto)) > 0) {
				$photoFile = $rootDir.$pPhoto;

				if(is_file($photoFile)) {
					@unlink($photoFile);
				}
			}

			if(strlen(trim($pPhotoThumbnail)) > 0) {
				$thumbnailFile = $rootDir.$pPhotoThumbnail;

				if(is_file($thumbnailFile)) {
					@unlink($thumbnailFile);
				}
			}

			return true;
		}
	}
}

?>