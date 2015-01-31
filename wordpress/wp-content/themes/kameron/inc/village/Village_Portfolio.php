<?php 
class Village_Portfolio {
	public static function get_image_url( $image_id, $size ) {
		$image = wp_get_attachment_image_src( $image_id, $size );
		$image_url = $image[0];

		return $image_url;
	}

	public static function get_images() {
		$enable_thumbnails = Village::is_enabled("portfolio_gallery_enable_thumbnails", true);
		$images = Village::get_post_meta( "images", $default = false, $single = false );

		if ( ! $images ) {
			return array();
		}

		$out = array();

		foreach ( $images as $key => $image_id ) {

			$out[$key]["img"] = self::get_image_url( $image_id, 'full' );

			if( $enable_thumbnails ) {
				$out[$key]["thumb"] = self::get_image_url( $image_id, 'portfolio_mini_thumbnail' );
			}
		}

		return $out;
	}

	public static function get_videos() {
		$out = array();

		$videos = Village::get_post_meta( "videos", $default = false, $single = true );
		$video_image_ids = Village::get_post_meta("video_thumbnails",  $default = false, $single = false );

		if ( ! $videos ) {
			return array();
		} else {
			# Explode Videos
			$videos = (array) explode("\n", $videos);
		}

		if ( !empty( $video_image_ids ) ) {
			foreach ( $video_image_ids as $image_id ) {
				$video_images[] = array(
					"thumb" => self::get_image_url( $image_id, 'portfolio_mini_thumbnail' ),
					"img" => self::get_image_url( $image_id, 'full' )
				);
			}
		}

		//-----------------------------------*/
		// Fetch Video
		//-----------------------------------*/
		foreach ($videos as $key => $video_url) {
			$video = array();
			$video['video'] = esc_url_raw( $video_url );

			if ( !empty( $video_images[ $key ] ) ) {
				$out[] = (array) $video + (array) $video_images[ $key ];
			} else {
				$out[] = $video;
			}
		}
		return $out;
	}


	public static function get_media() {
		return array_merge( (array) self::get_images(), (array) self::get_videos() );	
	}
}