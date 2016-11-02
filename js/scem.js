/**
 * Convert scrambled email into a mailto link
 *
 * @since TODO version
 *
 * @param	 string				eml		Base64 encoded Email address
 * @param	 string				ttl		Base64 encoded link's text content
 * @param	 null|string	clss	Optional. Class to add to the link element.
 *														Specify multiple classes separated by a comma (,).
 * @param	 null|string	sbj		Optional. A default subject to add to the mailto link.
 * @return	bool
 */
function scem_unscramble( eml, ttl, clss, sbj ) {

	/**
	 * Helper fonction to test if variable is set and not null
	 *
	 * @since TODO version
	 *
	 * @param	 mixed variable
	 * @return	bool
	 */
	var _isset = function( variable ) {

		if ( undefined === variable ) { return false; }
		else if ( null === variable ) { return false; }

		return true;
	};

	/**
	 * Determine whether a variable is empty
	 *
	 * @since TODO version
	 *
	 * @param mixed variable	Variable to be checked
	 * @return bool						Returns FALSE if var exists and has a non-empty, non-zero value. Otherwise returns TRUE.
	 */
	var _empty = function( variable ) {

		if ( !_isset(variable) )						{ return true; }
		else if ( 0 === variable )				{ return true; }
		else if ( 0 === variable.length )	{ return true; }

		return false;
	};

	// User, domain and tld are mandatory
	if ( _empty(eml) ) {
		return;
	}

	var a = document.createElement("a");

	a.href = 'mailto:'+ window.atob(eml) +( !_empty(sbj) ? '?subject='+ sbj : '' );

	a.innerHTML = window.atob(ttl);

	if ( !_empty(clss) ) {
		var classes = clss.split(',');

		for (var i = 0; i < classes.length; i++ ) {
			a.classList.add( classes[i] );
		}
	}

	document.currentScript.parentElement.replaceChild( a, document.currentScript );
}
