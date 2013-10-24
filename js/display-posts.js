(function() {
	tinymce.create('tinymce.plugins.display_posts', {

	/**
	 *
	 */
	init : function(ed, url) {
		ed.addButton('display_posts', {
			title : 'Display Posts',
			cmd   : 'display_posts_cmd',
			image : url + '/icon.jpg'
		});

		ed.addCommand('display_posts_cmd', function() {
		var number = prompt( "How many posts you want to show ? " ), shortcode;
		if ( number !== null ) {
			number = parseInt( number );
			shortcode = '[display_posts posts_per_page="' + number + '"]';
			ed.execCommand( 'mceInsertContent', 0, shortcode );
		}
		});
	},

	/**
	 *
	 */
		createControl : function(n, cm) {
			return null;
		},

	/**
	 *
	 */
		getInfo : function() {
			return {
				longname  : 'Display Posts button',
				author    : 'Matt Keehner',
				authorurl : '',
				infourl   : '',
				version   : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add( 'display_posts', tinymce.plugins.display_posts );
})();