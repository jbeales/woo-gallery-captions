(function($) {

	function updateCaptionFromMutation(mutation)
	{
		var	img = mutation.target,
			container = img.closest('div[class^="woocommerce-product-gallery__image"'),
			captionContainer,
			titleElm,
			captionElm,
			hasRemove = (typeof img.remove === 'function');

		if(container) {
			captionContainer = container.querySelector('div.gcw-caption');
			if(captionContainer) {
				titleElm = captionContainer.querySelector('h5');
				captionElm = captionContainer.querySelector('p');
			}

			if(img.getAttribute('title').length > 0 || img.getAttribute('data-caption').length > 0) {
				if(!captionContainer) {
					captionContainer = document.createElement('div');
					captionContainer.classList.add('gcw-caption');
					container.appendChild(captionContainer);
				}

				if(img.getAttribute('title').length > 0) {
					if(!titleElm) {
						titleElm = document.createElement('h5');
						captionContainer.insertBefore(titleElm, captionContainer.firstChild);
					}
					titleElm.innerHTML = img.getAttribute('title');
				}

				if(img.getAttribute('data-caption').length > 0 ) {
					if(!captionElm) {
						captionElm = document.createElement('p');
						captionContainer.appendChild(captionElm);
					}
					captionElm.innerHTML = img.getAttribute('data-caption');
				}
			}
		}

		

		// Remove empty elements if needed.
		if( img.getAttribute('title').length === 0 && titleElm ) {
			titleElm.parentNode.removeChild(titleElm);
		}

		if( img.getAttribute('data-caption').length === 0 && captionElm ) {
			captionElm.parentNode.removeChild(captionElm);
		}
	}


	function mutationCallback(mutationsList, observer)
	{
		for(var i=0;i<mutationsList.length;i++) {
			updateCaptionFromMutation(mutationsList[i]);
		}
	}

	// Does the image we care about exist on the page?
	function init()
	{
		var img = ( document.querySelector('.woocommerce-product-gallery div[class^="woocommerce-product-gallery__image"] .wp-post-image') ),
			config = {attributes: true, attributeFilter: ['data-src']},
			observer = new MutationObserver(mutationCallback);

		if(img) {
			observer.observe(img, config);
		}
	}

	$(init);
})(jQuery);