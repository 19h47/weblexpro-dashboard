/* global weblexprodashboard */
import { body, html } from './utils/environment.js';
import { load } from 'piecesjs';
import.meta.glob("../img/**/*");

load('wlpd-accordion', () => import('./components/Accordion.js'));
load('wlpd-button-like', () => import('./components/ButtonLike.js'));
load('wlpd-disclosure-button', () => import('./components/DisclosureButton.js'));
load('wlpd-dialog', () => import('./components/Dialog.js'));
load('wlpd-dialog-button', () => import('./components/DialogButton.js'));
load('wlpd-notice', () => import('./components/Notice.js'));

const { text_domain: textDomain } = weblexprodashboard;


function init() {
	html.classList.add('is-loaded');
	html.classList.add('is-ready');
	html.classList.add('is-first-load');
	html.classList.remove('is-loading');
	body.classList.remove('cursor-wait');

	setTimeout(() => {
		html.classList.add('has-dom-ready');
	}, 0);
}

window.onload = async () => {
	const $style = document.getElementById(`${textDomain}-main-css`);

	if ($style) {
		if ($style.isLoaded) {
			init();
		} else {
			$style.addEventListener('load', () => init());
		}
	} else {
		console.warn(`The "${textDomain}-main-css" stylesheet not found`);
	}
};
