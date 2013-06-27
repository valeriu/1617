/* Load this script using conditional IE comments if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-thunderstorm' : '&#xe000;',
			'icon-sunny' : '&#xe001;',
			'icon-snow' : '&#xe002;',
			'icon-showers' : '&#xe003;',
			'icon-rain' : '&#xe004;',
			'icon-partlycloudy' : '&#xe005;',
			'icon-overcast' : '&#xe006;',
			'icon-mostlycloudy' : '&#xe007;',
			'icon-haze' : '&#xe008;',
			'icon-fog' : '&#xe009;',
			'icon-drizzle' : '&#xe00a;',
			'icon-blowingsnow' : '&#xe00b;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
};