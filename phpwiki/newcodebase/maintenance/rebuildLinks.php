<?

# Rebuild link tracking tables from scratch.  This takes several
# hours, depending on the database size and server configuration.

include_once( "Setup.php" );
include_once( "./rebuildLinks.inc" );
$wgTitle = Title::newFromText( "Rebuild links script" );
set_time_limit(0);

$wgDBname			= "yaw";
$wgDBuser			= "wikiadmin";
$wgDBpassword		= "oberon";

rebuildLinkTablesPass1();
rebuildLinkTablesPass2();

print "Done.\n";
exit();

?>
