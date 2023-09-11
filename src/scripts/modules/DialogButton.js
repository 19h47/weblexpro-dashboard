import { module as M } from '@19h47/modular';

class DialogButton extends M {
	constructor(m) {
		super(m);

		this.events = {
			click: 'open'
		}
	}

	init() {
		this.id = this.getData('dialog-id');
	}

	open() {
		this.call('close', false, 'Dialog');
		this.call('open', false, 'Dialog', this.id);
	}
}

export default DialogButton;
