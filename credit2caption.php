<?php
/*
Plugin Name: Credit2Caption
Plugin URI: http://marbu.org/marbu/credit2caption/
Description: Add IPTC image credit to the caption during upload.
Version: 1.2
Author: Marco Buttarini
Author URI: http://marbu.org
Min WP Version: 3.0
License: GPL version 2 - http://www.opensource.org/licenses/gpl-license.php
*/

add_filter('attachment_fields_to_edit', 'lp_metadata',11,2);

function lp_metadata($fields, $post){
 
  if($post->post_type == "attachment"){
    $image_path = $post->guid;



    $size = getimagesize ( $image_path, $info);
    if(is_array($info)) {
        $iptc = iptcparse($info["APP13"]);
        foreach (array_keys($iptc) as $s) {
            $c = count ($iptc[$s]);
            for ($i=0; $i <$c; $i++)
            {
	      if($s == "2#110"){
		//echo $s.' = '.$iptc[$s][$i].'<br>';
		$fields['post_excerpt']['value'] = $iptc[$s][$i];		
	      }
            }
        }
    }


  }
    
  return $fields;

}

?>
