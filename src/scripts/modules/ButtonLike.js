/* global weblexprodashboard */
import { module as M } from '@19h47/modular';

const { ajax_url: ajaxURL, nonce } = weblexprodashboard;

/**
 *
 * @constructor
 * @param {object} container
 */
class ButtonLike extends M {
	constructor(m) {
		super(m);

		this.events = {
			click: 'like',
		};
	}

	async like() {
		this.locked();

		const response = await this.fetch();
		const data = await response.json();

		console.log(data);

		this.unlocked();
	}

	fetch() {
		const url = new URL(ajaxURL);

		const params = {
			action: this.getData('action'),
			nonce,
			userId: this.getData('user-id'),
			postId: this.getData('post-id'),
		};

		Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

		return fetch(url);
	}

	locked() {
		this.el.classList.add('opacity-50');
		this.el.classList.add('pointer-events-none');
	}

	unlocked() {
		this.el.classList.remove('opacity-50');
		this.el.classList.remove('pointer-events-none');
		this.el.classList.toggle('is-active');
	}
}

export default ButtonLike;
