(function ( $ ) {
    
    $.fn.hello = function( options ) {
 
        // Default options
        var settings = $.extend({
		name: 'John Doe'
	    }, options );
 
        // Apply options
        return this.append('Hello ' + settings.name + '!');
 
    };
 
}( jQuery ));