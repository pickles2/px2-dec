/* auto DEC script. */
(function(){
	var params = (function(){
		var result = {};
		if( 1 < window.location.search.length ){
			var query = window.location.search.substring( 1 );
			var parameters = query.split( '&' );
			for( var i = 0; i < parameters.length; i++ ){
				var element = parameters[ i ].split( '=' );
				var paramName = decodeURIComponent( element[ 0 ] );
				var paramValue = decodeURIComponent( element[ 1 ] );
				result[ paramName ] = paramValue;
			}
		}
		return result;
	})();

	function showDEC(){
		// start of original DEC

(function(){
	var timer = null;
	function getOffsetTopLeft( elm ) {
		var top=0, left=0;
		top+=elm.offsetTop;
		left+=elm.offsetLeft;
		if ( elm.offsetParent ) {
			var tmptop = getOffsetTopLeft( elm.offsetParent );
			top+=tmptop.top;
			left+=tmptop.left;
		}
		return {
			"top": top,
			"left": left
		};
	}
	function showDEC(){
		if(timer){clearTimeout(timer);}
		var tmpDECCV=document.querySelectorAll('*[data-dec-comment-viewer]');
		if(tmpDECCV.length){document.body.removeChild(tmpDECCV[0]);}
		var decs = document.querySelectorAll('*[data-dec]');
		var decBlocks = document.querySelectorAll('*[data-dec-block]');
		if(!decs.length&&!decBlocks.length){alert('no DEC found.');return;}
		var wrapper = document.createElement('div');
		wrapper.style.position='absolute';
		wrapper.style.top=0;
		wrapper.style.left=0;
		wrapper.style.zIndex=999999;
		wrapper.setAttribute('data-dec-comment-viewer', '');
		for(var idx=0; decs.length>idx; idx++){
			var decOffset=getOffsetTopLeft(decs[idx]);
			var node = document.createElement('div');
			node.style.position='absolute';
			node.style.top=(decOffset.top)+'px';
			node.style.left=(decOffset.left)+'px';
			node.style.width=(decs[idx].offsetWidth)+'px';
			node.style.height='0px';
			node.style.fontSize='11px';
			node.style.borderRadius='0 15px 0 0';

			var text = document.createElement('div');
			text.style.color='#000';
			text.innerHTML=decs[idx].getAttribute('data-dec');
			text.style.position='absolute';
			text.style.top='-2em';
			text.style.left='-2px';
			text.style.padding='2px 10px';
			text.style.border='2px solid #999';
			text.style.backgroundColor='#fff';
			text.style.fontSize='16px';
			text.style.fontWeight='bold';
			text.style.borderRadius='0 15px 0 0';

			var frm = document.createElement('div');
			frm.style.display='table';
			frm.style.position='absolute';
			frm.style.top='0px';
			frm.style.left='0px';
			frm.style.width=(decs[idx].offsetWidth-10)+'px';
			frm.style.height=(decs[idx].offsetHeight-10)+'px';
			frm.style.border='5px solid #f00';
			frm.style.backgroundColor='#fdd';
			frm.style.opacity='0.2';
			frm.style.borderRadius='0 15px 0 0';

			node.appendChild(frm);
			node.appendChild(text);
			wrapper.appendChild(node);
		}
		for(var idx=0; decBlocks.length>idx; idx++){
			var decB = decBlocks[idx];
			decB.style.color='#f00';
			decB.style.display='block';
			decB.style.border='5px solid #f00';
			decB.style.backgroundColor='#fee';
			decB.style.padding='2px 10px';
			decB.style.margin='1em 10px';
			decB.style.fontSize='16px';
			decB.style.borderRadius='0 15px 0 0';
			// decB.style.textShadow='1px 1px 3px #f99';
		}
		document.body.appendChild(wrapper);
		timer=setTimeout(showDEC, 2000);
	}
	showDEC();
})();

		// end of original DEC
	}

	// console.log(params['showDEC']);
	if( params['showDEC'] ){
		showDEC();
	}

})();
