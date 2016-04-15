<?php
class watermark{

		function CreateBlankPNG($w, $h)
			{
				$im = imagecreatetruecolor($w, $h);
				imagesavealpha($im, true);
				$transparent = imagecolorallocatealpha($im, 0, 0, 0, 127);
				imagefill($im, 0, 0, $transparent);
				return $im;
			}
        function create_watermark( $main_img_obj, $watermark_img_obj, $alpha_level = 100 ) {
                $alpha_level        /= 100;

				// imagesavealpha($main_img_obj,true);
				// $transparent = imagecolorallocatealpha($main_img_obj, 0, 0, 0, 127);
				// imagefill($main_img_obj, 0, 0, $transparent);
				
                $main_img_obj_w        = imagesx( $main_img_obj );
				//echo $main_img_obj_w;
                $main_img_obj_h        = imagesy( $main_img_obj );
                $watermark_img_obj_w        = imagesx( $watermark_img_obj );
				
                $watermark_img_obj_h        = imagesy( $watermark_img_obj );

				// справа внизу
				//$main_img_x        = floor( ( $main_img_obj_w - 20 ) - ( $watermark_img_obj_w ) );
				//$main_img_y        = floor( ( $main_img_obj_h  - 20 ) - ( $watermark_img_obj_h) );
				
				//в центре
				$main_img_x        = floor( ( $main_img_obj_w / 2 ) - ( $watermark_img_obj_w / 2 ) );
				$main_img_y        = floor( ( $main_img_obj_h / 2 ) - ( $watermark_img_obj_h / 2 ) );
				 
                $main_img_obj_min_x        = floor( ( $main_img_obj_w / 2 ) - ( $watermark_img_obj_w / 2 ) );
                $main_img_obj_max_x        = ceil( ( $main_img_obj_w / 2 ) + ( $watermark_img_obj_w / 2 ) );
                $main_img_obj_min_y        = floor( ( $main_img_obj_h / 2 ) - ( $watermark_img_obj_h / 2 ) );
                $main_img_obj_max_y        = ceil( ( $main_img_obj_h / 2 ) + ( $watermark_img_obj_h / 2 ) );


                $return_img        = $this->CreateBlankPNG( $main_img_obj_w, $main_img_obj_h );
				//imagesavealpha($return_img,true);
				//$return_img = imagecolorallocatealpha($main_img_obj, 0, 0, 0, 127);
				//imagefill($return_img, 0, 0, $return_img);
				if($main_img_obj_w>$watermark_img_obj_w && $main_img_obj_h>$watermark_img_obj_h){
					imagecopy($main_img_obj, $watermark_img_obj, $main_img_obj_min_x, $main_img_obj_min_y, 0, 0, $watermark_img_obj_w, $watermark_img_obj_h);
				}
				return $main_img_obj;
				 // imageCopy($return_img, $main_img_obj, 0, 0, 0, 0, $main_img_obj_w, $main_img_obj_h ); 
					// imagesavealpha($return_img,true);
				 // $transparent = imagecolorallocatealpha($return_img, 0, 0, 0, 127);
				 // imagefill($return_img, 0, 0, $transparent);
                // for( $y = 0; $y < $main_img_obj_h; $y++ ) {
                        // for( $x = 0; $x < $main_img_obj_w; $x++ ) {
                                // $return_color        = NULL;


                                // $watermark_x        = $x - $main_img_x;
                                // $watermark_y        = $y - $main_img_y;


                                // $main_rgb = imagecolorsforindex( $main_img_obj, imagecolorat( $main_img_obj, $x, $y ) );


                                // if (        $watermark_x >= 0 && $watermark_x < $watermark_img_obj_w &&
                                                        // $watermark_y >= 0 && $watermark_y < $watermark_img_obj_h ) {
                                        // $watermark_rbg = imagecolorsforindex( $watermark_img_obj, imagecolorat( $watermark_img_obj, $watermark_x, $watermark_y ) );


                                        // $watermark_alpha        = round( ( ( 127 - $watermark_rbg['alpha'] ) / 127 ), 2 );
                                        // $watermark_alpha        = $watermark_alpha * $alpha_level;


                                        // $avg_red                = $this->_get_ave_color( $main_rgb['red'],                $watermark_rbg['red'],                $watermark_alpha );
                                        // $avg_green        = $this->_get_ave_color( $main_rgb['green'],        $watermark_rbg['green'],        $watermark_alpha );
                                        // $avg_blue                = $this->_get_ave_color( $main_rgb['blue'],        $watermark_rbg['blue'],                $watermark_alpha );


                                        // $return_color        = $this->_get_image_color( $return_img, $avg_red, $avg_green, $avg_blue );
										// imagesetpixel( $return_img, $x, $y, $return_color );

                                // } else {
										// $main_rgb = imagecolorsforindex( $main_img_obj, imagecolorat( $main_img_obj, $x, $y ) );
										 // $avg_red                = $this->_get_ave_color( $main_rgb['red'],                $main_rgb['red'],                0 );
                                        // $avg_green        = $this->_get_ave_color( $main_rgb['green'],        $main_rgb['green'],        0 );
                                        // $avg_blue                = $this->_get_ave_color( $main_rgb['blue'],        $main_rgb['blue'],                0 );
										// $return_color        =$this->_get_image_color( $return_img, $avg_red, $avg_green, $avg_blue );
                                        //$return_color        = imagecolorat( $main_img_obj, $x, $y );
	
                                // }


                                //imagesetpixel( $return_img, $x, $y, $return_color );

                        // }
               // }


               // return $return_img;

        }


        function _get_ave_color( $color_a, $color_b, $alpha_level ) {
                return round( ( ( $color_a * ( 1 - $alpha_level ) ) + ( $color_b        * $alpha_level ) ) );
        }


        function _get_image_color($im, $r, $g, $b) {
                $c=imagecolorexact($im, $r, $g, $b);
                if ($c!=-1) return $c;
                $c=imagecolorallocate($im, $r, $g, $b);
                if ($c!=-1) return $c;
                return imagecolorclosest($im, $r, $g, $b);
        }

} 
?>