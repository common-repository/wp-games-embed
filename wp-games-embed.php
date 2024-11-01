<?php

/*
Plugin Name: WP Games Embed
Plugin URI: http://www.samburdge.co.uk/plugins/wp-games-embed-plugin/
Description: Embed games in your wordpress site!
Version: 0.1 beta
Author: Sam Burdge
Author URI: http://www.samburdge.co.uk
*/

function game_embed( $atts, $content = null ) {

   extract( shortcode_atts( array(
      'width' => '500',
      'height' => '400',
      'src' => '',
      'main' => '',
      'thumb' => '',
      'title' => '',
      'description' => '',
      'featured' => 'false',
      'game_url' => '',
      'flash' => '',
      ), $atts ) );



if(is_single()){
if($flash){
return '
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="'.$width.'" height="'.$height.'">
<param name="movie" value="'.$src.'">
<param name="quality" value="high">
<embed src="'.$src.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'">
</embed>
</object>
<br /><br /><p>'.$description.'</p>';

} else {
return '<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'" frameborder="0" scrolling="no"></iframe><br /><br /><p>'.$description.'</p>';
}

} else {

if(is_category() || is_tag() || $featured=='true'){
if($featured=='true'){
return '<h3>'.$title.'</h3><br /><div style="float: left; width: 320px;">
<a href="'.$game_url.'" title="'.$title.'"><img src="'.$main.'" alt="'.$title.'" /></a>
</div><div style="float: left; width: 345px;">
<p>'.$description.'</p><p><a href="'.$game_url.'">Play '.$title.' Now &raquo;</a></p>
</div><div style="clear: both;"></div>';
} else {
return '<div style="float: left; width: 320px;"><a href="'.get_permalink().'" title="'.$title.'"><img src="'.$main.'" alt="'.$title.'" /></a>
</div><div style="float: left; width: 345px;">
<p>'.$description.'</p><p><a href="'.get_permalink().'">Play '.$title.' Now &raquo;</a></p>
</div><div style="clear: both;"></div>';
}

} else {
return '<div style="width: 70px; height: 60px; float: left; text-align: center; border: 1px solid #ff00cc; margin: 0 5px 5px 0;"><a href="'.get_permalink().'" title="'.$title.'"><img style="width: 70px; height: 60px;" src="'.$thumb.'" alt="'.$title.'" /></a></div>';
} 

} 

}

add_shortcode('game', 'game_embed');

function latest_games_list($atts, $content = null) {

extract( shortcode_atts( array(
      'list_category' => '1',
      ), $atts ) );


query_posts('posts_per_page=100');

$x=0;
if (have_posts()) : while (have_posts()) : the_post();

if($x<25){
$in_subcategory = false;
foreach( (array) get_term_children( $list_category, 'category' ) as $child_category ) {
if(in_category($child_category))$in_subcategory = true;
}

if ( $in_subcategory || in_category( $list_category ) ) {

$x++;
the_content(__('Read on&hellip;')); 

} 

}

endwhile; else:
 _e('Sorry, no posts matched your criteria.');
endif; 
echo '<div style="clear: both; height: 10px;"></div>';


}


add_shortcode('get_latest_games', 'latest_games_list');



?>