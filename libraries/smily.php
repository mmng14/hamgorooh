<?php
function  replace_smily_with_image($str,$host)
{

    $img_folder_address="resources/plugins/smily/packs/basic/images/";
	$smiles =array(

		':like:' => 'like.png',
		':dislike:' => 'dislike.png',
		':angry:' => 'angry.png',
		':anguished:' => 'anguished.png',
		':cherry_blossom:' => 'cherry_blossom.png',
		':blush:' => 'blush.png',
		':cherry_blossom:' => 'cherry_blossom.png',
		':cold_sweat:' => 'cold_sweat.png',
		':confounded:' => 'confounded.png',
		':confused:' => 'confused.png',
		':cry:' => 'cry.png',
		':disappointed:' => 'disappointed.png',
		':dizzy_face:' => 'dizzy_face.png',
		':fearful:' => 'fearful.png',
		':flushed:' => 'flushed.png',
		':grin:' => 'grin.png',
		':heart_eyes:' => 'heart_eyes.png',
		':hushed:' => 'hushed.png',
		':innocent:' => 'innocent.png',
		':joy:' => 'joy.png',
		':kissing_face:' => 'kissing_face.png',
		':kissing_heart:' => 'kissing_heart.png',
		':monkey_face:' => 'monkey_face.png',
		':neutral_face:' => 'neutral_face.png',
		':pensive:' => 'pensive.png',
		':purple_heart:' => 'purple_heart.png',
		':rage:' => 'rage.png',
		':relaxed:' => 'relaxed.png',
		':relieved:' => 'relieved.png',
		':see_no_evil:' => 'see_no_evil.png',
		':sleeping:' => 'sleeping.png',
		':smile:' => 'smile.png',
		':smiley:' => 'smiley.png',
		':smirk:' => 'smirk.png',
		':speak_no_evil:' => 'speak_no_evil.png',
		':sunglasses:' => 'sunglasses.png',
		':sweat:' => 'sweat.png',
		':sweat_smile:' => 'sweat_smile.png',
		':unamused:' => 'unamused.png',
		':weary:' => 'weary.png',
		':wink:' => 'wink.png',
		':wink2:' => 'wink2.png',
		':worried:' => 'worried.png',
		':yum:' => 'yum.png',
		':kiss:' => 'kiss.png',
	 );

	$str_output=$str;
	foreach($smiles as $key=>$value)
		if (strpos($str_output, $key) !== false)
		{
			$smile_img = "<img src='". $host.$img_folder_address.$value."' style='float:none !important;direction:rtl;width:24px;' alt='". $value ."' />";
			$str_output = str_replace($key,$smile_img,$str_output);
		}
    return $str_output;
}
?>