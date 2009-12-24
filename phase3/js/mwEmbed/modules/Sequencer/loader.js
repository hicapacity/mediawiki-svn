/*
* Sequencer loader
*/
mw.addClassFilePaths( {
	"mw.PlayList"			: "modules/Sequencer/mw.PlayList.js",
	"mw.Sequencer"			: "modules/Sequencer/mw.Sequencer.js",
	"mw.SeqRemoteSearchDriver" : "modules/Sequencer/mw.SeqRemoteSearchDriver.js",	
	"mw.TimedEffectsEdit"	: "modules/Sequencer/mvTimedEffectsEdit.js",
	
	"RemoteMwSequencer" :	"modules/Sequencer/remotes/RemoteMwSequencer.js"
} );

mw.addModuleLoader( 'Sequencer', function( callback ){
	//Get sequencer style sheet	
	mw.getStyleSheet( mw.getMwEmbedPath() + 'skins/' + mw.getConfig( 'skinName' ) + '/mv_sequence.css' );
	// Make sure we have the required mwEmbed libs:			
	mw.load( [
		[	// Load the EmbedPlayer Module ( includes lots of dependent classes )   
			'EmbedPlayer'
		],		
		[										
			// Load playlist and its dependencies
			'mw.PlayList',
			'$j.ui',
			'$j.contextMenu',
			'JSON',
			'mw.Sequencer'
		],
		[
			// Ui components used in the sequencer interface: 
			'$j.ui.accordion',
			'$j.ui.dialog',
			'$j.ui.droppable',
			'$j.ui.draggable',
			'$j.ui.progressbar',
			'$j.ui.sortable',
			'$j.ui.resizable',
			'$j.ui.slider',
			'$j.ui.tabs'
		]
	], function() {
		callback( 'Sequencer' );
	});

});