<?php

$p = new project();
$b = new bug();

$p->getByCol( "project_name", $argv[1] ); // this is goddamn awesome
$row = $p->getNext();

$b->getByCol( "package", $row['pID'] ); // this is goddamn awesome
$booboos = $b->numrows();

$bugCount = 0;
$i = 0;

while ( $i < $booboos ) {
  $bug = $b->getNext();   
  if ( $bug['bug_status'] != 8 ) $bugCount++;
  $i++;
}

$bugsFixed = $booboos - $bugCount;

$critical = 0; // doh // $b->specialSelect( "bug_status != 1" );

if ( isset ( $row['pID'] ) ) {
	$TITLE = $row['project_name'] . ", one of the fantastic projects on Whube";
	$CONTENT = "
<h1>" . $row['project_name'] . "</h1>
" . $row['descr'] . "<br />
<br />
There are " . $booboos . " bugs in the tracker on this package (" . $bugCount . " listed, " . $bugsFixed . " fixed). " . $critical . " are critical.
";
} else {
	$_SESSION['err'] = "Project " . $argv[1] . " does not exist!";
	header( "Location: $SITE_PREFIX" . "t/home" );
	exit(0);
}

?>
