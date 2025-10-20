import { Piece } from "piecesjs";
import A from '@19h47/accordion';

class Accordion  extends Piece {
	constructor() {
		super('Accordion');

		this.accordion = new A(this, {
			multiselectable: JSON.parse(this.getAttribute('multiselectable')) || false
		});
		this.accordion.init();
	}
}

customElements.define("wlpd-accordion", Accordion);
