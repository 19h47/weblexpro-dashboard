import { module as M } from '@19h47/modular';
import DB from '@19h47/disclosure-button';

class DisclosureButton extends M {
	init() {
		this.disclosureButton = new DB(this.el);
		this.disclosureButton.init();
	}

	destroy() {
		this.disclosureButton.destroy();
	}
}

export default DisclosureButton;
