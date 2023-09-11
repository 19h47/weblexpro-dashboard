import { module as M } from '@19h47/modular';
import A from '@19h47/accordion';

class Accordion extends M {
	constructor(m) {
		super(m);

		this.accordion = new A(this.el, {
			multiselectable: JSON.parse(this.getData('multiselectable')) || false
		});
		this.accordion.init();
	}
}

export default Accordion;
