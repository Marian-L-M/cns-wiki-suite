/**
 * Extends the default @wordpress/scripts config with a non-block entry for
 * the glossary rich-text format (blocks are still auto-discovered via
 * --blocks-manifest). Output: build/formats/glossary.js + .asset.php.
 */
const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

const configs = Array.isArray( defaultConfig )
	? defaultConfig
	: [ defaultConfig ];
const [ scriptConfig, ...rest ] = configs;

const withFormats = {
	...scriptConfig,
	entry: {
		...( typeof scriptConfig.entry === 'function'
			? scriptConfig.entry()
			: scriptConfig.entry ),
		'formats/glossary': path.resolve(
			__dirname,
			'src/formats/glossary/index.js'
		),
	},
};

module.exports = Array.isArray( defaultConfig )
	? [ withFormats, ...rest ]
	: withFormats;
