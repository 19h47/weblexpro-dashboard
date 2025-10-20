import { Piece } from "piecesjs";
import DB from '@19h47/disclosure-button';

class DisclosureButton extends Piece {
	constructor() {
		super('DisclosureButton');
	}

	mount() {
		this.disclosureButton = new DB(this.domAttr('button'));
		this.disclosureButton.init();
	}

	destroy() {
		this.disclosureButton.destroy();
	}
}

customElements.define("wlpd-disclosure-button", DisclosureButton);
