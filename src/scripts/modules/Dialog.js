import { module as M } from '@19h47/modular';

import { disableScroll, enableScroll } from 'utils/scroll';

/**
 *
 * @constructor
 * @param {object} container
 */
class Dialog extends M {
	constructor(m) {
		super(m);

		this.isOpen = this.el.classList.contains('is-active') || false;

		this.events = {
			click: {
				close: 'close',
				backdrop: 'close',
			},
		};
	}

	toggle() {
		// console.info('Dialog.toggle', this.el.id);

		if (this.isOpen) {
			return this.close();
		}

		return this.open();
	}

	open() {
		// console.info('Dialog.open', anchor);

		if (this.isOpen) {
			return false;
		}

		this.isOpen = true;

		disableScroll();
		this.el.style.removeProperty('display');

		return true;
	}

	close() {
		// console.info('Dialog.close', { open: this.isOpen });

		if (!this.isOpen) {
			return false;
		}

		this.isOpen = false;

		enableScroll();
		this.el.style.setProperty('display', 'none');

		return true;
	}
}

export default Dialog;
