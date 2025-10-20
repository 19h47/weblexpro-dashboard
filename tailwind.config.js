/**
 * Tailwind config
 */

const minWidth = require("./tailwind/tailwind.config.minWidth");
const spacing = require("./tailwind/tailwind.config.spacing");

const zIndex = {
	1: '1',
	2: '2',
	3: '3',
	4: '4',
	5: '5',
};

module.exports = {
	content: ["./views/**/*.twig", "./src/**/*.{html,js}", "./includes/**/*.php"],
	corePlugins: {
		container: false,
	},
	theme: {
		extend: { minWidth, spacing, zIndex },
	},
};
