/** @format */

/**
 * External dependencies
 */
import { getCategories, setCategories } from '@wordpress/blocks';

setCategories( [
	...getCategories().filter( ( { slug } ) => slug !== 'gmd' ),
	// Add a Jetpack block category
	{
		slug: 'gmd',
		title: '扩展'
	},
] );
