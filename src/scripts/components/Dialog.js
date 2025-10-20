import { Piece } from "piecesjs";

import { disableScroll, enableScroll } from '../utils/scroll.js';

/**
 *
 * @constructor
 * @param {object} container
 */
class Dialog extends Piece {
	constructor() {
		super('Dialog');

		this.isOpen = this.classList.contains('is-active') || false;

		this.on('click', this.domAttr('close'), this.close);
		this.on('click', this.domAttr('backdrop'), this.close);
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
		this.style.removeProperty('display');

		return true;
	}

	close() {
		// console.info('Dialog.close', { open: this.isOpen });

		if (!this.isOpen) {
			return false;
		}

		this.isOpen = false;

		enableScroll();
		this.style.setProperty('display', 'none');

		return true;
	}
}

customElements.define("wlpd-dialog", Dialog);
