<?php

$p = $PROJECT_OBJECT;
$b = $BUG_OBJECT;
$u = $USER_OBJECT;
$t = $TEAM_OBJECT;

$u->getByCol( "username", $argv[1] );
$user = $u->getNext();

$RIGHTS_OBJECT->getAllByPK( $user['uID'] );
$user_rights = $RIGHTS_OBJECT->getNext();

$p->getAll( "owner", $user['uID'] ); // this is goddamn awesome
$projects = $p->numrows();

$b->getByCol( "package", $user["uID"] ); // this is goddamn awesome
$booboos = $b->numrows();

$ofTeam = '';

if ( $user['team'] != '' || $user['team'] != '0' ) {
	$t->getByCol( "tID" , $user["team"] );
	$team = $t->getNext();
	$teamName = $team['team_name'];
	
	if ( strpos ( $teamName, ' ' ) ) {
		$teamLink = str_replace ( ' ', '-', $teamName );
	} else {
		$teamLink = $teamName;
	}
	
	
	$ofTeam = " of <a href = '" . $SITE_PREFIX . "/t/team/" . $teamLink . "' >" . $teamName . "</a>";
}

$critical = 0; // doh // $b->specialSelect( "bug_status != 1" );

if ( isset ( $user["username"] ) ) {

	$projectList = "";

  $i=0;
  while( $row = $p->getNext() ) {
    $projectList .= "<li><a href='../project/" . $row['project_name'] . "'>" . $row['project_name'] . "</a></li>";
    $i++;
  }
  
	$TITLE = $user["username"] . ", one of the fantastic users on Whube";
	$CONTENT = "
<h1>" . $user["username"] . "</h1>
This here be " . $user['real_name'] . $ofTeam . "<br />

There are " . $booboos . " bugs filed by " . $user['username'] . ". " . $critical . " are critical.<br />
<br />

" . ucwords($user['username']) ." is owner of " . $projects . " projects. These projects are: 
<ul>" . $projectList . "</ul>
";
/*

<br />
" . $user_rights['admin'] . " - Admin<br />
" . $user_rights['staff'] . " - Staff<br />
" . $user_rights['doner'] . " - Doner<br />
" . $user_rights['member'] . " - Member<br />
" . $user_rights['banned'] . " - Banned<br />


*/

} else {
	$_SESSION['err'] = "User " . $argv[1] . " does not exist!";
	header( "Location: $SITE_PREFIX" . "t/home" );
	exit(0);
}

?>
