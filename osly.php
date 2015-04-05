<?php

$in_file = file_get_contents($argv[1]);
$out_file = "";
$dirname = dirname($argv[1]);

$in_lines = explode("\n", $in_file);

$ly_mode = FALSE;
$ly_code = "";
foreach($in_lines as $in_line) {

	if(strpos($in_line, '<div class="comment">&lt;&lt;</div>')) {
		/* ly mode should be enabled */
		$ly_code = "";
		$ly_mode = TRUE;
		echo "--- LY MODE ON ---\n";
		continue;
	}
	if(strpos($in_line, '<div class="comment">&gt;&gt;</div>')) {
		/* ly mode should be disabled */
		$rand = rand(10e16, 10e20);
		if(!file_exists($dirname."/osly")) { mkdir($dirname."/osly"); }
		file_put_contents($dirname."/osly/".$rand.".ly", createLy($ly_code));
		system("lilypond -dbackend=eps -dno-gs-load-fonts -dinclude-eps-fonts --png -o ".$dirname."/osly/".$rand." ".$dirname."/osly/".$rand.".ly");
		system("rm ".$dirname."/osly/".$rand.".ly ".$dirname."/osly/".$rand."-systems* ".$dirname."/osly/".$rand."*.eps");
		//echo $ly_code;
		$out_file .= '<div class="comment"><img border="0" src="./osly/'.$rand.'.png"/>';
		$ly_mode = FALSE;
		echo "--- LY MODE OFF ---\n";
		continue;
	}


	if($ly_mode == TRUE) {
		//echo strip_tags($in_line)."\n";
		$ly_code .= strip_tags($in_line)."\n";
	} else {
		$out_file .= $in_line."\n";
	}
}

file_put_contents($argv[1], $out_file);

function createLy($inLy) {
	$outLy = "\\version \"2.11.49\"
\\paper{
  indent=0\\mm
  line-width=160\\mm
  oddFooterMarkup=##f
  oddHeaderMarkup=##f
  bootTitleMarkup=##f
  scoreTitleMarkup=##f
}
<<
".html_entity_decode($inLy)."
>>";

	return $outLy;
}
