/**
 * Tailwind config
 */

const colors = require("./tailwind/tailwind.config.colors");
const minWidth = require("./tailwind/tailwind.config.minWidth");
const spacing = require("./tailwind/tailwind.config.spacing");

module.exports = {
	content: ["./views/**/*.twig", "./src/**/*.{html,js}", "./includes/**/*.php"],
	corePlugins: {
		container: false,
	},
	theme: {
		fontFamily: {
			body: ['Open Sans', 'sans-serif'],
		},
		extend: { colors, minWidth, spacing },
	},
	plugins: [],
};
