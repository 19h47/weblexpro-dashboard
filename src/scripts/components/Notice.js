import { Piece } from 'piecesjs';
import { body } from '../utils/environment.js';
import Cookies from 'js-cookie';

/**
 * Notice
 *
 * @see https://github.com/woocommerce/woocommerce/blob/master/assets/js/frontend/woocommerce.js#L17
 */
class Notice extends Piece {
	constructor() {
		super('Notice');

		this.on('click', this.domAttr('dismiss'), this.dismiss);
	}

	mount() {
		this.name = this.getAttribute('data-name');

		const id = this.getAttribute('data-id') || '';
		this.cookieName = `${this.name}${id}`;

		// Check the value of that cookie and show/hide the notice accordingly
		if ('hidden' === Cookies.get(this.cookieName)) {
			this.close();
		} else {
			this.open();
		}
	}

	// Set a cookie and hide the store notice when the dismiss button is clicked
	dismiss() {
		Cookies.set(this.cookieName, 'hidden', { path: '/' });
		this.close();
	}

	close() {
		body.classList.remove(`Notice-${this.name}--is-open`);
		this.style.setProperty('display', 'none');
		this.parentElement.removeChild(this);
	}

	open() {
		body.classList.add(`Notice-${this.name}--is-open`);
		this.style.removeProperty('display');
	}
}

customElements.define("wlpd-notice", Notice);
