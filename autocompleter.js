/* global PluginPizzaLoremIpsum */
( function () {

	if ( 'undefined' === typeof PluginPizzaLoremIpsum ) {
		return;
	}

	let iterations = {
		heading: 0,
		headings: {
			short: 0,
			medium: 0,
			long: 0,
		},
		paragraph: 0,
		sentence: 0,
	};

	const completerDefault = {
		name: 'loremipsum',
		triggerPrefix: 'lorem',
		className: 'block-editor-autocompleters__block',
		options: PluginPizzaLoremIpsum.completers.default.options,
		getOptionLabel: ( option ) => {
			return getLabel( option );
		},
		getOptionKeywords: ( option ) => [ option.name ],
		getOptionCompletion: ( option ) => getCompletion( option ),
	};

	const completerHeading = {
		name: 'loremipsum-heading',
		triggerPrefix: 'lorem',
		className: 'block-editor-autocompleters__block',
		options: PluginPizzaLoremIpsum.completers.heading.options,
		getOptionLabel: ( option ) => {
			return getLabel( option );
		},
		getOptionKeywords: ( option ) => [ option.name ],
		getOptionCompletion: ( option ) => getCompletionHeading( option ),
	};

	/**
	 * Gets the formatted option label.
	 *
	 * @param {obj} option The option object.
	 * @returns {obj} An array containing an icon element and the option label.
	 */
	function getLabel( option ) {
		const { createElement } = wp.element;
		const icon = createElement(
			'span',
			{
				className: 'block-editor-block-icon has-colors',
			},
			createElement(
				'svg',
				{
					viewBox: '0 0 24 24',
					xmlns: 'http://www.w3.org/2000/svg',
					width: '24',
					height: '24',
					ariaHidden: 'true',
					focusable: 'false',
				},
				createElement(
					'path',
					{
						d: option.icon
					}
				)
			)
		);

		return [ icon, option.name ];
	}

	/**
	 * Get the completion.
	 *
	 * @param {obj} option The option object.
	 * @returns {obj} An object containing the completer action and the
	 *                value that will be inserted.
	 */
	function getCompletion( option ) {

		const { createBlock } = wp.blocks;

		let action = 'replace';
		let value = '';

		if ( 'image' === option.value ) {

			const { contentWidth } = PluginPizzaLoremIpsum;
			let height = contentWidth;
			let width = contentWidth;
			let aspectRatio = '1';

			switch (option.orientation) {
				case 'portrait':
					width = Math.ceil( contentWidth / 2 );
					height = Math.ceil( width / 3 * 4 );
					aspectRatio = '3/4';
					break;
				case 'landscape':
					width = contentWidth;
					height = Math.ceil( width / 4 * 3 );
					aspectRatio = '4/3';
					break;
			}

			value = createBlock( 'core/image', {
				url: PluginPizzaLoremIpsum.svg + '&w=' + width + '&h=' + height,
				alt: 'Lorem ipsum dolor sit amet',
				aspectRatio,
				sizeSlug: 'large',
				linkDestination: 'none',
				width: `${width}px`
			} );
		} else {
			if ( iterations[option.value] === PluginPizzaLoremIpsum[option.value].length ) {
				iterations[option.value] = 1;
				content = PluginPizzaLoremIpsum[option.value][ iterations[option.value] ];
			} else {
				content = PluginPizzaLoremIpsum[option.value][ iterations[option.value] ];
				iterations.heading++;
			}
			if ( 'heading' === option.value ) {
				const level = option.level || 2;
				value = createBlock( 'core/heading', {
					level,
					content
				} );
			} else {
				action = 'insert-at-caret';
				value = content;
			}

			iterations[option.value]++;
		}

		return { action, value };
	}

	/**
	 * Get the completion that is used if we're in a core/header block.
	 *
	 * @param {obj} option The option object.
	 * @returns {obj} An object containing the completer action and the
	 *                value that will be inserted.
	 */
	function getCompletionHeading( option ) {

		const { headings } = PluginPizzaLoremIpsum;

		if ( iterations.headings[option.value] === headings[option.value].length ) {
			iterations.headings[option.value] = 1;
			value = headings[option.value][ iterations.headings[option.value] ];
		} else {
			value = headings[option.value][ iterations.headings[option.value] ];
			iterations.headings[option.value]++;
		}

		return {
			action: 'insert-at-caret',
			value
		};
	}

	/**
	 * Filter callback function that adds our completer.
	 *
	 * @param {obj} completers The list of completers.
	 * @param {string} blockName The name of the block we're inserting into.
	 * @returns {obj}
	 */
	function appendCompleter( completers, blockName ) {
		switch ( blockName ) {
			case 'core/heading':
				return [ ...completers, completerHeading ];
			default:
				return [ ...completers, completerDefault ];
		}
	}

	wp.hooks.addFilter(
		'editor.Autocomplete.completers',
		'pluginpizza/autocompleters/loremipsum',
		appendCompleter,
		11
	);
} )();
