<?php
if (!isset($generations))
{
	$generations = 2;
}
/*
Maybe put this in a modal? Or put the update/train form in one?
http://getbootstrap.com/javascript/#modals
 */
/*
This is modified from http://forums.phpfreaks.com/topic/64349-solved-why-doesnt-this-pedigree-work/?hl=%20pedigree#entry323948
 */
$inbred = new \stdClass();
$inbred->values = [];
$inbred->ancestors = [];
$inbred->generations = [];
$inbred->takeTwo = [];
function printTree($adopt,$N,$max, $inbred = null, $d, $gender='female')
{
	if (!isset($adopt->name))
	{
		$adopt = new \stdClass;
		$adopt->name = 'Foundation';
		$adopt->sire_id = 0;
		$adopt->aid = null;
	}
	$i = $adopt->aid;
	$inbred->values[] = $i;

	if ($adopt->name != 'Foundation')
	{
		$inbred->generations[$N][] = $adopt->name;
		$inbred->takeTwo[$adopt->name][] = $N;
	}

	$rspan = pow(2, $max-$N);

	$d->addLangVar("\t<td");
	if ($rspan > 1)
	{
		$d->addLangVar(' rowspan="'.$rspan.'"');
	}
	$d->addLangVar(' width="33%">');
	if ($i != 0) {
		$d->addLangVar('<a href="/pet/profile/'.$i.'">' . $adopt->name .'</a>');
		$d->addLangVar(" <span class='inbred$i'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br>");
		$d->addLangVar('<img height="100px" style="padding:15px;" src="'.$adopt->getImage() .'">');
	}else{
		$d->addLangVar('<img src="/picuploads/'.$gender.'nopet.png">');
	}
	$d->addLangVar('</td>');

	// Check for last cell in row
	if ($N == $max) { $d->addLangVar("</tr>");}

	// Parent trees, sire then dam
	if ($N < $max)
	{
		if ($adopt->sire_id == 0)
		{
			printTree(0, $N+1, $max, $inbred, $d,'male');
			printTree(0, $N+1, $max, $inbred, $d);
		}else{
			if (!isset($inbred->ancestors[$adopt->sire_id]))
			{
				$inbred->ancestors[$adopt->sire_id] = $adopt->Sire();
			}
			if (!isset($inbred->ancestors[$adopt->dam_id]))
			{
				$inbred->ancestors[$adopt->dam_id] = $adopt->Dam();
			}
			printTree($inbred->ancestors[$adopt->sire_id], $N+1, $max, $inbred, $d,'male');
			printTree($inbred->ancestors[$adopt->dam_id], $N+1, $max, $inbred, $d);
		}
	}
}

$d->addLangVar('<div class="c-tab"><div class="c-tab__content">
	<table class="pedigree" frame="void" rules="rows" cellpadding="0" cellspacing="0" width="100%">');
if ($adopt->sire_id == 0 OR $adopt->sire_id == NULL)
{
	printTree(0, 0, $generations, $inbred, $d, 'male');
	printTree(0, 0, $generations, $inbred, $d);
}else{
	if (!isset($inbred->ancestors[$adopt->sire_id]))
	{
		$inbred->ancestors[$adopt->sire_id] = $adopt->Sire();
	}
	if (!isset($inbred->ancestors[$adopt->dam_id]))
	{
		$inbred->ancestors[$adopt->dam_id] = $adopt->Dam();
	}
	printTree($inbred->ancestors[$adopt->sire_id], 0, $generations, $inbred, $d, 'male');
	printTree($inbred->ancestors[$adopt->dam_id], 0, $generations, $inbred, $d);
}
$d->addLangVar('</table></div></div>');


$ib = array();
$inbredArray = array_count_values(array_diff($inbred->values,array('')));
$d->addLangVar('<style type="text/css">');
foreach ($inbredArray as $key=>$value)
{
	if ($value < 2) {continue;}
	$r = rand(128,255); 
    $g = rand(128,255); 
    $b = rand(128,255); 
	$ib[$key] = "rgb(".$r.",".$g.",".$b.")";
}
foreach ($ib as $key=>$value)
{
$d->addLangVar(".inbred{$key} {
	background-color: {$value};
	border: 1px solid #000000;}");
}
$d->addLangVar('</style>');