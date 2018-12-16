/** @format */
/**
 * External dependencies
 */
import { registerPlugin } from '@wordpress/plugins';
import get from 'lodash/get';

/**
 * Internal dependencies
 */
import getGMDData from './get-gmd-data';

/**
 * Registers a Gutenberg block if the availability requirements are met.
 *
 * @param {string} name The plugin's name
 * @param {object} settings The plugin's settings.
 * @returns {object|false} Either false if the plugin is not available, or the results of `registerPlugin`
 */
export default function registerGMDPlugin( name, settings ) {
	const data = getGMDData();
	const available = get( data, [ 'available_blocks', name, 'available' ], false );
	if ( data && ! available ) {
		// TODO: check 'unavailable_reason' and respond accordingly
		return false;
	}

	return registerPlugin( `gmd-${ name }`, settings );
}
