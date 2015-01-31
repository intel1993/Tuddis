<?php 
if ( !function_exists('aq_resize')) {
	/*-----------------------------------------------------------------------------------*/
	/* Aqua Resizer
	/*-----------------------------------------------------------------------------------*/

	function aq_resize($url, $width, $height = null, $crop = null, $single = true) {
		//validate inputs
		if(!$url OR !$width ) return false;
		
		//define upload path & dir
		$upload_info = wp_upload_dir();
		$upload_dir = $upload_info['basedir'];
		$upload_url = $upload_info['baseurl'];
		
		//check if $url is local
		if(strpos( $url, $upload_url ) === false) return false;
		
		//define path of image
		$rel_path = str_replace( $upload_url, '', $url);
		$img_path = $upload_dir . $rel_path;
		
		//check if img path exists, and is an image indeed
		if( !file_exists($img_path) OR !getimagesize($img_path) ) return false;
		
		//get image info
		$info = pathinfo($img_path);
		$ext = $info['extension'];
		list($orig_w,$orig_h) = getimagesize($img_path);
		
		//get image size after cropping
		$dims = image_resize_dimensions($orig_w, $orig_h, $width, $height, $crop);
		$dst_w = $dims[4];
		$dst_h = $dims[5];
		
		//use this to check if cropped image already exists, so we can return that instead
		$suffix = "{$dst_w}x{$dst_h}";
		$dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
		$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";
		
		//can't resize, so return original url
		if(!$dst_h) {
				$img_url = $url;
				$dst_w = $orig_w;
				$dst_h = $orig_h;
		}
		//else check if cache exists
		elseif(file_exists($destfilename) && getimagesize($destfilename)) {
			$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
		} 
		//else, we resize the image and return the new resized image url
		else {
			$resized_img_path = image_resize( $img_path, $width, $height, $crop );
			if(!is_wp_error($resized_img_path)) {
				$resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
				$img_url = $upload_url . $resized_rel_path;
			} else {
				return false;
			}
		}
		
		//return the output
		if(!$single) {
			//array return
			$image = array (
				'url' => $img_url,
				'width' => $dst_w,
				'height' => $dst_h
			);
			
		} else {
			//url return
			$image = $img_url;
		}
		
		return $image;
	}
}