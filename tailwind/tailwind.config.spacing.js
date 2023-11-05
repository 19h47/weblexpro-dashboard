const { percentage, rem } = require('./tailwind.utils.js')

module.exports = {
	"1.5/12": percentage(1.5 / 12),
	"2.5/12": percentage(2.5 / 12),
	"3/12": percentage(3 / 12),
	"4/12": percentage(4 / 12),
	"6.5/12": percentage(6.5 / 12),
	11.5: rem(46),
	13: rem(52),
	15: rem(60),
	17: rem(68),
	17.5: rem(70),
	21: rem(84),
	26.25: rem(105),
	31.5: rem(126),
	33.5: rem(134),
	98.5: rem(394)
};
