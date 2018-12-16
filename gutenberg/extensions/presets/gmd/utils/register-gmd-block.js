/** @format */
/**
 * External dependencies
 */
import { get } from 'lodash';
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import getGMDData from './get-gmd-data';

/**
 * Registers a gutenberg block if the availability requirements are met.
 *
 * @param {string} name The block's name.
 * @param {object} settings The block's settings.
 * @returns {object|false} Either false if the block is not available, or the results of `registerBlockType`
 */
export default function registerGMDBlock( name, settings ) {
	const data = getGMDData();
	const available = get( data, [ 'available_blocks', name, 'available' ], false );
	if ( data && ! available ) {
		// TODO: check 'unavailable_reason' and respond accordingly
		return false;
	}

	return registerBlockType( `gmd/${ name }`, settings );
}
