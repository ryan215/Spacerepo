<?php

function image_thumb( $image_path, $height, $width ) {
    // Get the CodeIgniter super object
    $CI =& get_instance();
	$extenstion=	pathinfo( $image_path,PATHINFO_EXTENSION);
	$file_name=		pathinfo( $image_path,PATHINFO_FILENAME );
		//echo $file_name;
		//exit;
    // Path to image thumbnail
    $image_thumb = dirname( $image_path ) . '/thumb50/'.$file_name.$height.'_'.$width.'.'.$extenstion;

    if ( !file_exists( $image_thumb ) ) {
        // LOAD LIBRARY
        $CI->load->library( 'image_lib' );

        // CONFIGURE IMAGE LIBRARY
        $config['image_library']    = 'gd2';
        $config['source_image']     = $image_path;
        $config['new_image']        = $image_thumb;
        $config['maintain_ratio']   = TRUE;
        $config['height']           = $height;
        $config['width']            = $width;
        $CI->image_lib->initialize( $config );
        $CI->image_lib->resize();
        $CI->image_lib->clear();
    }

    return '<img src="' . dirname( $_SERVER['SCRIPT_NAME'] ) . '/' . $image_thumb . '" />';
}
