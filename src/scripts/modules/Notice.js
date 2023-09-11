import { module as M } from '@19h47/modular';
import { body } from 'utils/environment';
import Cookies from 'js-cookie';

/**
 * Notice
 *
 * @see https://github.com/woocommerce/woocommerce/blob/master/assets/js/frontend/woocommerce.js#L17
 */
class Notice extends M {
	constructor(m) {
		super(m);

		this.events = {
			click: {
				dismiss: 'dismiss'
			}
		}
	}

	init() {
		this.name = this.getData('name');

		const id = this.getData('id') || '';
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
		this.el.style.setProperty('display', 'none');
		this.el.parentElement.removeChild(this.el);
	}

	open() {
		body.classList.add(`Notice-${this.name}--is-open`);
		this.el.style.removeProperty('display');
	}
}

export default Notice;
