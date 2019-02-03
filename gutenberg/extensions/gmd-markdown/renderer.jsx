/** @format */

/**
 * External dependencies
 */
import MarkdownIt from 'markdown-it';
import MarkdownItKaTeX from 'markdown-it-plugin-katex';
import MarkdownItMermaid from 'markdown-it-plugin-mermaid';
import MarkdownItPrism from 'markdown-it-prism';
//import 'prismjs/components/prism-markup-templating'
import { RawHTML } from '@wordpress/element';

/**
 * Internal dependencies
 */
import { __ } from 'gutenberg/extensions/presets/gmd/utils/i18n';

/**
 * Module variables
 */
const markdownConverter = new MarkdownIt();

if ( window.WP_GMD.isKaTeX === 'on' ) {
	// 启用KaTeX插件
	markdownConverter.use(MarkdownItKaTeX);
}

if ( window.WP_GMD.isMermaid === 'on' ) {
	// 启用Mermaid插件
	markdownConverter.use(MarkdownItMermaid);
}

// 启用Prism.js高亮插件
markdownConverter.use(MarkdownItPrism, {
	plugins: [
	],
	init: (Prism) => {
		require('prismjs/components/prism-markup-templating');
	},
	defaultLanguage: undefined
});

const handleLinkClick = event => {
	if ( event.target.nodeName === 'A' ) {
		const hasConfirmed = window.confirm( __( 'Are you sure you wish to leave this page?' ) );

		if ( ! hasConfirmed ) {
			event.preventDefault();
		}
	}
};

export default ( { className, source = '' } ) => (
	<RawHTML className={ className } onClick={ handleLinkClick }>
		{ source.length ? markdownConverter.render( source ) : '' }
	</RawHTML>
);
