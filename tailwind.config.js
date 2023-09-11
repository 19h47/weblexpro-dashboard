/**
 * Tailwind config
 */

const colors = require("./tailwind/tailwind.config.colors");
const minWidth = require("./tailwind/tailwind.config.minWidth");
const plugin = require('tailwindcss/plugin');
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
		fontFamily: {
			body: ['Qlassik', 'sans-serif'],
			title: ['Qlassik', 'sans-serif'],
		},
		extend: { colors, minWidth, spacing, zIndex },
	},
	plugins: [
		plugin(({ addVariant }) => addVariant('parent-is-active', '.is-active > &')),
	],
};
