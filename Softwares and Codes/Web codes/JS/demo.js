/*
 * Another In Place Editor - a jQuery edit in place plugin
 *
 * Copyright (c) 2009 Dave Hauenstein
 *
 * License:
 * This source file is subject to the BSD license bundled with this package.
 * Available online: {@link http://www.opensource.org/licenses/bsd-license.php}
 * If you did not receive a copy of the license, and are unable to obtain it,
 * email davehauenstein@gmail.com,
 * and I will send you a copy.
 *
 * Project home:
 * http://code.google.com/p/jquery-in-place-editor/
 *
 */
  
$(document).ready(function(){
	
	// All examples use the commit to function interface for ease of demonstration.
	// If you want to try it against a server, just comment the callback: and 
	// uncomment the url: lines.
	
	$("#editme5").editInPlace({
		saving_animation_color: "#ECF2F8",
		callback: function(idOfEditor, enteredText, orinalHTMLContent, settingsParams, animationCallbacks) {
			animationCallbacks.didStartSaving();
			setTimeout(animationCallbacks.didEndSaving, 2000);
			return enteredText;
		}
	});
	
	// If you need to remove an already bound editor you can call

	// > $(selectorForEditors).unbind('.editInPlace')

	// Which will remove all events that this editor has bound. You need to make sure however that the editor is 'closed' when you call this.
	
});