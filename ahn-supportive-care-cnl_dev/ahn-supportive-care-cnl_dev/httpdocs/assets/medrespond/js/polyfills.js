/* PolyFills for IE8 */
Object.keys = Object.keys || function( o, k, r) {
	// initialize object and result
	r = [];
	// iterate over object keys
	for (k in o)
			// fill result array with non-prototypical keys
			r.hasOwnProperty.call(o, k) && r.push(k);
	// return result
	return r
};

if(!Array.prototype.forEach) {
	Array.prototype.forEach = function(fn, scope) {
		for(var i = 0, len = this.length; i < len; ++i) {
			fn.call(scope, this[i], i, this);
		}
	}
}

(function(d, b) {
		var c = b.documentElement;
		var a = b.body;
		var e = function(g, h, f) {
				if (typeof g[h] === "undefined") {
					Object.defineProperty(g, h, {
						get: f
					})
				}
		};
		e(d, "innerWidth", function() {
			return c.clientWidth
		});
		e(d, "innerHeight", function() {
			return c.clientHeight
		});
		e(d, "scrollX", function() {
			return d.pageXOffset || c.scrollLeft
		});
		e(d, "scrollY", function() {
			return d.pageYOffset || c.scrollTop
		});
		e(b, "width", function() {
			return Math.max(a.scrollWidth, c.scrollWidth, a.offsetWidth, c.offsetWidth, a.clientWidth, c.clientWidth)
		});
		e(b, "height", function() {
			return Math.max(a.scrollHeight, c.scrollHeight, a.offsetHeight, c.offsetHeight, a.clientHeight, c.clientHeight)
		});
		return e
}(window, document));

/* cookie utility functions */
function getCookie(name) {
    var nameEQ = name + '=';
    var ca = document.cookie.split(';');

    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];

        while(c.charAt(0)==' ') {
            c = c.substring(1, c.length);
        }

        if(c.indexOf(nameEQ) == 0) {
            return c.substring(nameEQ.length, c.length);
        }
    }
    return null;
}

function putCookie(name, value, days) {
    if(days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        var expires = '; expires=' + date.toGMTString();
    } else {
        var expires = '';
    }

    document.cookie = name + '=' + value + expires + '; path=/';
}

function deleteCookie(name) {
    putCookie(name, '', -1);
}