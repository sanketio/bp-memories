var gulp 			= require( 'gulp' );
var checktextdomain = require( 'gulp-checktextdomain' );
var wpPot 			= require( 'gulp-wp-pot' );
var sort 			= require( 'gulp-sort' );

gulp.task( 'checktextdomain', function() {
	return gulp.src( '**/*.php' )
		.pipe( checktextdomain( {
			text_domain: 'bp-memories', //Specify allowed domain(s)
			keywords: [ //List keyword specifications
				'__:1,2d',
				'_e:1,2d',
				'_x:1,2c,3d',
				'esc_html__:1,2d',
				'esc_html_e:1,2d',
				'esc_html_x:1,2c,3d',
				'esc_attr__:1,2d',
				'esc_attr_e:1,2d',
				'esc_attr_x:1,2c,3d',
				'_ex:1,2c,3d',
				'_n:1,2,4d',
				'_nx:1,2,4c,5d',
				'_n_noop:1,2,3d',
				'_nx_noop:1,2,3c,4d'
			],
		} ) );
} );

gulp.task( 'makepot', function () {
	return gulp.src( '**/*.php' )
		.pipe( sort() )
		.pipe( wpPot( {
			domain: 'bp-memories',
			destFile:'bp-memories.pot',
			package: 'BP Memories',
			bugReport: '',
			lastTranslator: '',
			team: ''
		} ) )
		.pipe( gulp.dest( 'languages/' ) );
} );

gulp.task( 'default', ['checktextdomain', 'makepot'] );
