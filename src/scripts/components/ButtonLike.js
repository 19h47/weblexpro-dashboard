/* global weblexprodashboard */
import { Piece } from "piecesjs";

const { ajax_url: ajaxURL, nonce } = weblexprodashboard;

/**
 *
 * @constructor
 * @param {object} container
 */
class ButtonLike extends Piece {
	constructor() {
		super('ButtonLike');

		this.on('click', this.domAttr('like'), this.like);
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
			action: this.getAttribute('data-action'),
			nonce,
			userId: this.getAttribute('data-user-id'),
			postId: this.getAttribute('data-post-id'),
		};

		Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

		return fetch(url);
	}

	locked() {
		this.classList.add('opacity-50');
		this.classList.add('pointer-events-none');
	}

	unlocked() {
		this.classList.remove('opacity-50');
		this.classList.remove('pointer-events-none');
		this.classList.toggle('is-active');
	}
}

customElements.define("wlpd-button-like", ButtonLike);

