/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referencing this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon-free-social-contact-16x16\'">' + entity + '</span>' + html;
	}
	var icons = {
		'icon-home': '&#xe93e;',
		'icon-home2': '&#xe93f;',
		'icon-home3': '&#xe940;',
		'icon-pencil': '&#xe941;',
		'icon-pencil2': '&#xe93d;',
		'icon-pen': '&#xe93c;',
		'icon-music': '&#xe942;',
		'icon-phone': '&#xe939;',
		'icon-envelop': '&#xe943;',
		'icon-location': '&#xe935;',
		'icon-location2': '&#xe937;',
		'icon-history': '&#xe944;',
		'icon-clock': '&#xe945;',
		'icon-clock2': '&#xe938;',
		'icon-mobile': '&#xe93b;',
		'icon-mobile2': '&#xe93a;',
		'icon-bubble': '&#xe946;',
		'icon-bubble2': '&#xe936;',
		'icon-mail': '&#xe906;',
		'icon-mail2': '&#xe9a7;',
		'icon-mail3': '&#xe947;',
		'icon-mail4': '&#xe9a8;',
		'icon-amazon': '&#xe948;',
		'icon-google': '&#xe907;',
		'icon-google2': '&#xe908;',
		'icon-google3': '&#xe949;',
		'icon-google-plus': '&#xe909;',
		'icon-google-plus2': '&#xe90a;',
		'icon-google-plus3': '&#xe90b;',
		'icon-hangouts': '&#xe94a;',
		'icon-google-drive': '&#xe90c;',
		'icon-facebook': '&#xe900;',
		'icon-facebook2': '&#xe90d;',
		'icon-instagram': '&#xe90e;',
		'icon-whatsapp': '&#xe90f;',
		'icon-spotify': '&#xe94b;',
		'icon-telegram': '&#xe94c;',
		'icon-twitter': '&#xe901;',
		'icon-vine': '&#xe94d;',
		'icon-vk': '&#xe910;',
		'icon-renren': '&#xe94e;',
		'icon-sina-weibo': '&#xe94f;',
		'icon-rss': '&#xe950;',
		'icon-rss2': '&#xe951;',
		'icon-youtube': '&#xe911;',
		'icon-twitch': '&#xe952;',
		'icon-vimeo': '&#xe912;',
		'icon-vimeo2': '&#xe913;',
		'icon-lanyrd': '&#xe953;',
		'icon-flickr': '&#xe914;',
		'icon-flickr2': '&#xe915;',
		'icon-flickr3': '&#xe916;',
		'icon-flickr4': '&#xe917;',
		'icon-dribbble': '&#xe918;',
		'icon-behance': '&#xe919;',
		'icon-behance2': '&#xe91a;',
		'icon-deviantart': '&#xe954;',
		'icon-500px': '&#xe955;',
		'icon-steam': '&#xe91b;',
		'icon-steam2': '&#xe956;',
		'icon-dropbox': '&#xe91c;',
		'icon-onedrive': '&#xe957;',
		'icon-github': '&#xe91d;',
		'icon-npm': '&#xe958;',
		'icon-basecamp': '&#xe959;',
		'icon-trello': '&#xe95a;',
		'icon-wordpress': '&#xe95b;',
		'icon-joomla': '&#xe95c;',
		'icon-ello': '&#xe95d;',
		'icon-blogger': '&#xe91e;',
		'icon-blogger2': '&#xe91f;',
		'icon-tumblr': '&#xe920;',
		'icon-tumblr2': '&#xe921;',
		'icon-yahoo': '&#xe922;',
		'icon-yahoo2': '&#xe923;',
		'icon-tux': '&#xe95e;',
		'icon-appleinc': '&#xe902;',
		'icon-android': '&#xe903;',
		'icon-windows': '&#xe95f;',
		'icon-windows8': '&#xe960;',
		'icon-soundcloud': '&#xe961;',
		'icon-soundcloud2': '&#xe924;',
		'icon-skype': '&#xe904;',
		'icon-reddit': '&#xe925;',
		'icon-hackernews': '&#xe926;',
		'icon-wikipedia': '&#xe962;',
		'icon-linkedin': '&#xe927;',
		'icon-linkedin2': '&#xe905;',
		'icon-lastfm': '&#xe928;',
		'icon-lastfm2': '&#xe929;',
		'icon-delicious': '&#xe92a;',
		'icon-stumbleupon': '&#xe92b;',
		'icon-stumbleupon2': '&#xe92c;',
		'icon-stackoverflow': '&#xe92d;',
		'icon-pinterest': '&#xe92e;',
		'icon-pinterest2': '&#xe92f;',
		'icon-xing': '&#xe930;',
		'icon-xing2': '&#xe931;',
		'icon-flattr': '&#xe932;',
		'icon-foursquare': '&#xe933;',
		'icon-yelp': '&#xe934;',
		'icon-paypal': '&#xe963;',
		'icon-chrome': '&#xe964;',
		'icon-firefox': '&#xe965;',
		'icon-IE': '&#xe966;',
		'icon-edge': '&#xe967;',
		'icon-safari': '&#xe968;',
		'icon-opera': '&#xe969;',
		'icon-git': '&#xe96a;',
		'icon-codepen': '&#xe96b;',
		'icon-svg': '&#xe96c;',
		'icon-IcoMoon': '&#xe96d;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
