import { Piece } from "piecesjs";

class DialogButton extends Piece {
	constructor() {
		super('DialogButton');

		this.on('click', this.domAttr('button'), this.open);
	}

	mount() {
		this.id = this.getAttribute('data-id');
	}

	open() {
		this.call('close', {}, 'Dialog');
		this.call('open', {}, 'Dialog', this.id);
	}
}

customElements.define("wlpd-dialog-button", DialogButton);
