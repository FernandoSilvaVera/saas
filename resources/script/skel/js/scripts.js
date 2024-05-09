$('img[alt="imagenEnLinea"]').addClass('imagenEnLinea');
$('body').append('<div id="modalAyuda" class="modal modalComponente"> <div class="modal-content"> <h4 style="text-align:center;color:#004a61;">¿Podemos ayudarte?</h4><div class="valign-wrapper modulosAyuda"><img src="imagenes/modalAyuda/conjuntoComponentes.png" alt="Conjunto componentes" title="Componentes" style="margin-right:30px;"><p><strong>Componentes</strong> <br/>A través de estos botones, por medio de diferentes canales de aprendizaje (enlaces, citas, conceptos, vídeos, etc.), descubrirás información de interés relacionada con los contenidos.</p></div><div class="valign-wrapper modulosAyuda"><img src="imagenes/modalAyuda/actividades.png" alt="Actividades" title="Actividades" style="margin-right:30px;"><p><strong>Actividades autoevaluables</strong> <br/>Estos iconos identifican las actividades autoevaluables. El primero te ayudará a identificar el apartado en el que se encuentran. Pulsando el segundo accederás a las actividades.</p></div><div class="valign-wrapper modulosAyuda"><img src="imagenes/modalAyuda/subrayar.png" alt="Subrayar" title="Subrayar" style="margin-right:30px;"><p><strong>Subrayar</strong> <br/>Si activas esta opción puedes subrayar aquellas partes que consideres importantes en el texto.</p></div><div class="valign-wrapper modulosAyuda"><img src="imagenes/modalAyuda/anotaciones.png" alt="Anotaciones" title="Anotaciones" style="margin-right:30px;"><p><strong>Anotaciones</strong> <br/>Por medio de este icono podrás incluir anotaciones en el contenido.</p></div><div class="valign-wrapper modulosAyuda"><img src="imagenes/modalAyuda/importarExportar.png" alt="importarExportar" title="importarExportar" style="margin-right:30px;"><p><strong>Importar / Exportar</strong> <br/>Estos iconos te permitirán importar y exportar las anotaciones y los contenidos subrayados, de forma que puedan compartirse entre diferentes navegadores y/o usuarios.</p></div><div class="valign-wrapper modulosAyuda"><img src="imagenes/modalAyuda/busqueda.png" alt="Búsqueda" title="Búsqueda" style="margin-right:30px;"><p><strong>Búsqueda</strong> <br/>Por medio de este icono prodrás realizar búsquedas en los contenidos de la unidad didáctica.</p></div><div class="valign-wrapper modulosAyuda"><img src="imagenes/modalAyuda/accesibilidad.png" alt="Accesibilidad" title="Accesibilidad" style="margin-right:30px;"><p><strong>Accesibilidad</strong> <br/>Permite navegar entre los contenidos utilizando el teclado (AvPág, RePág, Inicio, Fin, 1, 2, 3...), alternar entre modo día/noche, aumentar el tamaño de la tipografía y mostrar las imágenes en escala de grises.</p></div>       </div> <div class="modal-footer"> <a class="modal-action modal-close waves-effect waves btn-flat">Cerrar</a> </div> </div>')

$('body').find('tr th').each(function() {
	$(this).replaceWith("<td>" + $(this).html() + "</td>");
});
var forzarSubrayado = false;
var arrayActividadesEleccionMultiple = [];
var arrayActividadesSeleccionMultiple = [];
var existenciaActividades = false;
var permitirAnotaciones = true;
function embeberVideosYoutube(selectorClase) {
	recogerTitulo = document.title;
	regexRecursosBibliograficos = new RegExp('.*ecursos.*bibliog.*')
	comprobarRegexRecursosBibliograficos = regexRecursosBibliograficos.test(recogerTitulo)
	if (comprobarRegexRecursosBibliograficos != true) {
		$('.'+selectorClase+'').find('a').each(function () {
			recogerHREF = $(this).attr('href')
			regexDireccionYoutube = /https:\/\/youtu.be.*?/;
			comprobarRegex = regexDireccionYoutube.test(recogerHREF)
			if (comprobarRegex === true) {
				obtenerCodigoOnceDigitos = recogerHREF.substring(17, 28)
				$(this).parents('p').before('<p style="text-align:center"><iframe width="560" height="315" src="https://www.youtube.com/embed/' + obtenerCodigoOnceDigitos + '?rel=0" frameborder="0"></iframe></p>');
			}
		});
	}
}
function recordarUltimaPaginaVisitada() {
	rutaBase = document.URL.replace(/(.*)\/.*/, '$1')
	paginaWeb = document.URL.replace(/.*\//, '')
	
	paginaGuardada = false
	for (i = 0; i < localStorage.length; i++) {
		llave = localStorage.key(i);
		if (llave === 'UPV_ui1_' + rutaBase + '') {
			paginaGuardada = localStorage.getItem(llave)
		}
	}
	
	if (paginaGuardada === false) {
		localStorage.setItem('UPV_ui1_' + rutaBase + '', paginaWeb)
		sessionStorage.setItem('UPV_ui1_' + rutaBase + '', 'no-recuperar')
	}
	
	recuperarPaginaGuardada = false
	for (i = 0; i < sessionStorage.length; i++) {
		llave = sessionStorage.key(i);
		if (llave === 'UPV_ui1_' + rutaBase + '') {
			recuperarPaginaGuardada = sessionStorage.getItem(llave)
		}
	}
	if (paginaGuardada != false && recuperarPaginaGuardada !== "no-recuperar") {
		sessionStorage.setItem('UPV_ui1_' + rutaBase + '', 'no-recuperar')
		var toastHTML = '<span class="toast-ultima-pagina" onclick="window.location=\'' + paginaGuardada + '\'">Última página visitada</span><span onclick="Materialize.Toast.removeAll()"><i class="material-icons" style="font-size:medium;margin:10px;cursor:pointer;">close</i></span>';
		Materialize.toast(toastHTML, 5000);
		$('.toast-ultima-pagina').attr('style', 'font-size:small;cursor:pointer;').parent().attr('style', 'padding:10px 15px')
	}
	if (paginaGuardada != false && recuperarPaginaGuardada === "no-recuperar") {
		localStorage.setItem('UPV_ui1_' + rutaBase + '', paginaWeb)
	}
}
//     Underscore.js 1.8.3
//     http://underscorejs.org
//     (c) 2009-2015 Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
//     Underscore may be freely distributed under the MIT license.
(function () {
	function n(n) {
		function t(t, r, e, u, i, o) {
			for (; i >= 0 && o > i; i += n) {
				var a = u ? u[i] : i;
				e = r(e, t[a], a, t)
			}
			return e
		}
		return function (r, e, u, i) {
			e = b(e, i, 4);
			var o = !k(r) && m.keys(r),
				a = (o || r).length,
				c = n > 0 ? 0 : a - 1;
			return arguments.length < 3 && (u = r[o ? o[c] : c], c += n), t(r, e, u, o, c, a)
		}
	}

	function t(n) {
		return function (t, r, e) {
			r = x(r, e);
			for (var u = O(t), i = n > 0 ? 0 : u - 1; i >= 0 && u > i; i += n)
				if (r(t[i], i, t)) return i;
			return -1
		}
	}

	function r(n, t, r) {
		return function (e, u, i) {
			var o = 0,
				a = O(e);
			if ("number" == typeof i) n > 0 ? o = i >= 0 ? i : Math.max(i + a, o) : a = i >= 0 ? Math.min(i + 1, a) : i + a + 1;
			else if (r && i && a) return i = r(e, u), e[i] === u ? i : -1;
			if (u !== u) return i = t(l.call(e, o, a), m.isNaN), i >= 0 ? i + o : -1;
			for (i = n > 0 ? o : a - 1; i >= 0 && a > i; i += n)
				if (e[i] === u) return i;
			return -1
		}
	}

	function e(n, t) {
		var r = I.length,
			e = n.constructor,
			u = m.isFunction(e) && e.prototype || a,
			i = "constructor";
		for (m.has(n, i) && !m.contains(t, i) && t.push(i); r--;) i = I[r], i in n && n[i] !== u[i] && !m.contains(t, i) && t.push(i)
	}
	var u = this,
		i = u._,
		o = Array.prototype,
		a = Object.prototype,
		c = Function.prototype,
		f = o.push,
		l = o.slice,
		s = a.toString,
		p = a.hasOwnProperty,
		h = Array.isArray,
		v = Object.keys,
		g = c.bind,
		y = Object.create,
		d = function () { },
		m = function (n) {
			return n instanceof m ? n : this instanceof m ? void (this._wrapped = n) : new m(n)
		};
	"undefined" != typeof exports ? ("undefined" != typeof module && module.exports && (exports = module.exports = m), exports._ = m) : u._ = m, m.VERSION = "1.8.3";
	var b = function (n, t, r) {
		if (t === void 0) return n;
		switch (null == r ? 3 : r) {
			case 1:
				return function (r) {
					return n.call(t, r)
				};
			case 2:
				return function (r, e) {
					return n.call(t, r, e)
				};
			case 3:
				return function (r, e, u) {
					return n.call(t, r, e, u)
				};
			case 4:
				return function (r, e, u, i) {
					return n.call(t, r, e, u, i)
				}
		}
		return function () {
			return n.apply(t, arguments)
		}
	},
		x = function (n, t, r) {
			return null == n ? m.identity : m.isFunction(n) ? b(n, t, r) : m.isObject(n) ? m.matcher(n) : m.property(n)
		};
	m.iteratee = function (n, t) {
		return x(n, t, 1 / 0)
	};
	var _ = function (n, t) {
		return function (r) {
			var e = arguments.length;
			if (2 > e || null == r) return r;
			for (var u = 1; e > u; u++)
				for (var i = arguments[u], o = n(i), a = o.length, c = 0; a > c; c++) {
					var f = o[c];
					t && r[f] !== void 0 || (r[f] = i[f])
				}
			return r
		}
	},
		j = function (n) {
			if (!m.isObject(n)) return {};
			if (y) return y(n);
			d.prototype = n;
			var t = new d;
			return d.prototype = null, t
		},
		w = function (n) {
			return function (t) {
				return null == t ? void 0 : t[n]
			}
		},
		A = Math.pow(2, 53) - 1,
		O = w("length"),
		k = function (n) {
			var t = O(n);
			return "number" == typeof t && t >= 0 && A >= t
		};
	m.each = m.forEach = function (n, t, r) {
		t = b(t, r);
		var e, u;
		if (k(n))
			for (e = 0, u = n.length; u > e; e++) t(n[e], e, n);
		else {
			var i = m.keys(n);
			for (e = 0, u = i.length; u > e; e++) t(n[i[e]], i[e], n)
		}
		return n
	}, m.map = m.collect = function (n, t, r) {
		t = x(t, r);
		for (var e = !k(n) && m.keys(n), u = (e || n).length, i = Array(u), o = 0; u > o; o++) {
			var a = e ? e[o] : o;
			i[o] = t(n[a], a, n)
		}
		return i
	}, m.reduce = m.foldl = m.inject = n(1), m.reduceRight = m.foldr = n(-1), m.find = m.detect = function (n, t, r) {
		var e;
		return e = k(n) ? m.findIndex(n, t, r) : m.findKey(n, t, r), e !== void 0 && e !== -1 ? n[e] : void 0
	}, m.filter = m.select = function (n, t, r) {
		var e = [];
		return t = x(t, r), m.each(n, function (n, r, u) {
			t(n, r, u) && e.push(n)
		}), e
	}, m.reject = function (n, t, r) {
		return m.filter(n, m.negate(x(t)), r)
	}, m.every = m.all = function (n, t, r) {
		t = x(t, r);
		for (var e = !k(n) && m.keys(n), u = (e || n).length, i = 0; u > i; i++) {
			var o = e ? e[i] : i;
			if (!t(n[o], o, n)) return !1
		}
		return !0
	}, m.some = m.any = function (n, t, r) {
		t = x(t, r);
		for (var e = !k(n) && m.keys(n), u = (e || n).length, i = 0; u > i; i++) {
			var o = e ? e[i] : i;
			if (t(n[o], o, n)) return !0
		}
		return !1
	}, m.contains = m.includes = m.include = function (n, t, r, e) {
		return k(n) || (n = m.values(n)), ("number" != typeof r || e) && (r = 0), m.indexOf(n, t, r) >= 0
	}, m.invoke = function (n, t) {
		var r = l.call(arguments, 2),
			e = m.isFunction(t);
		return m.map(n, function (n) {
			var u = e ? t : n[t];
			return null == u ? u : u.apply(n, r)
		})
	}, m.pluck = function (n, t) {
		return m.map(n, m.property(t))
	}, m.where = function (n, t) {
		return m.filter(n, m.matcher(t))
	}, m.findWhere = function (n, t) {
		return m.find(n, m.matcher(t))
	}, m.max = function (n, t, r) {
		var e, u, i = -1 / 0,
			o = -1 / 0;
		if (null == t && null != n) {
			n = k(n) ? n : m.values(n);
			for (var a = 0, c = n.length; c > a; a++) e = n[a], e > i && (i = e)
		} else t = x(t, r), m.each(n, function (n, r, e) {
			u = t(n, r, e), (u > o || u === -1 / 0 && i === -1 / 0) && (i = n, o = u)
		});
		return i
	}, m.min = function (n, t, r) {
		var e, u, i = 1 / 0,
			o = 1 / 0;
		if (null == t && null != n) {
			n = k(n) ? n : m.values(n);
			for (var a = 0, c = n.length; c > a; a++) e = n[a], i > e && (i = e)
		} else t = x(t, r), m.each(n, function (n, r, e) {
			u = t(n, r, e), (o > u || 1 / 0 === u && 1 / 0 === i) && (i = n, o = u)
		});
		return i
	}, m.shuffle = function (n) {
		for (var t, r = k(n) ? n : m.values(n), e = r.length, u = Array(e), i = 0; e > i; i++) t = m.random(0, i), t !== i && (u[i] = u[t]), u[t] = r[i];
		return u
	}, m.sample = function (n, t, r) {
		return null == t || r ? (k(n) || (n = m.values(n)), n[m.random(n.length - 1)]) : m.shuffle(n).slice(0, Math.max(0, t))
	}, m.sortBy = function (n, t, r) {
		return t = x(t, r), m.pluck(m.map(n, function (n, r, e) {
			return {
				value: n,
				index: r,
				criteria: t(n, r, e)
			}
		}).sort(function (n, t) {
			var r = n.criteria,
				e = t.criteria;
			if (r !== e) {
				if (r > e || r === void 0) return 1;
				if (e > r || e === void 0) return -1
			}
			return n.index - t.index
		}), "value")
	};
	var F = function (n) {
		return function (t, r, e) {
			var u = {};
			return r = x(r, e), m.each(t, function (e, i) {
				var o = r(e, i, t);
				n(u, e, o)
			}), u
		}
	};
	m.groupBy = F(function (n, t, r) {
		m.has(n, r) ? n[r].push(t) : n[r] = [t]
	}), m.indexBy = F(function (n, t, r) {
		n[r] = t
	}), m.countBy = F(function (n, t, r) {
		m.has(n, r) ? n[r]++ : n[r] = 1
	}), m.toArray = function (n) {
		return n ? m.isArray(n) ? l.call(n) : k(n) ? m.map(n, m.identity) : m.values(n) : []
	}, m.size = function (n) {
		return null == n ? 0 : k(n) ? n.length : m.keys(n).length
	}, m.partition = function (n, t, r) {
		t = x(t, r);
		var e = [],
			u = [];
		return m.each(n, function (n, r, i) {
			(t(n, r, i) ? e : u).push(n)
		}), [e, u]
	}, m.first = m.head = m.take = function (n, t, r) {
		return null == n ? void 0 : null == t || r ? n[0] : m.initial(n, n.length - t)
	}, m.initial = function (n, t, r) {
		return l.call(n, 0, Math.max(0, n.length - (null == t || r ? 1 : t)))
	}, m.last = function (n, t, r) {
		return null == n ? void 0 : null == t || r ? n[n.length - 1] : m.rest(n, Math.max(0, n.length - t))
	}, m.rest = m.tail = m.drop = function (n, t, r) {
		return l.call(n, null == t || r ? 1 : t)
	}, m.compact = function (n) {
		return m.filter(n, m.identity)
	};
	var S = function (n, t, r, e) {
		for (var u = [], i = 0, o = e || 0, a = O(n); a > o; o++) {
			var c = n[o];
			if (k(c) && (m.isArray(c) || m.isArguments(c))) {
				t || (c = S(c, t, r));
				var f = 0,
					l = c.length;
				for (u.length += l; l > f;) u[i++] = c[f++]
			} else r || (u[i++] = c)
		}
		return u
	};
	m.flatten = function (n, t) {
		return S(n, t, !1)
	}, m.without = function (n) {
		return m.difference(n, l.call(arguments, 1))
	}, m.uniq = m.unique = function (n, t, r, e) {
		m.isBoolean(t) || (e = r, r = t, t = !1), null != r && (r = x(r, e));
		for (var u = [], i = [], o = 0, a = O(n); a > o; o++) {
			var c = n[o],
				f = r ? r(c, o, n) : c;
			t ? (o && i === f || u.push(c), i = f) : r ? m.contains(i, f) || (i.push(f), u.push(c)) : m.contains(u, c) || u.push(c)
		}
		return u
	}, m.union = function () {
		return m.uniq(S(arguments, !0, !0))
	}, m.intersection = function (n) {
		for (var t = [], r = arguments.length, e = 0, u = O(n); u > e; e++) {
			var i = n[e];
			if (!m.contains(t, i)) {
				for (var o = 1; r > o && m.contains(arguments[o], i); o++);
				o === r && t.push(i)
			}
		}
		return t
	}, m.difference = function (n) {
		var t = S(arguments, !0, !0, 1);
		return m.filter(n, function (n) {
			return !m.contains(t, n)
		})
	}, m.zip = function () {
		return m.unzip(arguments)
	}, m.unzip = function (n) {
		for (var t = n && m.max(n, O).length || 0, r = Array(t), e = 0; t > e; e++) r[e] = m.pluck(n, e);
		return r
	}, m.object = function (n, t) {
		for (var r = {}, e = 0, u = O(n); u > e; e++) t ? r[n[e]] = t[e] : r[n[e][0]] = n[e][1];
		return r
	}, m.findIndex = t(1), m.findLastIndex = t(-1), m.sortedIndex = function (n, t, r, e) {
		r = x(r, e, 1);
		for (var u = r(t), i = 0, o = O(n); o > i;) {
			var a = Math.floor((i + o) / 2);
			r(n[a]) < u ? i = a + 1 : o = a
		}
		return i
	}, m.indexOf = r(1, m.findIndex, m.sortedIndex), m.lastIndexOf = r(-1, m.findLastIndex), m.range = function (n, t, r) {
		null == t && (t = n || 0, n = 0), r = r || 1;
		for (var e = Math.max(Math.ceil((t - n) / r), 0), u = Array(e), i = 0; e > i; i++ , n += r) u[i] = n;
		return u
	};
	var E = function (n, t, r, e, u) {
		if (!(e instanceof t)) return n.apply(r, u);
		var i = j(n.prototype),
			o = n.apply(i, u);
		return m.isObject(o) ? o : i
	};
	m.bind = function (n, t) {
		if (g && n.bind === g) return g.apply(n, l.call(arguments, 1));
		if (!m.isFunction(n)) throw new TypeError("Bind must be called on a function");
		var r = l.call(arguments, 2),
			e = function () {
				return E(n, e, t, this, r.concat(l.call(arguments)))
			};
		return e
	}, m.partial = function (n) {
		var t = l.call(arguments, 1),
			r = function () {
				for (var e = 0, u = t.length, i = Array(u), o = 0; u > o; o++) i[o] = t[o] === m ? arguments[e++] : t[o];
				for (; e < arguments.length;) i.push(arguments[e++]);
				return E(n, r, this, this, i)
			};
		return r
	}, m.bindAll = function (n) {
		var t, r, e = arguments.length;
		if (1 >= e) throw new Error("bindAll must be passed function names");
		for (t = 1; e > t; t++) r = arguments[t], n[r] = m.bind(n[r], n);
		return n
	}, m.memoize = function (n, t) {
		var r = function (e) {
			var u = r.cache,
				i = "" + (t ? t.apply(this, arguments) : e);
			return m.has(u, i) || (u[i] = n.apply(this, arguments)), u[i]
		};
		return r.cache = {}, r
	}, m.delay = function (n, t) {
		var r = l.call(arguments, 2);
		return setTimeout(function () {
			return n.apply(null, r)
		}, t)
	}, m.defer = m.partial(m.delay, m, 1), m.throttle = function (n, t, r) {
		var e, u, i, o = null,
			a = 0;
		r || (r = {});
		var c = function () {
			a = r.leading === !1 ? 0 : m.now(), o = null, i = n.apply(e, u), o || (e = u = null)
		};
		return function () {
			var f = m.now();
			a || r.leading !== !1 || (a = f);
			var l = t - (f - a);
			return e = this, u = arguments, 0 >= l || l > t ? (o && (clearTimeout(o), o = null), a = f, i = n.apply(e, u), o || (e = u = null)) : o || r.trailing === !1 || (o = setTimeout(c, l)), i
		}
	}, m.debounce = function (n, t, r) {
		var e, u, i, o, a, c = function () {
			var f = m.now() - o;
			t > f && f >= 0 ? e = setTimeout(c, t - f) : (e = null, r || (a = n.apply(i, u), e || (i = u = null)))
		};
		return function () {
			i = this, u = arguments, o = m.now();
			var f = r && !e;
			return e || (e = setTimeout(c, t)), f && (a = n.apply(i, u), i = u = null), a
		}
	}, m.wrap = function (n, t) {
		return m.partial(t, n)
	}, m.negate = function (n) {
		return function () {
			return !n.apply(this, arguments)
		}
	}, m.compose = function () {
		var n = arguments,
			t = n.length - 1;
		return function () {
			for (var r = t, e = n[t].apply(this, arguments); r--;) e = n[r].call(this, e);
			return e
		}
	}, m.after = function (n, t) {
		return function () {
			return --n < 1 ? t.apply(this, arguments) : void 0
		}
	}, m.before = function (n, t) {
		var r;
		return function () {
			return --n > 0 && (r = t.apply(this, arguments)), 1 >= n && (t = null), r
		}
	}, m.once = m.partial(m.before, 2);
	var M = !{
		toString: null
	}.propertyIsEnumerable("toString"),
		I = ["valueOf", "isPrototypeOf", "toString", "propertyIsEnumerable", "hasOwnProperty", "toLocaleString"];
	m.keys = function (n) {
		if (!m.isObject(n)) return [];
		if (v) return v(n);
		var t = [];
		for (var r in n) m.has(n, r) && t.push(r);
		return M && e(n, t), t
	}, m.allKeys = function (n) {
		if (!m.isObject(n)) return [];
		var t = [];
		for (var r in n) t.push(r);
		return M && e(n, t), t
	}, m.values = function (n) {
		for (var t = m.keys(n), r = t.length, e = Array(r), u = 0; r > u; u++) e[u] = n[t[u]];
		return e
	}, m.mapObject = function (n, t, r) {
		t = x(t, r);
		for (var e, u = m.keys(n), i = u.length, o = {}, a = 0; i > a; a++) e = u[a], o[e] = t(n[e], e, n);
		return o
	}, m.pairs = function (n) {
		for (var t = m.keys(n), r = t.length, e = Array(r), u = 0; r > u; u++) e[u] = [t[u], n[t[u]]];
		return e
	}, m.invert = function (n) {
		for (var t = {}, r = m.keys(n), e = 0, u = r.length; u > e; e++) t[n[r[e]]] = r[e];
		return t
	}, m.functions = m.methods = function (n) {
		var t = [];
		for (var r in n) m.isFunction(n[r]) && t.push(r);
		return t.sort()
	}, m.extend = _(m.allKeys), m.extendOwn = m.assign = _(m.keys), m.findKey = function (n, t, r) {
		t = x(t, r);
		for (var e, u = m.keys(n), i = 0, o = u.length; o > i; i++)
			if (e = u[i], t(n[e], e, n)) return e
	}, m.pick = function (n, t, r) {
		var e, u, i = {},
			o = n;
		if (null == o) return i;
		m.isFunction(t) ? (u = m.allKeys(o), e = b(t, r)) : (u = S(arguments, !1, !1, 1), e = function (n, t, r) {
			return t in r
		}, o = Object(o));
		for (var a = 0, c = u.length; c > a; a++) {
			var f = u[a],
				l = o[f];
			e(l, f, o) && (i[f] = l)
		}
		return i
	}, m.omit = function (n, t, r) {
		if (m.isFunction(t)) t = m.negate(t);
		else {
			var e = m.map(S(arguments, !1, !1, 1), String);
			t = function (n, t) {
				return !m.contains(e, t)
			}
		}
		return m.pick(n, t, r)
	}, m.defaults = _(m.allKeys, !0), m.create = function (n, t) {
		var r = j(n);
		return t && m.extendOwn(r, t), r
	}, m.clone = function (n) {
		return m.isObject(n) ? m.isArray(n) ? n.slice() : m.extend({}, n) : n
	}, m.tap = function (n, t) {
		return t(n), n
	}, m.isMatch = function (n, t) {
		var r = m.keys(t),
			e = r.length;
		if (null == n) return !e;
		for (var u = Object(n), i = 0; e > i; i++) {
			var o = r[i];
			if (t[o] !== u[o] || !(o in u)) return !1
		}
		return !0
	};
	var N = function (n, t, r, e) {
		if (n === t) return 0 !== n || 1 / n === 1 / t;
		if (null == n || null == t) return n === t;
		n instanceof m && (n = n._wrapped), t instanceof m && (t = t._wrapped);
		var u = s.call(n);
		if (u !== s.call(t)) return !1;
		switch (u) {
			case "[object RegExp]":
			case "[object String]":
				return "" + n == "" + t;
			case "[object Number]":
				return +n !== +n ? +t !== +t : 0 === +n ? 1 / +n === 1 / t : +n === +t;
			case "[object Date]":
			case "[object Boolean]":
				return +n === +t
		}
		var i = "[object Array]" === u;
		if (!i) {
			if ("object" != typeof n || "object" != typeof t) return !1;
			var o = n.constructor,
				a = t.constructor;
			if (o !== a && !(m.isFunction(o) && o instanceof o && m.isFunction(a) && a instanceof a) && "constructor" in n && "constructor" in t) return !1
		}
		r = r || [], e = e || [];
		for (var c = r.length; c--;)
			if (r[c] === n) return e[c] === t;
		if (r.push(n), e.push(t), i) {
			if (c = n.length, c !== t.length) return !1;
			for (; c--;)
				if (!N(n[c], t[c], r, e)) return !1
		} else {
			var f, l = m.keys(n);
			if (c = l.length, m.keys(t).length !== c) return !1;
			for (; c--;)
				if (f = l[c], !m.has(t, f) || !N(n[f], t[f], r, e)) return !1
		}
		return r.pop(), e.pop(), !0
	};
	m.isEqual = function (n, t) {
		return N(n, t)
	}, m.isEmpty = function (n) {
		return null == n ? !0 : k(n) && (m.isArray(n) || m.isString(n) || m.isArguments(n)) ? 0 === n.length : 0 === m.keys(n).length
	}, m.isElement = function (n) {
		return !(!n || 1 !== n.nodeType)
	}, m.isArray = h || function (n) {
		return "[object Array]" === s.call(n)
	}, m.isObject = function (n) {
		var t = typeof n;
		return "function" === t || "object" === t && !!n
	}, m.each(["Arguments", "Function", "String", "Number", "Date", "RegExp", "Error"], function (n) {
		m["is" + n] = function (t) {
			return s.call(t) === "[object " + n + "]"
		}
	}), m.isArguments(arguments) || (m.isArguments = function (n) {
		return m.has(n, "callee")
	}), "function" != typeof /./ && "object" != typeof Int8Array && (m.isFunction = function (n) {
		return "function" == typeof n || !1
	}), m.isFinite = function (n) {
		return isFinite(n) && !isNaN(parseFloat(n))
	}, m.isNaN = function (n) {
		return m.isNumber(n) && n !== +n
	}, m.isBoolean = function (n) {
		return n === !0 || n === !1 || "[object Boolean]" === s.call(n)
	}, m.isNull = function (n) {
		return null === n
	}, m.isUndefined = function (n) {
		return n === void 0
	}, m.has = function (n, t) {
		return null != n && p.call(n, t)
	}, m.noConflict = function () {
		return u._ = i, this
	}, m.identity = function (n) {
		return n
	}, m.constant = function (n) {
		return function () {
			return n
		}
	}, m.noop = function () { }, m.property = w, m.propertyOf = function (n) {
		return null == n ? function () { } : function (t) {
			return n[t]
		}
	}, m.matcher = m.matches = function (n) {
		return n = m.extendOwn({}, n),
			function (t) {
				return m.isMatch(t, n)
			}
	}, m.times = function (n, t, r) {
		var e = Array(Math.max(0, n));
		t = b(t, r, 1);
		for (var u = 0; n > u; u++) e[u] = t(u);
		return e
	}, m.random = function (n, t) {
		return null == t && (t = n, n = 0), n + Math.floor(Math.random() * (t - n + 1))
	}, m.now = Date.now || function () {
		return (new Date).getTime()
	};
	var B = {
		"&": "&amp;",
		"<": "&lt;",
		">": "&gt;",
		'"': "&quot;",
		"'": "&#x27;",
		"`": "&#x60;"
	},
		T = m.invert(B),
		R = function (n) {
			var t = function (t) {
				return n[t]
			},
				r = "(?:" + m.keys(n).join("|") + ")",
				e = RegExp(r),
				u = RegExp(r, "g");
			return function (n) {
				return n = null == n ? "" : "" + n, e.test(n) ? n.replace(u, t) : n
			}
		};
	m.escape = R(B), m.unescape = R(T), m.result = function (n, t, r) {
		var e = null == n ? void 0 : n[t];
		return e === void 0 && (e = r), m.isFunction(e) ? e.call(n) : e
	};
	var q = 0;
	m.uniqueId = function (n) {
		var t = ++q + "";
		return n ? n + t : t
	}, m.templateSettings = {
		evaluate: /<%([\s\S]+?)%>/g,
		interpolate: /<%=([\s\S]+?)%>/g,
		escape: /<%-([\s\S]+?)%>/g
	};
	var K = /(.)^/,
		z = {
			"'": "'",
			"\\": "\\",
			"\r": "r",
			"\n": "n",
			"\u2028": "u2028",
			"\u2029": "u2029"
		},
		D = /\\|'|\r|\n|\u2028|\u2029/g,
		L = function (n) {
			return "\\" + z[n]
		};
	m.template = function (n, t, r) {
		!t && r && (t = r), t = m.defaults({}, t, m.templateSettings);
		var e = RegExp([(t.escape || K).source, (t.interpolate || K).source, (t.evaluate || K).source].join("|") + "|$", "g"),
			u = 0,
			i = "__p+='";
		n.replace(e, function (t, r, e, o, a) {
			return i += n.slice(u, a).replace(D, L), u = a + t.length, r ? i += "'+\n((__t=(" + r + "))==null?'':_.escape(__t))+\n'" : e ? i += "'+\n((__t=(" + e + "))==null?'':__t)+\n'" : o && (i += "';\n" + o + "\n__p+='"), t
		}), i += "';\n", t.variable || (i = "with(obj||{}){\n" + i + "}\n"), i = "var __t,__p='',__j=Array.prototype.join," + "print=function(){__p+=__j.call(arguments,'');};\n" + i + "return __p;\n";
		try {
			var o = new Function(t.variable || "obj", "_", i)
		} catch (a) {
			throw a.source = i, a
		}
		var c = function (n) {
			return o.call(this, n, m)
		},
			f = t.variable || "obj";
		return c.source = "function(" + f + "){\n" + i + "}", c
	}, m.chain = function (n) {
		var t = m(n);
		return t._chain = !0, t
	};
	var P = function (n, t) {
		return n._chain ? m(t).chain() : t
	};
	m.mixin = function (n) {
		m.each(m.functions(n), function (t) {
			var r = m[t] = n[t];
			m.prototype[t] = function () {
				var n = [this._wrapped];
				return f.apply(n, arguments), P(this, r.apply(m, n))
			}
		})
	}, m.mixin(m), m.each(["pop", "push", "reverse", "shift", "sort", "splice", "unshift"], function (n) {
		var t = o[n];
		m.prototype[n] = function () {
			var r = this._wrapped;
			return t.apply(r, arguments), "shift" !== n && "splice" !== n || 0 !== r.length || delete r[0], P(this, r)
		}
	}), m.each(["concat", "join", "slice"], function (n) {
		var t = o[n];
		m.prototype[n] = function () {
			return P(this, t.apply(this._wrapped, arguments))
		}
	}), m.prototype.value = function () {
		return this._wrapped
	}, m.prototype.valueOf = m.prototype.toJSON = m.prototype.value, m.prototype.toString = function () {
		return "" + this._wrapped
	}, "function" == typeof define && define.amd && define("underscore", [], function () {
		return m
	})
}).call(this);
window.onscroll = function () {
	scrollFunction()
};

function scrollFunction() {
	if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		document.getElementById("botonTopInicio").style.display = "block";
	} else {
		document.getElementById("botonTopInicio").style.display = "none";
	}
}

function topFunction() {
	$('html, body').animate({
		scrollTop: 0
	}, 300);
}
$(document).on('click', '#botonTopInicio', function () {
	topFunction();
});
//INICIO ELEMENTOS ESPECIALES

//COMPONENTES
function selectorSuperior(selector) {
	try {
		nodoPrevio = selector.prev().prev().prevObject[0].nodeName
	}
	catch (error) {
		return selector
	}
	if (nodoPrevio.startsWith("H")) {
		return selector.prev()
	}
	if (selector.prev().prev().length == 0) {
		return selector.prev()
	}
	return selector.prev().prev()	
}
$('.componenteSabiasQue').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteSabiasQueFlotante componenteIzquierda"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/sabiasQue.png" alt="Sabías que:" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/sabiasQue.png" alt="Sabías que" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>Sabías que</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
$('.componenteRecuerda').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteRecuerdaFlotante componenteIzquierda"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/recuerda.png" alt="Recuerda:" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/recuerda.png" alt="Recuerda" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>Recuerda</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
$('.componenteABC').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteABCFlotante componenteIzquierda"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/abc.png" alt="A, B, C..." class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/abc.png" alt="A, B, C..." class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>A, B, C...</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
$('.componenteLlegaMasLejos').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteLlegaMasLejosFlotante componenteIzquierda"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/llegaMasLejos.png" alt="Llega más lejos" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/llegaMasLejos.png" alt="Llega más lejos" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>Llega más lejos</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
$('.componentePlay').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componentePlayFlotante componenteIzquierda"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/play.png" alt="Play" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/play.png" alt="Play" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>Play</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
$('.componenteEnLaOnda').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteEnLaOndaFlotante componenteIzquierda"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/enLaOnda.png" alt="En la onda" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/enLaOnda.png" alt="En la onda" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>En la onda</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
$('.componenteTwitter').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteTwitterFlotante componenteDerecha"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/twitter.png" alt="Twitter" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/twitter.png" alt="Twitter" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>Twitter</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
$('.componenteILikeIt').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteILikeItFlotante componenteDerecha"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/iLikeIt.png" alt="I like it" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/iLikeIt.png" alt="I Like it" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>I like it</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
$('.componenteNota').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteNotaFlotante componenteDerecha"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/nota.png" alt="Nota" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/nota.png" alt="Nota" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>Nota</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
$('.componenteViaja').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteViajaFlotante componenteDerecha"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/viaja.png" alt="Viaja" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/viaja.png" alt="Viaja" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>Viaja</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
$('.componenteConocesA').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteConocesAFlotante componenteDerecha"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/conocesA.png" alt="Conoces a..." class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/conocesA.png" alt="Conoces a..." class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>Conoces a...</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
$('.componenteQuienDijo').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	comprobarImagen = $(this).find('td:last').find('img').length;
	if (comprobarImagen > 0) {
		cadenaAzar = Math.random().toString(36).substring(7)
		altoImagen = $(this).find('td:last').find('img').outerHeight();
		$(this).after('<div class="envoltorioComponenteFlotante componenteQuienDijoFlotante componenteDerecha"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/quienDijo.png" alt="¿Quién dijo?" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/quienDijo.png" alt="¿Quién dijo?" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>¿Quién dijo?</strong></div></p>' + recuperarContenido + '</div>')
		direccionImagen = $('#modalComponente' + cadenaAzar + '').find('img').not(':first').attr('src')
		$('#modalComponente' + cadenaAzar + '').find('img').not(':first').addClass('imagenRealComponenteQuienDijo')
		$('#modalComponente' + cadenaAzar + '').find('.imagenRealComponenteQuienDijo').before('<img class="imagenQuienDijoAnonimo" src="imagenes/componentes/quienDijoDesconocido.png" alt="Pulsa en esta imagen para descubrir la imagen del autor de la cita" title="¿Quién dijo?" style="height:' + altoImagen + 'px;min-height:90px !important;cursor:pointer;margin:0 auto;display:block;"><p class="PieRecurso eliminarPieRecurso">&nbsp;</p>');
		$('#modalComponente' + cadenaAzar + '').find('.imagenRealComponenteQuienDijo').parent().nextAll().hide();
		$('#modalComponente' + cadenaAzar + '').find('.imagenRealComponenteQuienDijo').hide();
		$('#modalComponente' + cadenaAzar + '').find('.imagenQuienDijoAnonimo').click(function () {
			$(this).fadeOut('slow', function () {
				$('#modalComponente' + cadenaAzar + '').find('.eliminarPieRecurso').hide();
				$('#modalComponente' + cadenaAzar + '').find('*').not('.imagenQuienDijoAnonimo').not('.eliminarPieRecurso').show();
			});
		});
		$(this).remove()
	} else {
		cadenaAzar = Math.random().toString(36).substring(7)
		selectorIncorporarComponente = selectorSuperior($(this))
		selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteQuienDijoFlotante componenteDerecha"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/quienDijo.png" alt="¿Quién dijo?" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/quienDijo.png" alt="¿Quién dijo?" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>¿Quién dijo?</strong></div></p>' + recuperarContenido + '</div>')
		$(this).remove()
	}
});
$('.componenteEmotion').each(function () {
	recuperarContenido = $(this).find('td:last').html();
	cadenaAzar = Math.random().toString(36).substring(7)
	selectorIncorporarComponente = selectorSuperior($(this))
	selectorIncorporarComponente.after('<div class="envoltorioComponenteFlotante componenteEmotionFlotante componenteDerecha"><a class="modal-trigger" href="#modalComponente' + cadenaAzar + '"><img src="imagenes/componentes/emotion.png" alt="e.moti.on" class="imagenComponenteFlotante"></a></div><div id="modalComponente' + cadenaAzar + '" class="modal modalComponente"><div class="valign-wrapper"><img src="imagenes/componentes/emotion.png" alt="e.moti.on" class="imagenComponenteFlotante"><span style="margin-left:10px;"><strong>e.moti.on</strong></div></p>' + recuperarContenido + '</div>')
	$(this).remove()
});
//DESTACADO palabra especial --> tablaDestacado
$('table').each(function () {
	existenciaPalabraClave = $(this).find('caption').text();
	if (existenciaPalabraClave === 'tablaDestacado') {
		recogerContenidoDestacado = $(this).find('td:first').html()
		$(this).after('<div class="contenidoDestacado" style="clear:both;">' + recogerContenidoDestacado + ' </div>');
		$(this).remove();
	}
});
//IMPORTANTE palabra especial --> tablaImportante
$('table').each(function () {
	existenciaPalabraClave = $(this).find('caption').text();
	if (existenciaPalabraClave === 'tablaImportante') {
		recogerContenidoDestacado = $(this).find('td:first').html()
		$(this).after('<div class="contenidoImportante" style="clear:both;">' + recogerContenidoDestacado + ' </div>');
		$(this).remove();
	}
});
// TEXTO EN COLUMNAS palabrea especial --> textoColumnas
$('table').each(function () {
	existenciaPalabraClave = $(this).find('caption:first').text();
	contenidoInsertar = ''
	if (existenciaPalabraClave === "textoColumnas") {
		numeroColumnas = $(this).find('td').length
		if (numeroColumnas == 2) {
			$(this).find('td').each(function () {
				recogerContenido = $(this).html();
				contenidoInsertar += '<div class="col s12 l6">' + recogerContenido + '</div>'
			});
		} else if (numeroColumnas == 3) {
			$(this).find('td').each(function () {
				recogerContenido = $(this).html();
				contenidoInsertar += '<div class="col s12 l4">' + recogerContenido + '</div>'
			});
		} else if (numeroColumnas == 4) {
			$(this).find('td').each(function () {
				recogerContenido = $(this).html();
				contenidoInsertar += '<div class="col s12 l3">' + recogerContenido + '</div>'
			});
		} else {
			return;
		}
		contenidoInsertarDefinitivo = '<div class="row">' + contenidoInsertar + '</div>'
		$(this).after(contenidoInsertarDefinitivo)
		$(this).remove()
	}
});
//ACORDEON palabra especial --> tablaAcordeon && tablaRecursosBibliograficos
$('table').each(function () {
	existenciaPalabraClave = $(this).find('caption:first').text();
	if ((existenciaPalabraClave === "tablaAcordeon") || (existenciaPalabraClave === "tablaRecursosBibliograficos")) {
		contenidoCompletoAcordeon = ''
		//$(this).find('tr:even').each(function() {
		$(this).children().children('tr:even').each(function () {
			recogerContenidoPanel = $(this).find('td').html();
			recogerContenidoCuerpo = $(this).next('tr').find('td').html()
			if (recogerContenidoCuerpo == null) {
				recogerContenidoCuerpo = $(this).parents('table').find('tbody:first').find('tr:first').find('td:first').html()
			}
			contenidoParcialAcordeon = '<li> <div class="collapsible-header">' + recogerContenidoPanel + '</div> <div class="collapsible-body">' + recogerContenidoCuerpo + '</div> </li>'
			contenidoCompletoAcordeon += contenidoParcialAcordeon
		});
		contenidoDefinitivoAcordeon = '<div style="clear:both;"></div><div class="envoltorioAcordeon"><p class="abrirAcordeonCompleto" style="text-align:right;"><i class="material-icons" style="cursor:pointer;">swap_vert</i></p><ul class="collapsible" data-collapsible="accordion">' + contenidoCompletoAcordeon + '</ul></div>'
		$(this).after(contenidoDefinitivoAcordeon)
		$(this).remove()
	}
});
// TABLA CODIGO FUENTE --> palabra clave: codigoFuente
$('table').each(function () {
	buscarCaption = $(this).find('caption').text()
	if (buscarCaption == 'codigoFuente') {
		obtenerHTML = $(this).find('td').html()
		$(this).after('<pre><code>' + obtenerHTML + '</code></pre>');
		$(this).remove();
	}
});
// ICONOS FIGURA, TABLA, VÍDEO
$('.PieRecurso').each(function () {
	$(this).filter(function () {
		return $(this).text().substring(0, 6) === "Figura"
	}).prepend('<img class="iconoPie" alt="Icono Figura" src="imagenes/iconoFigura.png">');
	$(this).filter(function () {
		return $(this).text().substring(0, 5) === "Vídeo"
	}).prepend('<img class="iconoPie" alt="Icono Figura" src="imagenes/iconoVideo.png">');
	$(this).filter(function () {
		return $(this).text().substring(0, 5) === "Tabla"
	}).prepend('<img class="iconoPie" alt="Icono Figura" src="imagenes/iconoTabla.png">');
});
// HACK ENLACES SUBRAYADOS EN WORD
//$('a').find('span.underline').removeAttr('class');
//FIN ELEMENTOS ESPECIALES
$(document).ready(function () {
	//INICIO ANOTACIONES
	$('#incluirAnotacion').click(function (e) {
		e.preventDefault();
		if (sessionStorage.getItem('controlAnotaciones') === 'anotaciones') {
			sessionStorage.setItem('controlAnotaciones', 'anulado')
			$('#incluirSubrayado').removeClass('amarillo');
			if ($(this).hasClass('amarillo') === true) {
				$(this).removeClass('amarillo')
			} else {
				$(this).addClass('amarillo');
			}
		} else {
			sessionStorage.setItem('controlAnotaciones', 'anotaciones')
			$('#incluirSubrayado').removeClass('amarillo');
			if ($(this).hasClass('amarillo') === true) {
				$(this).removeClass('amarillo')
			} else {
				$(this).addClass('amarillo');
			}
		}
	});
	$('#incluirSubrayado').click(function (e) {
		e.preventDefault();
		if (sessionStorage.getItem('controlAnotaciones') === 'subrayado') {
			sessionStorage.setItem('controlAnotaciones', 'anulado')
			$('#incluirAnotacion').removeClass('amarillo');
			if ($(this).hasClass('amarillo') === true) {
				$(this).removeClass('amarillo')
			} else {
				$(this).addClass('amarillo');
			}
		} else {
			sessionStorage.setItem('controlAnotaciones', 'subrayado')
			$('#incluirAnotacion').removeClass('amarillo');
			if ($(this).hasClass('amarillo') === true) {
				$(this).removeClass('amarillo')
			} else {
				$(this).addClass('amarillo');
			}
		}
	});
	if (sessionStorage.getItem('controlAnotaciones') === 'anotaciones') {
		$('#incluirAnotacion').addClass('amarillo');
	}
	if (sessionStorage.getItem('controlAnotaciones') === 'subrayado') {
		$('#incluirSubrayado').addClass('amarillo');
	}
	//EVENTLISTENER
	$(document).on('mouseup touchend', function () {
		if ((permitirAnotaciones === true) && (sessionStorage.getItem('controlAnotaciones') === 'anotaciones')) {
			var controlVisualizacion = $('.annotator-touch-hide').length
			if (controlVisualizacion > 0) { } else {
				$('.annotator-focus').trigger("tap");
			}
		} else if ((permitirAnotaciones === true) && (sessionStorage.getItem('controlAnotaciones') === 'subrayado')) {
			forzarSubrayado = true;
			$('.annotator-focus').trigger("tap");
			$('#annotator-field-0').val('Subrayado');
			$('.annotator-save').click()
			forzarSubrayado = false;
		}
		//TRANSFORMAR EN ANOTACION
		$('.forzarSubrayado').click(function () {
			$('.annotator-item').each(function () {
				recuperoContenido = $(this).find('div').text()
				if (recuperoContenido === 'Subrayado') {
					$(this).find('.annotator-edit:first').empty().append('<i class="material-icons">swap_horiz</i>')
					$(this).find('.annotator-edit:first').attr('title', 'Transformar en anotación')
				}
			});
		});
	});
	//EXPORTAR ANOTACIONES
	/*! @source http://purl.eligrey.com/github/FileSaver.js/blob/master/FileSaver.js */
	var saveAs = saveAs || function (e) {
		"use strict";
		if (typeof e === "undefined" || typeof navigator !== "undefined" && /MSIE [0-9]\./.test(navigator.userAgent)) {
			return
		}
		var t = e.document,
			n = function () {
				return e.URL || e.webkitURL || e
			},
			r = t.createElementNS("http://www.w3.org/1999/xhtml", "a"),
			o = "download" in r,
			a = function (e) {
				var t = new MouseEvent("click");
				e.dispatchEvent(t)
			},
			i = /constructor/i.test(e.HTMLElement) || e.safari,
			f = /CriOS\/[\d]+/.test(navigator.userAgent),
			u = function (t) {
				(e.setImmediate || e.setTimeout)(function () {
					throw t
				}, 0)
			},
			s = "application/octet-stream",
			d = 1e3 * 40,
			c = function (e) {
				var t = function () {
					if (typeof e === "string") {
						n().revokeObjectURL(e)
					} else {
						e.remove()
					}
				};
				setTimeout(t, d)
			},
			l = function (e, t, n) {
				t = [].concat(t);
				var r = t.length;
				while (r--) {
					var o = e["on" + t[r]];
					if (typeof o === "function") {
						try {
							o.call(e, n || e)
						} catch (a) {
							u(a)
						}
					}
				}
			},
			p = function (e) {
				if (/^\s*(?:text\/\S*|application\/xml|\S*\/\S*\+xml)\s*;.*charset\s*=\s*utf-8/i.test(e.type)) {
					return new Blob([String.fromCharCode(65279), e], {
						type: e.type
					})
				}
				return e
			},
			v = function (t, u, d) {
				if (!d) {
					t = p(t)
				}
				var v = this,
					w = t.type,
					m = w === s,
					y, h = function () {
						l(v, "writestart progress write writeend".split(" "))
					},
					S = function () {
						if ((f || m && i) && e.FileReader) {
							var r = new FileReader;
							r.onloadend = function () {
								var t = f ? r.result : r.result.replace(/^data:[^;]*;/, "data:attachment/file;");
								var n = e.open(t, "_blank");
								if (!n) e.location.href = t;
								t = undefined;
								v.readyState = v.DONE;
								h()
							};
							r.readAsDataURL(t);
							v.readyState = v.INIT;
							return
						}
						if (!y) {
							y = n().createObjectURL(t)
						}
						if (m) {
							e.location.href = y
						} else {
							var o = e.open(y, "_blank");
							if (!o) {
								e.location.href = y
							}
						}
						v.readyState = v.DONE;
						h();
						c(y)
					};
				v.readyState = v.INIT;
				if (o) {
					y = n().createObjectURL(t);
					setTimeout(function () {
						r.href = y;
						r.download = u;
						a(r);
						h();
						c(y);
						v.readyState = v.DONE
					});
					return
				}
				S()
			},
			w = v.prototype,
			m = function (e, t, n) {
				return new v(e, t || e.name || "download", n)
			};
		if (typeof navigator !== "undefined" && navigator.msSaveOrOpenBlob) {
			return function (e, t, n) {
				t = t || e.name || "download";
				if (!n) {
					e = p(e)
				}
				return navigator.msSaveOrOpenBlob(e, t)
			}
		}
		w.abort = function () { };
		w.readyState = w.INIT = 0;
		w.WRITING = 1;
		w.DONE = 2;
		w.error = w.onwritestart = w.onprogress = w.onwrite = w.onabort = w.onerror = w.onwriteend = null;
		return m
	}(typeof self !== "undefined" && self || typeof window !== "undefined" && window || this.content);
	if (typeof module !== "undefined" && module.exports) {
		module.exports.saveAs = saveAs
	} else if (typeof define !== "undefined" && define !== null && define.amd !== null) {
		define("FileSaver.js", function () {
			return saveAs
		})
	}

	function exportarAnotaciones() {
		var longitudLocalStorage = localStorage.length;
		arrayLocalStorage = []
		for (i = 0; i < longitudLocalStorage; i++) {
			var recogerClave = localStorage.key(i);
			var regexIdentificadorAnotacion = /annotator\.offline\/annotation/;
			var buscarCoincidencia = regexIdentificadorAnotacion.test(recogerClave);
			if (buscarCoincidencia === true) {
				var obtenerClave = recogerClave;
				var obtenerValor = localStorage.getItem(recogerClave);
				var unirClaveValor = obtenerClave + obtenerValor;
				arrayLocalStorage.push({
					"clave": obtenerClave,
					"valor": obtenerValor
				});
			}
		}
		prepararJSON = JSON.stringify(arrayLocalStorage);
		var blob = new Blob([prepararJSON], {
			type: "text/plain;charset=utf-8"
		});
		saveAs(blob, "anotacionesUI1.txt");
	}
	$('#exportarAnotaciones').click(function () {
		exportarAnotaciones();
	});
	//IMPORTAR ANOTACIONES
	function manejarArchivos(evento) {
		var input = evento.target;
		var lecturaArchivo = new FileReader();
		lecturaArchivo.onload = function () {
			var textoBruto = lecturaArchivo.result;
			var textoJSON = JSON.parse(textoBruto);
			var longitudArray = textoJSON.length;
			for (i = 0; i < longitudArray; i++) {
				recogerClave = textoJSON[i].clave;
				recogerValor = textoJSON[i].valor;
				localStorage.setItem(recogerClave, recogerValor)
			}
		};
		lecturaArchivo.readAsText(input.files[0]);
		alert("Operación realizada. Automáticamente se actualizará la página para aplicar los cambios")
		window.location.reload(true)
	}
	$('#importarAnotaciones').click(function () {
		importarAnotaciones();
	});

	function importarAnotaciones() {
		var el = document.getElementById("files");
		if (el) {
			el.click();
		}
	}
	document.getElementById('files').addEventListener('change', manejarArchivos, false);
	// FIN ANOTACIONES	
	// INICIO FONT RESIZER Y CONTRAST
	/*!
	 *   Accessibility Buttons v3.1.2
	 *   http://tiagoporto.github.io/accessibility-buttons
	 *   Copyright (c) 2014-2017 Tiago Porto (http://tiagoporto.com)
	 *   Released under the MIT license
	 */
	/**
	 * accessibilityButtons
	 * @param  {Array}  -
	 * @return
	 */
	/* exported accessibilityButtons */
	var accessibilityButtons = function accessibilityButtons(options) {
		'use strict';
		/**
		 * hasClass
		 * @param  {string}  element - DOM element
		 * @param  {string}  clazz   - Class Name
		 * @return {Boolean}
		 */
		function hasClass(element, clazz) {
			return (' ' + element.className + ' ').indexOf(' ' + clazz + ' ') > -1;
		}
		var setting = {
			font: {
				nameButtonIncrease: '<i class="material-icons">format_size</i></i>',
				ariaLabelButtonIncrease: 'Tamaño tipografía',
				nameButtonDecrease: '<i class="material-icons">format_size</i></a>',
				ariaLabelButtonDecrease: 'Tamaño tipografía'
			},
			contrast: {
				nameButtonAdd: '<i class="material-icons">invert_colors</i>',
				ariaLabelButtonAdd: 'Contraste',
				nameButtonRemove: '<i class="material-icons">invert_colors</i>',
				ariaLabelButtonRemove: 'Contraste'
			}
		};
		// Set buttons name and aria label
		if (options) {
			for (var key in options) {
				if (options.hasOwnProperty(key)) {
					var obj = options[key];
					for (var prop in obj) {
						if (obj.hasOwnProperty(prop)) {
							setting[key][prop] = obj[prop];
						}
					}
				}
			}
		}
		var $body = document.body,
			$fontButton = document.getElementById('accessibility-font'),
			$contrastButton = document.getElementById('accessibility-contrast'),
			$accessibilityButtons = document.getElementsByClassName('js-acessibility'),
			storageFont = localStorage.accessibility_font,
			storageContrast = localStorage.accessibility_contrast;
		// Check if exist storage and set the correct button names and aria attributes
		if (storageFont && $fontButton) {
			$body.classList.add('accessibility-font');
			$fontButton.innerHTML = setting.font.nameButtonDecrease;
			$fontButton.setAttribute('aria-label', setting.font.ariaLabelButtonDecrease);
		} else if ($fontButton) {
			$fontButton.innerHTML = setting.font.nameButtonIncrease;
			$fontButton.setAttribute('aria-label', setting.font.ariaLabelButtonIncrease);
		}
		if (storageContrast && $contrastButton) {
			$body.classList.add('accessibility-contrast');
			$contrastButton.innerHTML = setting.contrast.nameButtonRemove;
			$contrastButton.setAttribute('aria-label', setting.contrast.ariaLabelButtonRemove);
		} else if ($contrastButton) {
			$contrastButton.innerHTML = setting.contrast.nameButtonAdd;
			$contrastButton.setAttribute('aria-label', setting.contrast.ariaLabelButtonAdd);
		}
		/**
		 * Get the click event
		 * Rename the buttons
		 * Apply/Remove Contrast or Font Size
		 * Manage storage
		 */
		function accessibility() {
			return function () {
				var $this = this;
				if (hasClass($body, $this.getAttribute('id'))) {
					$body.classList.remove($this.getAttribute('id'));
					if ($this.getAttribute('id') === 'accessibility-font') {
						$this.innerHTML = setting.font.nameButtonIncrease;
						$this.setAttribute('aria-label', setting.font.ariaLabelButtonIncrease);
						localStorage.removeItem('accessibility_font');
					} else {
						$this.innerHTML = setting.contrast.nameButtonAdd;
						$this.setAttribute('aria-label', setting.contrast.ariaLabelButtonAdd);
						localStorage.removeItem('accessibility_contrast');
					}
				} else {
					$body.classList.add($this.getAttribute('id'));
					if ($this.getAttribute('id') === 'accessibility-font') {
						if (!storageFont) {
							localStorage.setItem('accessibility_font', true);
						}
						$this.innerHTML = setting.font.nameButtonDecrease;
						$this.setAttribute('aria-label', setting.font.ariaLabelButtonDecrease);
					} else {
						if (!storageContrast) {
							localStorage.setItem('accessibility_contrast', true);
						}
						$this.innerHTML = setting.contrast.nameButtonRemove;
						$this.setAttribute('aria-label', setting.contrast.ariaLabelButtonRemove);
					}
				}
			};
		}
		// Listening Click Event
		for (var i = 0; i < $accessibilityButtons.length; i++) {
			$accessibilityButtons[i].addEventListener('click', accessibility());
		}
	};
	accessibilityButtons();
	// FIN FONT RESIZER Y CONTRASTE
	// INICIO MENÚ CON JAVASCRIPT 
	//$('#menuConJavaScript').addClass('navbar-fixed').show();
	$('#menuConJavaScript').addClass('navbar-fixed').show();
	$('#menuLateralIzquierda').show();
	$('#menuSinJavaScript').hide();
	// FIN MENÚ CON JAVASCRIPT 
	// INICIO MENÚS CON CLASE ACTIVE
	recogerURL = window.location.href
	regexNumeroURL = /.*\//g
	aplicarRegex = recogerURL.split(regexNumeroURL);
	nombrePagina = aplicarRegex[1];
	$('.side-nav').find('a[href="' + nombrePagina + '"]').parent().addClass('active')
	$('.menuEscritorio').find('a[href="' + nombrePagina + '"]').parent().addClass('active')
	// FIN MENÚ CON CLASE ACTIVE
	// INICIO MENÚ ESCRITORIO y MÓVIL	
	if (localStorage.getItem("preferenciaVistaMovil") === "preferenciaVistaMovil") {
		$('.vistaEscritorio').show();
		$('.disparadorMenuConJavaScript').show();
		$('.espacioMenuEscritorio').hide();
		$('.espacioContenido').removeClass('l9').addClass('l12')
	} else {
		$('.vistaMovil').show();
		$('.disparadorMenuConJavaScript').hide();
	}
	$('.vistaMovil').click(function () {
		localStorage.setItem('preferenciaVistaMovil', 'preferenciaVistaMovil');
		$('.vistaMovil').hide();
		$('.vistaEscritorio').show();
		$('.disparadorMenuConJavaScript').show();
		$('.espacioMenuEscritorio').hide();
		$('.espacioContenido').removeClass('l9').addClass('l12')
	});
	$('.vistaEscritorio').click(function () {
		localStorage.removeItem('preferenciaVistaMovil');
		$('.vistaMovil').show();
		$('.vistaEscritorio').hide();
		$('.disparadorMenuConJavaScript').hide();
		$('.espacioMenuEscritorio').show();
		$('.espacioContenido').removeClass('l12').addClass('l9')
	});
	//FIN MENU ESCRITORIO Y MÓVIL	
	// INICIO IMÁGENES: MATERIAL BOX, TÍTULOS Y ATRIBUTOS
	$('.espacioContenido').find('img').each(function () {
		// WORD 365 solo descripción
		comprobarAlt = $(this).attr('alt');
		regexAlt365 = /[t|T].tulo:(.*)?[d|D]escripci.n:(.*)/g
		comprobarRegexAlt365 = regexAlt365.test(comprobarAlt)
		if (comprobarRegexAlt365 === true) {
			obtenerTitulo365 = comprobarAlt.replace(regexAlt365, '$1')
			obtenerAlt365 = comprobarAlt.replace(regexAlt365, '$2')
			$(this).attr('alt', obtenerAlt365).attr('title', obtenerTitulo365)
		}
		recogerTitle = $(this).attr('title');
		if (recogerTitle == undefined || recogerTitle.length < 2) {
			recogerAlt = $(this).attr('alt');
			if (recogerAlt == undefined || recogerAlt.length < 2) {
				recogerSRC = $(this).attr('src');
				$(this).attr('title', 'Figura')
				$(this).attr('alt', 'Figura')
			} else {
				$(this).attr('title', recogerAlt)
			}
		}
		recogerTitleActualizado = $(this).attr('title');
		$(this).attr('data-caption', recogerTitleActualizado);
	});
	// FIN IMÁGENES: MATERIAL BOX, TÍTULOS Y ATRIBUTOS
	// INICIO APARIENCIA	
	// Elementos con negrita (.negrita), subrayado (.subrayado) y cursiva (.cursiva) reciben clases y eliminan atributo
	$('.espacioContenido').find('*').each(function () {
		if ($(this).css('font-weight') == '700') {
			$(this).addClass('negrita');
		}
	});
	$('.espacioContenido').find('*').each(function () {
		if ($(this).css('font-weight') == '900') {
			$(this).addClass('negrita');
		}
	});
	$('.espacioContenido').find('*').each(function () {
		if ($(this).css('text-decoration').substring(0, 9) == 'underline') {
			$(this).addClass('subrayado');
		}
	});
	$('.espacioContenido').find('*').each(function () {
		if ($(this).css('font-style') == 'italic') {
			$(this).addClass('cursiva');
		}
	});
	// EMBEBER VÍDEOS YOUTUBE: https://www.youtu.be/CODIGOID embebe,
	embeberVideosYoutube('espacioContenido')
	// INCRUSTAR HTML
	$('.espacioContenido').find('img').each(function () {
		recogerDescripcionIncrustarHTML = $(this).attr('alt');
		if (recogerDescripcionIncrustarHTML == undefined) {
			return
		} else {
			longitudRecogerDescripcionIncrustarHTML = recogerDescripcionIncrustarHTML.length
			if (longitudRecogerDescripcionIncrustarHTML > 14) {
				primerasLetrasRecogerDescripcion = recogerDescripcionIncrustarHTML.substring(0, 13)
				if (primerasLetrasRecogerDescripcion === 'incrustarHTML') {
					longitudRecogerDescripcionIncrustarHTML = recogerDescripcionIncrustarHTML.length
					obtenerCodigoIncrustarHTML = recogerDescripcionIncrustarHTML.substring(13, longitudRecogerDescripcionIncrustarHTML)
					$(this).before(obtenerCodigoIncrustarHTML)
					$(this).remove()
				}
			}
		}
	});
	// Comenzar todas las páginas con H1
	recogerTextoEncabezado = $('.espacioContenido').find(':header:first').html()
	$('.espacioContenido').find(':header:first').addClass('encabezadoEliminar')
	$('.encabezadoEliminar').after('<h1>' + recogerTextoEncabezado + '</h1>');
	$('.encabezadoEliminar').remove();
	// TABLAS CLASES
	//$('table').addClass('responsive-table');
	//IMÁGENES
	$('.espacioContenido').find('img').not('.imagenComponenteFlotante').not('.iconoPie').not('.imagenQuienDijoAnonimo').not('.imagenRealComponenteQuienDijo').not('.imagenEnLinea').addClass('materialboxed').addClass('responsive-img').addClass('imagenContenido')
	// Tamaño imagen
	$('.imagenContenido').each(function () {
		recogerWidthImagenContenido = $(this).width();
		recogerTitle = $(this).attr('title');
		recogerAlt = $(this).attr('alt');
		regexMapaConceptual = /.*mapa.*/i;
		comprobarRegexTitle = regexMapaConceptual.test(recogerTitle);
		comprobarRegexAlt = regexMapaConceptual.test(recogerAlt);
		if ((recogerWidthImagenContenido > 600) && (comprobarRegexTitle === false) && (comprobarRegexAlt === false)) {
			$(this).attr('style', 'width:600px;');
		}
		if ((recogerWidthImagenContenido > 600) && (comprobarRegexTitle === true) && (comprobarRegexAlt === true)) {
			$(this).removeAttr('style');
		}
	});
	//BORRAR HR RESQUICIO DE COMENTARIOS
	$('.espacioContenido').find('hr').remove();
	// Arreglar margen, indentación tablas complejas (viñetas, numeracion) 
	$("[class^='MsoList']").css('text-indent', '0')
	//ENLACES _BLANK
	$('.espacioContenido a').not('#botonesNavegacion a').attr('target', '_blank');
	$('#disparadorPDF, #disparadorEPUB').attr('target', '_blank');
	// INICIO ACTIVIDADES
	$('.contenidoActividades').find('h5').each(function () {
		recogerTexto = $(this).text().replace(/\s+/g, '');
		recogerTitulo = document.title.replace(/\s+/g, '');
		if (recogerTexto === recogerTitulo) {
			existenciaActividades = true;
		}
		regexPantalla = /.*\*pantalla\*.*/gi
		comprobarRegexPantalla = regexPantalla.test(recogerTexto)
		if (comprobarRegexPantalla) {
			obtenerNumeroPantallaBoton = recogerTexto.replace(/.*\*pantalla\*([0-9]{1,3}).*/gi, '$1')
			obtenerURLPaginaBoton = window.location.href
			obtenerNumeroPaginaBoton = obtenerURLPaginaBoton.replace(/.*\/(.*)?\.html/, '$1')
			if (obtenerNumeroPantallaBoton === obtenerNumeroPaginaBoton) {
				existenciaActividades = true;
			}
		}
	});
	if (existenciaActividades === true) {
		$('h1:first').before('<div class="disparadorActividades"><a class="btn-floating btn-large waves-effect waves-light modal-trigger teal tooltipped " data-position="top" data-delay="50" data-tooltip="Actividades" href="#modalActividades"><i class="material-icons iconoComponenteVisible iconoActividades">touch_app</i></a></div>')
		$('body').append('<div class="avisoActividades" style="position:fixed; bottom:0;width:100%;background-color:#323232; padding:10px 25px;color:white;z-index:99;text-align:center;z-index:999">¡No te olvides de realizar las actividades autoevaluables! Pulsa el botón <i class="material-icons iconoComponenteVisible iconoActividades">touch_app</i> que encontrarás en la parte superior derecha. <i class="material-icons tiny cerrarAvisoActividades" style="float:right;position:relative;top:-5px;cursor:pointer;">close</i></div>')
		intervaloAvisoActividades = setTimeout(function () {
			$('.avisoActividades').fadeOut('slow');
		}, 10000);
		$('.cerrarAvisoActividades').click(function () {
			clearTimeout(intervaloAvisoActividades);
			$('.avisoActividades').fadeOut('slow');
		});
		$('.contenidoActividades').after('<div id="modalActividades" class="modal"><div class="modal-content"><h4>Actividades autoevaluables</h4><div id="envoltorioModalActividades"></div></div><div class="modal-footer"><a class="modal-action modal-close waves-effect btn-flat">Cerrar</a></div></div>');
		$('.contenidoActividades').find('h5').each(function () {
			recogerTexto = $(this).text().replace(/\s+/g, '');
			recogerTitulo = document.title.replace(/\s+/g, '');

			obtenerNumeroPantalla = ''
			obtenerNumeroPagina = ''

			obtenerNumeroPantalla = recogerTexto.replace(/.*\*pantalla\*([0-9]{1,3}).*/gi, '$1')
			obtenerURLPagina = window.location.href
			obtenerNumeroPagina = obtenerURLPagina.replace(/.*\/(.*)?\.html/, '$1')

			$('.contenidoActividades').find('tr th').each(function() {
				$(this).replaceWith("<td>" + $(this).html() + "</td>");
			});

			if (recogerTexto === recogerTitulo || obtenerNumeroPantalla === obtenerNumeroPagina) {
				tipoActividad = $(this).nextAll('table:first').find('td:first').text();
				tipoActividad = tipoActividad.replace('Ó', 'O');
				tipoActividad = tipoActividad.replace('Ú', 'U');
				contenidoActividad = $(this).nextAll('table:first').find('td:eq(1)').html();
				if (tipoActividad === 'HUECOS') {
					longitudTabla = $(this).nextAll('table:first').find('td').length;
					if (longitudTabla === 2) {
						$('#envoltorioModalActividades').before('<div class="envoltorioActividad envoltorioActividadHuecos"><p><b>Actividad de rellenar huecos</b></p><div class="actividadRellenarHuecos">' + contenidoActividad + '<div class="botonesDerecha"><a class="btn-floating green disparadorComprobarHuecos waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comprobar"><i class="material-icons">done</i></a><a class="btn-floating orange darken-1 disparadorSolucionarHuecos waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Resolver"><i class="material-icons">done_all</i></a><a class="btn-floating red darken-1 disparadorBorrarHuecos waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar"><i class="material-icons">replay</i></a><p class="numeroAciertosHuecos oculto"><span class="aciertosHuecos"></span> respuestas correctas de un total de <span class="totalHuecos"></span></p></div></div></div>')
					} else if (longitudTabla === 3) {
						recogerRetroalimentacion = $(this).nextAll('table:first').find('td:last').html();
						$('#envoltorioModalActividades').before('<div class="envoltorioActividad envoltorioActividadHuecos"><p><b>Actividad de rellenar huecos</b></p><div class="actividadRellenarHuecos">' + contenidoActividad + '<div class="botonesDerecha"><a class="btn-floating green disparadorComprobarHuecos waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comprobar"><i class="material-icons">done</i></a><a class="btn-floating orange darken-1 disparadorSolucionarHuecos waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Resolver"><i class="material-icons">done_all</i></a><a class="btn-floating red darken-1 disparadorBorrarHuecos waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar"><i class="material-icons">replay</i></a><p class="numeroAciertosHuecos oculto"><span class="aciertosHuecos"></span> respuestas correctas de un total de <span class="totalHuecos"></span></p><div class="retroalimentacionCorrecta retroalimentacionHuecosDesplegable oculto">' + recogerRetroalimentacion + '</div></div></div></div>')
					}
				} else if (tipoActividad === 'DESPLEGABLE') {
					longitudTabla = $(this).nextAll('table:first').find('td').length;
					if (longitudTabla === 2) {
						$('#envoltorioModalActividades').before('<div class="envoltorioActividad envoltorioActividadDesplegable"><p><b>Actividad con desplegables</b></p><div class="actividadDesplegable">' + contenidoActividad + '<div class="botonesDerecha"><a class="btn-floating green disparadorComprobarDesplegable waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comprobar"><i class="material-icons">done</i></a><a class="btn-floating orange darken-1 disparadorSolucionarDesplegable waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Resolver"><i class="material-icons">done_all</i></a><a class="btn-floating red darken-1 disparadorBorrarDesplegable waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar"><i class="material-icons">replay</i></a><p class="numeroAciertosDesplegable oculto"><span class="aciertosDesplegable"></span> respuestas correctas de un total de <span class="totalDesplegable"></span></p></div></div></div>')
					} else if (longitudTabla === 3) {
						recogerRetroalimentacion = $(this).nextAll('table:first').find('td:last').html();
						$('#envoltorioModalActividades').before('<div class="envoltorioActividad envoltorioActividadDesplegable"><p><b>Actividad con desplegables</b></p><div class="actividadDesplegable">' + contenidoActividad + '<div class="botonesDerecha"><a class="btn-floating green disparadorComprobarDesplegable waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comprobar"><i class="material-icons">done</i></a><a class="btn-floating orange darken-1 disparadorSolucionarDesplegable waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Resolver"><i class="material-icons">done_all</i></a><a class="btn-floating red darken-1 disparadorBorrarDesplegable waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar"><i class="material-icons">replay</i></a><p class="numeroAciertosDesplegable oculto"><span class="aciertosDesplegable"></span> respuestas correctas de un total de <span class="totalDesplegable"></span></p><div class="retroalimentacionCorrecta retroalimentacionHuecosDesplegable oculto">' + recogerRetroalimentacion + '</div></div></div></div>')
					}
				} else if (tipoActividad === 'DESPLEGABLE_SIMPLE') {
					longitudTabla = $(this).nextAll('table:first').find('td').length;
					if (longitudTabla === 2) {
						$('#envoltorioModalActividades').before('<div class="envoltorioActividad envoltorioActividadDesplegableSimple"><p><b>Actividad con desplegables</b></p><div class="actividadDesplegableSimple">' + contenidoActividad + '<div class="botonesDerecha"><a class="btn-floating green disparadorComprobarDesplegableSimple waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comprobar"><i class="material-icons">done</i></a><a class="btn-floating orange darken-1 disparadorSolucionarDesplegableSimple waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Resolver"><i class="material-icons">done_all</i></a><a class="btn-floating red darken-1 disparadorBorrarDesplegableSimple waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar"><i class="material-icons">replay</i></a><p class="numeroAciertosDesplegable oculto"><span class="aciertosDesplegable"></span> respuestas correctas de un total de <span class="totalDesplegable"></span></p></div></div></div>')
					} else if (longitudTabla === 3) {
						recogerRetroalimentacion = $(this).nextAll('table:first').find('td:last').html();
						$('#envoltorioModalActividades').before('<div class="envoltorioActividad envoltorioActividadDesplegableSimple"><p><b>Actividad con desplegables</b></p><div class="actividadDesplegableSimple">' + contenidoActividad + '<div class="botonesDerecha"><a class="btn-floating green disparadorComprobarDesplegableSimple waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comprobar"><i class="material-icons">done</i></a><a class="btn-floating orange darken-1 disparadorSolucionarDesplegableSimple waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Resolver"><i class="material-icons">done_all</i></a><a class="btn-floating red darken-1 disparadorBorrarDesplegableSimple waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar"><i class="material-icons">replay</i></a><p class="numeroAciertosDesplegable oculto"><span class="aciertosDesplegable"></span> respuestas correctas de un total de <span class="totalDesplegable"></span></p><div class="retroalimentacionCorrecta retroalimentacionHuecosDesplegable oculto">' + recogerRetroalimentacion + '</div></div></div></div>')
					}
				} else if (tipoActividad === 'ELECCION_MULTIPLE') {
					numeroAleatorio = parseInt(Math.random() * 100000)
					contenidoTablaEleccionMultipleSinFila = $(this).nextAll('table:first').find('tr:first').remove()
					contenidoTablaEleccionMultiplePregunta = $(this).nextAll('table:first').find('tr:first').find('td:first').html()
					contenidoTablaEleccionMultipleSinFilaDos = $(this).nextAll('table:first').find('tr:first').remove()
					contenidoTablaEleccionMultipleRetroalimentacion = $(this).nextAll('table:first').find('tr:last').find('td:first').html()
					contenidoTablaEleccionMultipleDepurada = $(this).nextAll('table:first').find('tr:last').remove()
					$('#envoltorioModalActividades').before('<div class="envoltorioActividad envoltorioActividadEleccionMultiple"><p><b>Actividad de elección múltiple</b></p><div class="identificadorActividadEleccionMultiple actividadEleccionMultiple' + numeroAleatorio + '"><div class="botonesDerecha"><a class="btn-floating green disparadorComprobarEleccion waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comprobar"><i class="material-icons">done</i></a><a class="btn-floating orange darken-1 disparadorSolucionarEleccion waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Resolver"><i class="material-icons">done_all</i></a><a class="btn-floating red darken-1 disparadorBorrarEleccion waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar"><i class="material-icons">replay</i></a></div></div></div>')
					$('.actividadEleccionMultiple' + numeroAleatorio + '').prepend('<form id="eleccionMultipleForm' + numeroAleatorio + '"></form>');
					$('#eleccionMultipleForm' + numeroAleatorio + '').append(contenidoTablaEleccionMultiplePregunta)
					contador = 0;
					contenidoTablaEleccionMultiple = $(this).nextAll('table:first').find('tr').each(function () {
						contenidoOpcion = $(this).find('td:first').html();
						contenidoSeleccionable = $(this).find('td:last').html();
						contenidoRetroalimentacion = $(this).find('td:last').html();
						$('#eleccionMultipleForm' + numeroAleatorio + '').append('<p><input name="opcionEleccionMultiple' + numeroAleatorio + '" type="radio" id="opcionRespuestaEleccionMultiple' + numeroAleatorio + '_' + contador + '" data-debeseleccionarse="' + contenidoSeleccionable + '"/><label class="labelPreguntaEleccionMultiple" for="opcionRespuestaEleccionMultiple' + numeroAleatorio + '_' + contador + '">' + contenidoOpcion + '</label></p>')
						if (contador === 0) {
							$('#eleccionMultipleForm' + numeroAleatorio + '').after('<div class="retroalimentacionIncorrecta" style="display:none;"><span><i class="material-icons">mood_bad</i> <strong><span style="position:relative;top:-5px;">Incorrecto</span></strong></span></div>')
							$('#eleccionMultipleForm' + numeroAleatorio + '').after('<div class="retroalimentacionCorrecta" style="display:none;"><span><i class="material-icons" style="color:#0A8A0A">mood</i> <strong><span style="position:relative;top:-5px;">Correcto</span></strong></span><br/>' + contenidoTablaEleccionMultipleRetroalimentacion + '</div>')
						}
						contador++;
					});
					$('.disparadorComprobarEleccion').each(function () {
						$(this).click(function () {
							debeSeleccionarse = $(this).parents('.identificadorActividadEleccionMultiple:first').find('input:checked').attr('data-debeseleccionarse')
							debeSeleccionarse = debeSeleccionarse.toUpperCase()
							if (debeSeleccionarse[0] === "S") {
								$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
								$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
								$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').show()
							} else {
								$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
								$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
								$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionIncorrecta:first').show()
							}
						});
					});
					$('.disparadorSolucionarEleccion').each(function () {
						$(this).click(function () {
							$(this).parents('.identificadorActividadEleccionMultiple:first').find('input').each(function () {
								var selector = $(this)
								debeSeleccionarse = $(this).attr('data-debeseleccionarse')
								debeSeleccionarse = debeSeleccionarse.toUpperCase()
								if (debeSeleccionarse[0] === "S") {
									$(this).get(0).click()
									$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
									$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
									$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').show()
								}
							});
						});
					});
					$('.disparadorBorrarEleccion').each(function () {
						$(this).click(function () {
							$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
							$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
							$(this).parents('.identificadorActividadEleccionMultiple:first').find('input:checked').prop('checked', false)
						});
					});
				} else if (tipoActividad === 'SELECCION_MULTIPLE') {
					numeroAleatorio = parseInt(Math.random() * 100000)
					contenidoTablaSeleccionMultipleSinFila = $(this).nextAll('table:first').find('tr:first').remove()
					contenidoTablaSeleccionMultiplePregunta = $(this).nextAll('table:first').find('tr:first').find('td:first').html()
					contenidoTablaSeleccionMultipleSinFilaDos = $(this).nextAll('table:first').find('tr:first').remove()
					contenidoTablaSeleccionMultipleRetroalimentacion = $(this).nextAll('table:first').find('tr:last').find('td:first').html()
					contenidoTablaSeleccionMultipleDepurada = $(this).nextAll('table:first').find('tr:last').remove()
					$('#envoltorioModalActividades').before('<div class="envoltorioActividad envoltorioActividadSeleccionMultiple"><p><b>Actividad de selección múltiple</b></p><div class="identificadorActividadSeleccionMultiple actividadSeleccionMultiple' + numeroAleatorio + '"><div class="botonesDerecha"><a class="btn-floating green disparadorComprobarSeleccion waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comprobar"><i class="material-icons">done</i></a><a class="btn-floating orange darken-1 disparadorSolucionarSeleccion waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Resolver"><i class="material-icons">done_all</i></a><a class="btn-floating red darken-1 disparadorBorrarSeleccion waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar"><i class="material-icons">replay</i></a></div></div></div>')
					$('.actividadSeleccionMultiple' + numeroAleatorio + '').prepend('<form id="seleccionMultipleForm' + numeroAleatorio + '"></form>');
					$('#seleccionMultipleForm' + numeroAleatorio + '').append(contenidoTablaSeleccionMultiplePregunta)
					contador = 0;
					contenidoTablaSeleccionMultiple = $(this).nextAll('table:first').find('tr').each(function () {
						contenidoOpcion = $(this).find('td:first').html();
						contenidoSeleccionable = $(this).find('td:last').html();
						contenidoRetroalimentacion = $(this).find('td:last').html();
						$('#seleccionMultipleForm' + numeroAleatorio + '').append('<p><input type="checkbox" id="opcionSeleccionMultiple_' + numeroAleatorio + '_' + contador + '" data-debeseleccionarse="' + contenidoSeleccionable + '"/><label class="labelPreguntaSeleccionMultiple" for="opcionSeleccionMultiple_' + numeroAleatorio + '_' + contador + '">' + contenidoOpcion + '</label></p>')
						if (contador === 0) {
							$('#seleccionMultipleForm' + numeroAleatorio + '').after('<div class="retroalimentacionIncorrecta" style="display:none;"><span><i class="material-icons">mood_bad</i> <strong><span style="position:relative;top:-5px;">Incorrecto</span></strong></span></div>')
							$('#seleccionMultipleForm' + numeroAleatorio + '').after('<div class="retroalimentacionCorrecta" style="display:none;"><span><i class="material-icons" style="color:#0A8A0A">mood</i> <strong><span style="position:relative;top:-5px;">Correcto</span></strong></span><br/>' + contenidoTablaSeleccionMultipleRetroalimentacion + '</div>')
						}
						contador++;
					});
					var presuponerAcierto = true;
					$('.disparadorComprobarSeleccion').each(function () {
						$(this).click(function () {
							presuponerAcierto = true;
							$(this).parents('.identificadorActividadSeleccionMultiple:first').find('input').each(function () {
								recogerSeleccion = $(this).is(':checked');
								recogerSeleccionAdecuada = $(this).attr('data-debeseleccionarse');
								recogerSeleccionAdecuada = recogerSeleccionAdecuada.toUpperCase();
								if (recogerSeleccion === true && recogerSeleccionAdecuada[0] === "S") { } else if (recogerSeleccion === false && recogerSeleccionAdecuada[0] === "N") { } else {
									presuponerAcierto = false;
								}
							});
							if (presuponerAcierto === true) {
								$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
								$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
								$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').show()
							} else {
								$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
								$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
								$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionIncorrecta:first').show()
							}
						});
					})
					$('.disparadorSolucionarSeleccion').each(function () {
						$(this).click(function () {
							$(this).parents('.identificadorActividadSeleccionMultiple:first').find('input').each(function () {
								recogerAttrRespuestaCorrecta = $(this).attr('data-debeseleccionarse');
								recogerAttrRespuestaCorrecta = recogerAttrRespuestaCorrecta.toUpperCase();
								recogerSeleccion = $(this).is(':checked');
								if (recogerAttrRespuestaCorrecta[0] === "S" && recogerSeleccion === true) { } else if (recogerAttrRespuestaCorrecta[0] === "S" && recogerSeleccion === false) {
									$(this).click()
								} else if (recogerAttrRespuestaCorrecta === "NO" && recogerSeleccion === true) {
									$(this).click()
								} else if (recogerAttrRespuestaCorrecta === "NO" && recogerSeleccion === false) { }
							});
							$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
							$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
							$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').show()
						});
					})
					$('.disparadorBorrarSeleccion').each(function () {
						$(this).click(function () {
							$(this).parents('.identificadorActividadSeleccionMultiple:first').find('input').each(function () {
								recogerSeleccion = $(this).is(':checked');
								if (recogerSeleccion === true) {
									$(this).click()
								}
							});
							$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
							$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
						});
					})
				}
				else if (tipoActividad === 'VERDADERO_FALSO') {
					numeroAleatorio = parseInt(Math.random() * 100000)

					$('#envoltorioModalActividades').before('<div class="envoltorioActividad envoltorioActividadVerdaderoFalso"><p><b>Actividad de verdadero o falso</b></p><div class="identificadorActividadVerdaderoFalso actividadVerdaderoFalso' + numeroAleatorio + '"></div></div>')

					contenidoTablaVerdaderoFalsoSinFila = $(this).nextAll('table:first').find('tr:first').remove()

					$(this).nextAll('table:first').find('thead:first>tr, tbody:first>tr').addClass('filaReal')
					numeroPreguntasVerdaderoFalso = $(this).nextAll('table:first').find('.filaReal').length
					contador = 0
					for (i = 0; i < numeroPreguntasVerdaderoFalso; i++) {
						contenidoPreguntaVerdaderoFalso = $(this).nextAll('table:first').find('.filaReal:eq(' + i + ')').children('td:first').html()
						contenidoRespuestaVerdaderoFalso = $(this).nextAll('table:first').find('.filaReal:eq(' + i + ')').children('td:eq(1)').html()
						contenidoRetroalimentacionVerdaderoFalso = $(this).nextAll('table:first').find('.filaReal:eq(' + i + ')').children('td:last').html()

						$('.actividadVerdaderoFalso' + numeroAleatorio + '').append('<form id="eleccionVerdaderoFalsoForm' + numeroAleatorio + '_' + contador + '"></form>');
						$('#eleccionVerdaderoFalsoForm' + numeroAleatorio + '_' + contador + '').append('<p>' + contenidoPreguntaVerdaderoFalso + '<p><input name="eleccionVerdaderoFalsoForm' + numeroAleatorio + '_' + contador + '" type="radio" id="opcionRespuestaVerdadero' + numeroAleatorio + '_' + contador + '" data-debeseleccionarse="' + contenidoRespuestaVerdaderoFalso + '"/><label class="labelPreguntaVerdadero" for="opcionRespuestaVerdadero' + numeroAleatorio + '_' + contador + '">Verdadero</label></p><p><input name="eleccionVerdaderoFalsoForm' + numeroAleatorio + '_' + contador + '" type="radio" id="opcionRespuestaFalso' + numeroAleatorio + '_' + contador + '" data-debeseleccionarse="' + contenidoRespuestaVerdaderoFalso + '"/><label class="labelPreguntaFalso" for="opcionRespuestaFalso' + numeroAleatorio + '_' + contador + '">Falso</label></p><div class="retroalimentacionIncorrecta" style="display:none;"><span><i class="material-icons">mood_bad</i> <strong><span style="position:relative;top:-5px;">Incorrecto</span></strong></span></div><div class="retroalimentacionCorrecta" style="display:none;"><span><i class="material-icons" style="color:#0A8A0A">mood</i> <strong><span style="position:relative;top:-5px;">Correcto</span></strong></span><br/>' + contenidoRetroalimentacionVerdaderoFalso + '</div>')
						$('#eleccionVerdaderoFalsoForm' + numeroAleatorio + '_' + contador + '').append('<div class="botonesDerecha"><a class="btn-floating green disparadorComprobarVerdaderoFalso waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comprobar"><i class="material-icons">done</i></a><a class="btn-floating orange darken-1 disparadorSolucionarVerdaderoFalso waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Resolver"><i class="material-icons">done_all</i></a><a class="btn-floating red darken-1 disparadorBorrarVerdaderoFalso waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar"><i class="material-icons">replay</i></a></div>')
						contador++;
					}

					$('.disparadorComprobarVerdaderoFalso').each(function () {
						$(this).click(function () {
							debeSeleccionarse = $(this).parents('form:first').find('input:checked').attr('data-debeseleccionarse')
							respuestaSeleccionada = $(this).parents('form:first').find('input:checked').next('label').text()
							if ((debeSeleccionarse === "V") && (respuestaSeleccionada === "Verdadero")) {
								$(this).parents('form:first').find('.retroalimentacionCorrecta:first').hide()
								$(this).parents('form:first').find('.retroalimentacionIncorrecta:first').hide()
								$(this).parents('form:first').find('.retroalimentacionCorrecta:first').show()
							}
							else if ((debeSeleccionarse === "F") && (respuestaSeleccionada === "Falso")) {
								$(this).parents('form:first').find('.retroalimentacionCorrecta:first').hide()
								$(this).parents('form:first').find('.retroalimentacionIncorrecta:first').hide()
								$(this).parents('form:first').find('.retroalimentacionCorrecta:first').show()
							}
							else {
								$(this).parents('form:first').find('.retroalimentacionCorrecta:first').hide()
								$(this).parents('form:first').find('.retroalimentacionIncorrecta:first').hide()
								$(this).parents('form:first').find('.retroalimentacionIncorrecta:first').show()
							}
						});
					});
					$('.disparadorSolucionarVerdaderoFalso').each(function () {
						$(this).click(function () {
							$(this).parents('form:first').find('input').each(function () {
								var selector = $(this)
								debeSeleccionarse = $(this).attr('data-debeseleccionarse')
								respuestaSeleccionada = $(this).next('label').text()
								if ((debeSeleccionarse === "V") && (respuestaSeleccionada === "Verdadero")) {
									$(this).get(0).click()
									$(this).parents('form:first').find('.retroalimentacionCorrecta:first').hide()
									$(this).parents('form:first').find('.retroalimentacionIncorrecta:first').hide()
									$(this).parents('form:first').find('.retroalimentacionCorrecta:first').show()
								}
								else if ((debeSeleccionarse === "F") && (respuestaSeleccionada === "Falso")) {
									$(this).get(0).click()
									$(this).parents('form:first').find('.retroalimentacionCorrecta:first').hide()
									$(this).parents('form:first').find('.retroalimentacionIncorrecta:first').hide()
									$(this).parents('form:first').find('.retroalimentacionCorrecta:first').show()
								}
							});
						});
					});
					$('.disparadorBorrarVerdaderoFalso').each(function () {
						$(this).click(function () {
							$(this).parents('form:first').find('.retroalimentacionCorrecta:first').hide()
							$(this).parents('form:first').find('.retroalimentacionIncorrecta:first').hide()
							$(this).parents('form:first').find('input:checked').prop('checked', false)
						});
					});
				}
				else if (tipoActividad === 'RELACIONAR') {
					numeroAleatorio = parseInt(Math.random() * 100000)
					$('#envoltorioModalActividades').before('<div class="envoltorioActividad envoltorioRelacionar"><p><b>Actividad de relación</b></p><div class="identificadorActividadRelacionar actividadRelacionar' + numeroAleatorio + '"></div><div class="botonesDerecha"><a class="btn-floating green disparadorComprobarRelacionar waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comprobar"><i class="material-icons">done</i></a><a class="btn-floating orange darken-1 disparadorSolucionRelacionar waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Resolver"><i class="material-icons">done_all</i></a><a class="btn-floating red darken-1 disparadorReiniciarRelacionar waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar"><i class="material-icons">replay</i></a></div></div></div>')

					posibleEnunciadoRelacion = $(this).nextAll('table:first').find('tr:first').find('td:eq(1)').html()
					$(this).nextAll('table:first').find('tr:first').remove()
					contenidoTablaRelacionarRetroalimentacion = $(this).nextAll('table:first').find('tr:last').find('td:first').html()
					$(this).nextAll('table:first').find('tr:last').remove()
					numeracion = ['a)', 'b)', 'c)', 'd)', 'e)', 'f)', 'g)', 'h)', 'i)', 'j)', 'k)', 'l)', 'm)', 'n)', 'o)', 'p)','q)','r)','s)','t)','u)','v)', 'w)', 'x)', 'y)', 'z)']
					arrayCorrecto = []
					$(this).nextAll('table:first').find('tr').each(function(){
						recogerOpcion = $(this).find('td:first').html()
						arrayCorrecto.push(recogerOpcion)
					})					
					diccionarioRespuestasCorrectas = []
					for (i=0;i<arrayCorrecto.length;i++) {						
						$(this).nextAll('table:first').find('tr').eq(i).find('td:not(:first)').each(function(){
							contenidoRespuestaRelacionar = $(this).html()
							if (contenidoRespuestaRelacionar !== '') {
								diccionarioRespuestasCorrectas.push({
									'respuesta': numeracion[i],
									'opcionCorrecta': contenidoRespuestaRelacionar
								})
							}
							
						})
					}
					diccionarioRespuestasAzar = _.shuffle(diccionarioRespuestasCorrectas);
					contenidoInteriorSelect = '<option value=""></option>'
					for (i=0;i<arrayCorrecto.length;i++) {
						contenidoInteriorSelect += '<option value="'+numeracion[i]+'">'+numeracion[i]+'</option>'
					}
					contenidoSelect = '<select class="opcionDesplegable">'+contenidoInteriorSelect+'</select>'
					columnaOpcionesPrevio = ''
					for (i=0;i<arrayCorrecto.length;i++) {
						columnaOpcionesPrevio += '<p>'+numeracion[i]+' '+arrayCorrecto[i]+'</p>'
					}
					columnaOpciones = '<div class="col l12 s12">'+posibleEnunciadoRelacion+'</div><div class="col l8 s12">'+columnaOpcionesPrevio+'</div>'
					columnaRespuestasPrevio = ''
					for (i=0;i<diccionarioRespuestasAzar.length;i++) {
						columnaRespuestasPrevio += '<p class="parrafoRespuestasRelacionar" data-opcion-correcta-resolver="'+diccionarioRespuestasAzar[i]["respuesta"]+'">'+contenidoSelect+' '+diccionarioRespuestasAzar[i]["opcionCorrecta"]+'</p>'
					}
					columnaRespuestas = '<div class="row"><div class="col l4 s12">'+columnaRespuestasPrevio+'</div></div>'
					$('.actividadRelacionar' + numeroAleatorio + '').append('<div class="contenedorRespuestasRelacionar">'+columnaOpciones+' '+columnaRespuestas+'</div>')
					$('.actividadRelacionar' + numeroAleatorio + '').after('<div class="retroalimentacionIncorrecta" style="display:none;"><span><i class="material-icons">mood_bad</i> <strong><span style="position:relative;top:-5px;">Incorrecto</span></strong></span></div>')
					$('.actividadRelacionar' + numeroAleatorio + '').after('<p class="numeroAciertosRelacionar oculto" style="text-align:right;"><span class="aciertosRelacionar"></span> respuestas correctas de un total de <span class="totalRelacionar"></span></p><div class="retroalimentacionCorrecta" style="display:none;"><span><i class="material-icons" style="color:#0A8A0A">mood</i> <strong><span style="position:relative;top:-5px;">Correcto</span></strong></span><br/>' + contenidoTablaRelacionarRetroalimentacion + '</div>')					
				}
				else if (tipoActividad === 'ALFABETO') {	
					numeroAleatorio = parseInt(Math.random() * 100000)
					$('#envoltorioModalActividades').before('<div class="envoltorioActividad envoltorioAlfabeto"><p><b>Actividad de alfabeto</b></p><div class="identificadorActividadAlfabeto actividadAlfabeto' + numeroAleatorio + '"></div><div class="botonesDerecha"><a class="btn-floating green disparadorComprobarAlfabeto waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Comprobar"><i class="material-icons">done</i></a><a class="btn-floating orange darken-1 disparadorSolucionAlfabeto waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Resolver"><i class="material-icons">done_all</i></a><a class="btn-floating red darken-1 disparadorReiniciarAlfabeto waves-effect waves-light tooltipped" data-position="top" data-delay="50" data-tooltip="Reiniciar"><i class="material-icons">replay</i></a></div></div></div>')

					posibleEnunciadoAlfabeto = $(this).nextAll('table:first').find('tr:first').find('td:eq(1)').html()
					$(this).nextAll('table:first').find('tr:first').remove()
					contenidoTablaAlfabetoRetroalimentacion = $(this).nextAll('table:first').find('tr:last').find('td:first').html()
					$(this).nextAll('table:first').find('tr:last').remove()
					diccionarioContenidoAlfabeto = []
					$(this).nextAll('table:first').find('tr').each(function() {
						contenidoEnunciadoAlfabeto = $(this).find('td:first').html()
						contenidoRespuestaAlfabeto = $(this).find('td:last').html()
						diccionarioContenidoAlfabeto.push({
							'explicacion': contenidoEnunciadoAlfabeto,
							'concepto': contenidoRespuestaAlfabeto
						})
					})

					letrasMenuAlfabetoTotal = []
					for (i=0;i<diccionarioContenidoAlfabeto.length;i++) {
						letrasMenuAlfabetoTotal.push(diccionarioContenidoAlfabeto[i]["concepto"].toUpperCase()[0])
					}
					letrasMenuAlfabeto = _.uniq(letrasMenuAlfabetoTotal);
					letrasMenuAlfabeto = _.sortBy(letrasMenuAlfabeto);
					contenidoMenuAlfabetoPrevio = ''
					$.each(letrasMenuAlfabeto, function(indice, valor){
						letraMenu = valor.normalize("NFD").replace(/[\u0300-\u036f]/g, "")
						contenidoMenuAlfabetoPrevio += '<li class="paginacionAlfabetoElemento waves-effect"><a class="disparadorPaginacionAlfabeto" data-disparador-alfabeto="'+valor.toLowerCase()+'">'+letraMenu+'</a></li>' 
					})
					contenidoMenuAlfabeto = ''+posibleEnunciadoAlfabeto+'<ul id="menuAlfabeto'+numeroAleatorio+'" class="pagination" style="text-align:center">'+contenidoMenuAlfabetoPrevio+'</ul>'

					contenidoBloquesRespuestasPrevio = ''
					for (i=0;i<diccionarioContenidoAlfabeto.length;i++) {
						letraMostrar = diccionarioContenidoAlfabeto[i]["concepto"].toLowerCase()[0]						
						contenidoBloquesRespuestasPrevio += '<div class="contenedorBloqueRespuestasAlfabeto" data-letra-mostrar="'+letraMostrar+'" style="display:none; padding:10px; background: #f0f0f0; margin: 20px 0 20px 0px;">'+diccionarioContenidoAlfabeto[i]["explicacion"]+' <p style="text-align:center"><input data-concepto-alfabeto="'+diccionarioContenidoAlfabeto[i]["concepto"].toLowerCase()+'" data-concepto-alfabeto-solucion="'+diccionarioContenidoAlfabeto[i]["concepto"]+'" class="huecoRellenar" size="20"></p></div> '
					}
					contenidoBloquesRespuestas = '<div class="envoltorioContenedorBloqueRespuestasAlfabeto">'+contenidoBloquesRespuestasPrevio+'</div>'

					$('.actividadAlfabeto' + numeroAleatorio + '').append(''+contenidoMenuAlfabeto+' '+contenidoBloquesRespuestas+'')

					$('.disparadorPaginacionAlfabeto').each(function(){
						$(this).click(function(){
							$('.paginacionAlfabetoElemento').removeClass('active')
							$(this).parent().addClass('active')
							recogerLetraMostrar = $(this).attr('data-disparador-alfabeto')
							$(this).parents('.identificadorActividadAlfabeto').find('.contenedorBloqueRespuestasAlfabeto').hide()
							$(this).parents('.identificadorActividadAlfabeto').find('[data-letra-mostrar="'+recogerLetraMostrar+'"]').show()
						})
					})
					$('.actividadAlfabeto' + numeroAleatorio + '').after('<div class="retroalimentacionIncorrecta" style="display:none;"><span><i class="material-icons">mood_bad</i> <strong><span style="position:relative;top:-5px;">Incorrecto</span></strong></span></div>')
					$('.actividadAlfabeto' + numeroAleatorio + '').after('<p class="numeroAciertosAlfabeto oculto" style="text-align:right;"><span class="aciertosAlfabeto"></span> respuestas correctas de un total de <span class="totalAlfabeto"></span></p><div class="retroalimentacionCorrecta" style="display:none;"><span><i class="material-icons" style="color:#0A8A0A">mood</i> <strong><span style="position:relative;top:-5px;">Correcto</span></strong></span><br/>' + contenidoTablaAlfabetoRetroalimentacion + '</div>')
				}
				// DISPARADORES ALFABETO
				$('.disparadorComprobarAlfabeto ').each(function(){
					$(this).click(function () {
						presuponerAcierto = true
						numeroInputs = $(this).parents('.envoltorioAlfabeto:first').find('input').length
						contadorAciertosAlfabeto = 0
						$(this).parents('.envoltorioAlfabeto:first').find('input').each(function(){							
							recogerRespuestaAlfabetoCorrecta = $(this).attr('data-concepto-alfabeto')
							recogerRespuestaUsuario = $(this).val().toLowerCase()
							if (recogerRespuestaAlfabetoCorrecta !== recogerRespuestaUsuario) {
								$(this).css('background', 'tomato')
								presuponerAcierto = false
							}
							else {
								$(this).css('background', 'lightgreen')
								contadorAciertosAlfabeto++;
							}
						})
						if (presuponerAcierto) {
							$(this).parents('.envoltorioAlfabeto:first').find('.active').removeClass('active')
							$(this).parents('.envoltorioAlfabeto:first').find('.retroalimentacionIncorrecta').hide()
							$(this).parents('.envoltorioAlfabeto:first').find('.retroalimentacionCorrecta').show()
						}
						else {
							$(this).parents('.envoltorioAlfabeto:first').find('.active').removeClass('active')
							$(this).parents('.envoltorioAlfabeto:first').find('.contenedorBloqueRespuestasAlfabeto').show()
							$(this).parents('.envoltorioAlfabeto:first').find('.retroalimentacionCorrecta').hide()
							$(this).parents('.envoltorioAlfabeto:first').find('.retroalimentacionIncorrecta').show()							
						}

						$(this).parents('.envoltorioAlfabeto:first').find('.aciertosAlfabeto').text(contadorAciertosAlfabeto)
						$(this).parents('.envoltorioAlfabeto:first').find('.totalAlfabeto').text(numeroInputs)
						$(this).parents('.envoltorioAlfabeto:first').find('.numeroAciertosAlfabeto').show()
					})
				});
				$('.disparadorSolucionAlfabeto').each(function () {
					$(this).click(function(){
						$(this).parents('.envoltorioAlfabeto:first').find('input').each(function(){
							recogerRespuestaAlfabetoCorrecta = $(this).attr('data-concepto-alfabeto-solucion')
							$(this).val(recogerRespuestaAlfabetoCorrecta)
							$(this).css('background', 'lightgreen')
						});

						//REVISAR $(this).parents('.envoltorioAlfabeto:first').find('.active').hide()
						
						$(this).parents('.envoltorioAlfabeto:first').find('.active').removeClass('active')
						$(this).parents('.envoltorioAlfabeto:first').find('.numeroAciertosAlfabeto').hide()
						$(this).parents('.envoltorioAlfabeto:first').find('.contenedorBloqueRespuestasAlfabeto').show()
						$(this).parents('.envoltorioAlfabeto:first').find('.retroalimentacionIncorrecta').hide()
						$(this).parents('.envoltorioAlfabeto:first').find('.retroalimentacionCorrecta').show()
					})					
				});
				$('.disparadorReiniciarAlfabeto').each(function () {
					$(this).click(function(){
						$(this).parents('.envoltorioAlfabeto:first').find('input').each(function(){							
							$(this).val('')
							$(this).css('background', 'transparent')
						});
						$(this).parents('.envoltorioAlfabeto:first').find('.contenedorBloqueRespuestasAlfabeto').hide()
						$(this).parents('.envoltorioAlfabeto:first').find('.numeroAciertosAlfabeto').hide()
						$(this).parents('.envoltorioAlfabeto:first').find('.retroalimentacionIncorrecta').hide()
						$(this).parents('.envoltorioAlfabeto:first').find('.retroalimentacionCorrecta').hide()
						$(this).parents('.envoltorioAlfabeto:first').find('.active').removeClass('active')
					})					
				});
				// DISPARADORES RELACIONAR
				$('.disparadorComprobarRelacionar').each(function () {
					$(this).click(function () {
						presuponerAcierto = true
						numeroAciertosRelacionar = 0
						numeroSelects = $(this).parents('.envoltorioRelacionar:first').find('select').length
						$(this).parents('.envoltorioRelacionar:first').find('select').each(function(){
							recogerValorSelect = $(this).val()
							recogerDataOpcionCorrectaResolver = $(this).parent().attr('data-opcion-correcta-resolver')
							if (recogerValorSelect !== recogerDataOpcionCorrectaResolver) {
								presuponerAcierto = false
								$(this).css('background','tomato')
							}
							else {
								$(this).css('background','lightgreen')
								numeroAciertosRelacionar++;
							}
							if (presuponerAcierto) {
								$(this).parents('.envoltorioRelacionar:first').find('.retroalimentacionIncorrecta').hide()
								$(this).parents('.envoltorioRelacionar:first').find('.retroalimentacionCorrecta').show()
							}
							else {								
								$(this).parents('.envoltorioRelacionar:first').find('.retroalimentacionCorrecta').hide()
								$(this).parents('.envoltorioRelacionar:first').find('.retroalimentacionIncorrecta').show()								
							}
						})
						$(this).parents('.envoltorioRelacionar:first').find('.aciertosRelacionar').text(numeroAciertosRelacionar)
						$(this).parents('.envoltorioRelacionar:first').find('.totalRelacionar').text(numeroSelects)
						$(this).parents('.envoltorioRelacionar:first').find('.numeroAciertosRelacionar').show()				
					});		
				});
				$('.disparadorSolucionRelacionar').each(function () {
					$(this).click(function(){
						$(this).parents('.envoltorioRelacionar:first').find('select').each(function(){
							recogerDataOpcionCorrectaResolver = $(this).parent().attr('data-opcion-correcta-resolver')
							$(this).val(recogerDataOpcionCorrectaResolver).css('background','lightgreen')
						});
						$(this).parents('.envoltorioRelacionar:first').find('.numeroAciertosRelacionar').hide()
						$(this).parents('.envoltorioRelacionar:first').find('.retroalimentacionIncorrecta').hide()
						$(this).parents('.envoltorioRelacionar:first').find('.retroalimentacionCorrecta').show()
					})					
				});
				$('.disparadorReiniciarRelacionar').each(function () {
					$(this).click(function(){
						$(this).parents('.envoltorioRelacionar:first').find('select').each(function(){							
							$(this).val('').css('background','white')
						});
						$(this).parents('.envoltorioRelacionar:first').find('.numeroAciertosRelacionar').hide()
						$(this).parents('.envoltorioRelacionar:first').find('.retroalimentacionIncorrecta').hide()
						$(this).parents('.envoltorioRelacionar:first').find('.retroalimentacionCorrecta').hide()
					})					
				});
			}
		});
		// INICIO RELLENAR_HUECOS
		$('.actividadRellenarHuecos').each(function () {
			$(this).find('.underline').each(function () {
				obtenerRespuestaCorrecta = $(this).text();
				longitud = obtenerRespuestaCorrecta.length;
				$(this).before('<input class="huecoRellenar" data-respuestacorrecta="' + obtenerRespuestaCorrecta + '" size="' + longitud + '"/>')
				$(this).hide()
			});
		});
		$('.disparadorComprobarHuecos').each(function () {
			$(this).click(function () {
				$(this).parents('.actividadRellenarHuecos:first').find('.huecoRellenar').each(function () {
					recogerRespuesta = $(this).val();
					recogerRespuestaCorrecta = $(this).attr('data-respuestacorrecta');
					if (recogerRespuesta === recogerRespuestaCorrecta) {
						$(this).css('background', 'lightgreen').addClass('aciertoHueco');
					} else {
						$(this).css('background', 'tomato').removeClass('aciertoHueco');
					}
				});
				numeroAciertos = $(this).parents('.actividadRellenarHuecos:first').find('.aciertoHueco').length
				numeroTotal = $(this).parents('.actividadRellenarHuecos:first').find('.huecoRellenar').length
				$(this).parents('.actividadRellenarHuecos:first').find('.aciertosHuecos').text(numeroAciertos)
				$(this).parents('.actividadRellenarHuecos:first').find('.totalHuecos').text(numeroTotal)
				$(this).parents('.actividadRellenarHuecos:first').find('.numeroAciertosHuecos').show();
				if (numeroAciertos == numeroTotal) {
					$(this).parents('.actividadRellenarHuecos:first').find('.retroalimentacionCorrecta').show();
				} else {
					$(this).parents('.actividadRellenarHuecos:first').find('.retroalimentacionCorrecta').hide();
				}
			});
		});
		$('.disparadorSolucionarHuecos').each(function () {
			$(this).click(function () {
				$(this).parents('.actividadRellenarHuecos:first').find('.huecoRellenar').each(function () {
					recogerRespuestaCorrecta = $(this).attr('data-respuestacorrecta');
					$(this).val(recogerRespuestaCorrecta)
					$(this).css('background', 'lightgreen').addClass('aciertoHueco');;
				});
				$('.numeroAciertosHuecos').hide();
				$(this).parents('.actividadRellenarHuecos:first').find('.retroalimentacionCorrecta').show();
			});
		});
		$('.disparadorBorrarHuecos').each(function () {
			$(this).click(function () {
				$(this).parents('.actividadRellenarHuecos:first').find('.huecoRellenar').each(function () {
					$(this).val('').removeClass('aciertoHueco');
					$(this).css('background', 'none');
				});
				$('.numeroAciertosHuecos').hide();
				$(this).parents('.actividadRellenarHuecos:first').find('.retroalimentacionCorrecta').hide();
			});
		});
		// FIN RELLENAR HUECOS
		// INICIO DESPLEGABLE
		$('.actividadDesplegable').each(function () {
			$(this).find('.underline').each(function () {
				obtenerRespuestas = $(this).text();
				arrayRespuestas = obtenerRespuestas.split('|');
				respuestaCorrecta = arrayRespuestas[0]
				$(this).after('<select class="opcionDesplegable" data-respuestacorrecta="' + respuestaCorrecta + '"></select>');
				arrayRespuestasCorrectasAzar = _.shuffle(arrayRespuestas)
				$(this).next('.opcionDesplegable').append('<option value=""></option>')
				for (i = 0; i < arrayRespuestasCorrectasAzar.length; i++) {
					$(this).next('.opcionDesplegable').append('<option value="' + arrayRespuestasCorrectasAzar[i] + '">' + arrayRespuestasCorrectasAzar[i] + '</option>')
				};
				$(this).hide();
			});
		});
		$('.disparadorComprobarDesplegable').each(function () {
			$(this).click(function () {
				$(this).parents('.actividadDesplegable:first').find('.opcionDesplegable').each(function () {
					recogerRespuesta = $(this).val();
					recogerRespuestaCorrecta = $(this).attr('data-respuestacorrecta');
					if (recogerRespuesta === recogerRespuestaCorrecta) {
						$(this).css('background', 'lightgreen').addClass('aciertoDesplegable');
					} else {
						$(this).css('background', 'tomato').removeClass('aciertoDesplegable');
					}
				});
				numeroAciertos = $(this).parents('.actividadDesplegable:first').find('.aciertoDesplegable').length
				numeroTotal = $(this).parents('.actividadDesplegable:first').find('.opcionDesplegable').length
				$(this).parents('.actividadDesplegable:first').find('.aciertosDesplegable').text(numeroAciertos)
				$(this).parents('.actividadDesplegable:first').find('.totalDesplegable').text(numeroTotal)
				$(this).parents('.actividadDesplegable:first').find('.numeroAciertosDesplegable').show();
				if (numeroAciertos == numeroTotal) {
					$(this).parents('.actividadDesplegable:first').find('.retroalimentacionCorrecta').show();
				}
			});
		});
		$('.disparadorSolucionarDesplegable').each(function () {
			$(this).click(function () {
				$(this).parents('.actividadDesplegable:first').find('.opcionDesplegable').each(function () {
					recogerRespuestaCorrecta = $(this).attr('data-respuestacorrecta');
					$(this).val(recogerRespuestaCorrecta)
					$(this).css('background', 'lightgreen').addClass('aciertoDesplegable');;
				});
				$(this).parents('.actividadDesplegable:first').find('.numeroAciertosDesplegable').hide();
				$(this).parents('.actividadDesplegable:first').find('.retroalimentacionCorrecta').show();
			});
		});
		$('.disparadorBorrarDesplegable').each(function () {
			$(this).click(function () {
				$(this).parents('.actividadDesplegable:first').find('.opcionDesplegable').each(function () {
					$(this).val('').removeClass('aciertoDesplegable');
					$(this).css('background', 'none');
				});
				$(this).parents('.actividadDesplegable:first').find('.numeroAciertosDesplegable').hide();
				$(this).parents('.actividadDesplegable:first').find('.retroalimentacionCorrecta').hide();
			});
		});
		$('.opcionDesplegable').each(function () {
			$(this).click(function () {
				$(this).css('background', 'none');
			});
		});
		//FIN DESPLEGABLE
		// INICIO DESPLEGABLE_SIMPLE
		$('.actividadDesplegableSimple').each(function () {
			coleccionRespuestasCorrectas = []
			$(this).find('.underline').each(function () {
				recogerElementoSubrayado = $(this).text()
				coleccionRespuestasCorrectas.push(recogerElementoSubrayado)
			});
			$(this).find('.underline').each(function () {
				obtenerRespuestas = $(this).text();
				aleatorizarArrayRespuestas = _.shuffle(coleccionRespuestasCorrectas);
				$(this).after('<select class="opcionDesplegable" data-respuestacorrecta="' + obtenerRespuestas + '"></select>');
				$(this).next('.opcionDesplegable').append('<option value="' + obtenerRespuestas + '"></option>')
				for (i = 0; i < aleatorizarArrayRespuestas.length; i++) {
					$(this).next('.opcionDesplegable').append('<option value="' + aleatorizarArrayRespuestas[i] + '">' + aleatorizarArrayRespuestas[i] + '</option>')
				};
				$(this).hide();
			});
		});
		$('.disparadorComprobarDesplegableSimple').each(function () {
			$(this).click(function () {
				$(this).parents('.actividadDesplegableSimple:first').find('.opcionDesplegable').each(function () {
					recogerRespuesta = $(this).val();
					recogerRespuestaCorrecta = $(this).attr('data-respuestacorrecta');
					if (recogerRespuesta === recogerRespuestaCorrecta) {
						$(this).css('background', 'lightgreen').addClass('aciertoDesplegable');
					} else {
						$(this).css('background', 'tomato').removeClass('aciertoDesplegable');
					}
				});
				numeroAciertos = $(this).parents('.actividadDesplegableSimple:first').find('.aciertoDesplegable').length
				numeroTotal = $(this).parents('.actividadDesplegableSimple:first').find('.opcionDesplegable').length
				$(this).parents('.actividadDesplegableSimple:first').find('.aciertosDesplegable').text(numeroAciertos)
				$(this).parents('.actividadDesplegableSimple:first').find('.totalDesplegable').text(numeroTotal)
				$(this).parents('.actividadDesplegableSimple:first').find('.numeroAciertosDesplegable').show();
				if (numeroAciertos == numeroTotal) {
					$(this).parents('.actividadDesplegableSimple:first').find('.retroalimentacionCorrecta').show();
				}
			});
		});
		$('.disparadorSolucionarDesplegableSimple').each(function () {
			$(this).click(function () {
				$(this).parents('.actividadDesplegableSimple:first').find('.opcionDesplegable').each(function () {
					recogerRespuestaCorrecta = $(this).attr('data-respuestacorrecta');
					$(this).find('option[value="' + recogerRespuestaCorrecta + '"]').prop('selected', true)
					$(this).css('background', 'lightgreen').addClass('aciertoDesplegable');;
				});
				$(this).parents('.actividadDesplegableSimple:first').find('.numeroAciertosDesplegable').hide();
				$(this).parents('.actividadDesplegableSimple:first').find('.retroalimentacionCorrecta').hide();
			});
		});
		$('.disparadorBorrarDesplegableSimple').each(function () {
			$(this).click(function () {
				$(this).parents('.actividadDesplegableSimple:first').find('.opcionDesplegable').each(function () {
					$(this).val('').removeClass('aciertoDesplegable');
					$(this).css('background', 'none');
				});
				$(this).parents('.actividadDesplegableSimple:first').find('.numeroAciertosDesplegable').hide();
				$(this).parents('.actividadDesplegableSimple:first').find('.retroalimentacionCorrecta').hide();
			});
		});
		$('.opcionDesplegable').each(function () {
			$(this).click(function () {
				$(this).css('background', 'none');
			});
		});
		//FIN DESPLEGABLE SIMPLE
		//INICIO SELECCIÓN MÚLTIPLE
		//FIN ELECCIÓN MÚLTIPLE
		$('#modalActividades').find('a').attr('target', '_blank');
		$('#modalActividades').find('a').attr('target', '_blank');
		$('form[id^=eleccionMultipleForm]').each(function () {
			obtenerContenidoA = $(this).find('label:eq(0)').html()
			$(this).find('label:eq(0)').html('a) ' + obtenerContenidoA + '')
			obtenerContenidoB = $(this).find('label:eq(1)').html()
			$(this).find('label:eq(1)').html('b) ' + obtenerContenidoB + '')
			obtenerContenidoC = $(this).find('label:eq(2)').html()
			$(this).find('label:eq(2)').html('c) ' + obtenerContenidoC + '')
			obtenerContenidoD = $(this).find('label:eq(3)').html()
			$(this).find('label:eq(3)').html('d) ' + obtenerContenidoD + '')
			obtenerContenidoE = $(this).find('label:eq(4)').html()
			$(this).find('label:eq(4)').html('e) ' + obtenerContenidoE + '')
			obtenerContenidoF = $(this).find('label:eq(5)').html()
			$(this).find('label:eq(5)').html('f) ' + obtenerContenidoF + '')
			obtenerContenidoG = $(this).find('label:eq(6)').html()
			$(this).find('label:eq(6)').html('g) ' + obtenerContenidoG + '')
			obtenerContenidoH = $(this).find('label:eq(7)').html()
			$(this).find('label:eq(7)').html('h) ' + obtenerContenidoH + '')
			obtenerContenidoI = $(this).find('label:eq(8)').html()
			$(this).find('label:eq(8)').html('i) ' + obtenerContenidoI + '')
			obtenerContenidoJ = $(this).find('label:eq(9)').html()
			$(this).find('label:eq(9)').html('j) ' + obtenerContenidoJ + '')
			obtenerContenidoK = $(this).find('label:eq(10)').html()
			$(this).find('label:eq(10)').html('k) ' + obtenerContenidoK + '')
			obtenerContenidoL = $(this).find('label:eq(11)').html()
			$(this).find('label:eq(11)').html('l) ' + obtenerContenidoL + '')
			obtenerContenidoM = $(this).find('label:eq(12)').html()
			$(this).find('label:eq(12)').html('m) ' + obtenerContenidoM + '')
			obtenerContenidoN = $(this).find('label:eq(13)').html()
			$(this).find('label:eq(13)').html('n) ' + obtenerContenidoN + '')
			obtenerContenidoO = $(this).find('label:eq(14)').html()
			$(this).find('label:eq(14)').html('o) ' + obtenerContenidoO + '')
			obtenerContenidoP = $(this).find('label:eq(15)').html()
			$(this).find('label:eq(15)').html('p) ' + obtenerContenidoP + '')
			obtenerContenidoQ = $(this).find('label:eq(16)').html()
			$(this).find('label:eq(16)').html('q) ' + obtenerContenidoQ + '')
			obtenerContenidoR = $(this).find('label:eq(17)').html()
			$(this).find('label:eq(17)').html('r) ' + obtenerContenidoR + '')
			obtenerContenidoS = $(this).find('label:eq(18)').html()
			$(this).find('label:eq(18)').html('s) ' + obtenerContenidoS + '')
			obtenerContenidoT = $(this).find('label:eq(19)').html()
			$(this).find('label:eq(19)').html('t) ' + obtenerContenidoT + '')
			obtenerContenidoU = $(this).find('label:eq(20)').html()
			$(this).find('label:eq(20)').html('u) ' + obtenerContenidoU + '')
			obtenerContenidoV = $(this).find('label:eq(21)').html()
			$(this).find('label:eq(21)').html('v) ' + obtenerContenidoV + '')
			obtenerContenidoW = $(this).find('label:eq(22)').html()
			$(this).find('label:eq(22)').html('w) ' + obtenerContenidoW + '')
			obtenerContenidoX = $(this).find('label:eq(23)').html()
			$(this).find('label:eq(23)').html('x) ' + obtenerContenidoX + '')
			obtenerContenidoY = $(this).find('label:eq(24)').html()
			$(this).find('label:eq(24)').html('y) ' + obtenerContenidoY + '')
			obtenerContenidoZ = $(this).find('label:eq(25)').html()
			$(this).find('label:eq(25)').html('z) ' + obtenerContenidoZ + '')
		});

		$('form[id^=seleccionMultipleForm]').each(function () {
			obtenerContenidoA = $(this).find('label:eq(0)').html()
			$(this).find('label:eq(0)').html('a) ' + obtenerContenidoA + '')
			obtenerContenidoB = $(this).find('label:eq(1)').html()
			$(this).find('label:eq(1)').html('b) ' + obtenerContenidoB + '')
			obtenerContenidoC = $(this).find('label:eq(2)').html()
			$(this).find('label:eq(2)').html('c) ' + obtenerContenidoC + '')
			obtenerContenidoD = $(this).find('label:eq(3)').html()
			$(this).find('label:eq(3)').html('d) ' + obtenerContenidoD + '')
			obtenerContenidoE = $(this).find('label:eq(4)').html()
			$(this).find('label:eq(4)').html('e) ' + obtenerContenidoE + '')
			obtenerContenidoF = $(this).find('label:eq(5)').html()
			$(this).find('label:eq(5)').html('f) ' + obtenerContenidoF + '')
			obtenerContenidoG = $(this).find('label:eq(6)').html()
			$(this).find('label:eq(6)').html('g) ' + obtenerContenidoG + '')
			obtenerContenidoH = $(this).find('label:eq(7)').html()
			$(this).find('label:eq(7)').html('h) ' + obtenerContenidoH + '')
			obtenerContenidoI = $(this).find('label:eq(8)').html()
			$(this).find('label:eq(8)').html('i) ' + obtenerContenidoI + '')
			obtenerContenidoJ = $(this).find('label:eq(9)').html()
			$(this).find('label:eq(9)').html('j) ' + obtenerContenidoJ + '')
			obtenerContenidoK = $(this).find('label:eq(10)').html()
			$(this).find('label:eq(10)').html('k) ' + obtenerContenidoK + '')
			obtenerContenidoL = $(this).find('label:eq(11)').html()
			$(this).find('label:eq(11)').html('l) ' + obtenerContenidoL + '')
			obtenerContenidoM = $(this).find('label:eq(12)').html()
			$(this).find('label:eq(12)').html('m) ' + obtenerContenidoM + '')
			obtenerContenidoN = $(this).find('label:eq(13)').html()
			$(this).find('label:eq(13)').html('n) ' + obtenerContenidoN + '')
			obtenerContenidoO = $(this).find('label:eq(14)').html()
			$(this).find('label:eq(14)').html('o) ' + obtenerContenidoO + '')
			obtenerContenidoP = $(this).find('label:eq(15)').html()
			$(this).find('label:eq(15)').html('p) ' + obtenerContenidoP + '')
			obtenerContenidoQ = $(this).find('label:eq(16)').html()
			$(this).find('label:eq(16)').html('q) ' + obtenerContenidoQ + '')
			obtenerContenidoR = $(this).find('label:eq(17)').html()
			$(this).find('label:eq(17)').html('r) ' + obtenerContenidoR + '')
			obtenerContenidoS = $(this).find('label:eq(18)').html()
			$(this).find('label:eq(18)').html('s) ' + obtenerContenidoS + '')
			obtenerContenidoT = $(this).find('label:eq(19)').html()
			$(this).find('label:eq(19)').html('t) ' + obtenerContenidoT + '')
			obtenerContenidoU = $(this).find('label:eq(20)').html()
			$(this).find('label:eq(20)').html('u) ' + obtenerContenidoU + '')
			obtenerContenidoV = $(this).find('label:eq(21)').html()
			$(this).find('label:eq(21)').html('v) ' + obtenerContenidoV + '')
			obtenerContenidoW = $(this).find('label:eq(22)').html()
			$(this).find('label:eq(22)').html('w) ' + obtenerContenidoW + '')
			obtenerContenidoX = $(this).find('label:eq(23)').html()
			$(this).find('label:eq(23)').html('x) ' + obtenerContenidoX + '')
			obtenerContenidoY = $(this).find('label:eq(24)').html()
			$(this).find('label:eq(24)').html('y) ' + obtenerContenidoY + '')
			obtenerContenidoZ = $(this).find('label:eq(25)').html()
			$(this).find('label:eq(25)').html('z) ' + obtenerContenidoZ + '')
		});
		// FIN ACTIVIDADES
	}
	// DISPARADORES
	$(".disparador").sideNav();
	$('.materialboxed').materialbox();
	$('.tooltipped').tooltip();
	$('.collapsible').collapsible();
	$('.modal').modal({
		complete: function () {
			$('body').css('overflow', 'visible');
		}
	});
	$('.modalComponente').modal({
		dismissible: true,
		opacity: .5,
		inDuration: 0,
		outDuration: 0,
		endingTop: '50%',
		complete: function () {
			$('body').css('overflow', 'visible');
		}
	});
	$('*').click(function () {
		$('.material-tooltip, .backdrop').css('visibility', 'hidden');
	});
	$('.abrirAcordeonCompleto').each(function () {
		numeroNiveles = $(this).parent().find('li').length;
		if (numeroNiveles === 1) {
			$(this).click(function () {
				numeroActive = $(this).parent().find('li.active').length;
				if (numeroActive > 0) {
					$(this).parent().find('ul.collapsible').find('li').removeClass('active').find('.collapsible-body').css('display', 'none');
				} else {
					$(this).parent().find('ul.collapsible').find('li').addClass('active').find('.collapsible-body').css('display', 'block');
				}
			});
		} else {
			$(this).click(function () {
				numeroActive = $(this).parent().find('li.active').length;
				if (numeroActive > 1) {
					$(this).parent().find('ul.collapsible').find('li').removeClass('active').find('.collapsible-body').css('display', 'none');
				} else {
					$(this).parent().find('ul.collapsible').find('li').addClass('active').find('.collapsible-body').css('display', 'block');
				}
			});
		}
	});
	// IMÁGENES ESCALA GRISES
	$('#imgEscalaGrises').click(function () {
		sessionStorageEscalaGrises = sessionStorage.getItem('preferenciasEscalaGrises')
		if (sessionStorageEscalaGrises == "activarEscalaGrises") {
			sessionStorage.setItem('preferenciasEscalaGrises', 'desactivarEscalaGrises');
			$('img').removeClass('escalaGrises');
		} else {
			$('img').addClass('escalaGrises');
			sessionStorage.setItem('preferenciasEscalaGrises', 'activarEscalaGrises');
		}
	});
	//FIN APARIENCIA
	//NAVEGACION POR TECLADO
	$(document).keydown(function (e) {
		if (e.keyCode == 34) {
			//keyCode 34 == AvPag			
			existenciaBotonSiguiente = $('#botonSiguiente').length;
			if (existenciaBotonSiguiente > 0) {
				$('#botonSiguiente').get(0).click();
			}
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 33) {
			//keyCode 33 == RePag
			existenciaBotonSiguiente = $('#botonAnterior').length;
			if (existenciaBotonSiguiente > 0) {
				$('#botonAnterior').get(0).click();
			}
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 36) {
			//keyCode 36 == Inicio			
			$('a[href="1.html"]').get(0).click();
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 35) {
			//keyCode 36 == End			
			$('.menuEscritorio').find('ul').find('li:last').find('a').get(0).click();
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 49) {
			//keyCode 49 == Tecla 1 teclado no numerico	
			// bloquear si el menú anotación está activado o las actividades abiertas
			numeroAnnotatorHide = $('.annotator-hide').length;
			if ((numeroAnnotatorHide > 1) && ($('#modalActividades').is(':visible')) === false) {
				$('.menuEscritorio').find('ul').find('.primerNivel:eq(1)').get(0).click();
			}
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 50) {
			//keyCode 50 == Tecla 2 teclado no numerico	
			// bloquear si el menú anotación está activado o las actividades abiertas
			numeroAnnotatorHide = $('.annotator-hide').length;
			if ((numeroAnnotatorHide > 1) && ($('#modalActividades').is(':visible')) === false) {
				$('.menuEscritorio').find('ul').find('.primerNivel:eq(2)').get(0).click();
			}
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 51) {
			//keyCode 51 == Tecla 3 teclado no numerico
			// bloquear si el menú anotación está activado o las actividades abiertas
			numeroAnnotatorHide = $('.annotator-hide').length;
			if ((numeroAnnotatorHide > 1) && ($('#modalActividades').is(':visible')) === false) {
				$('.menuEscritorio').find('ul').find('.primerNivel:eq(3)').get(0).click();
			}
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 52) {
			//keyCode 52 == Tecla 4 teclado no numerico
			// bloquear si el menú anotación está activado o las actividades abiertas
			numeroAnnotatorHide = $('.annotator-hide').length;
			if ((numeroAnnotatorHide > 1) && ($('#modalActividades').is(':visible')) === false) {
				$('.menuEscritorio').find('ul').find('.primerNivel:eq(4)').get(0).click();
			}
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 53) {
			//keyCode 53 == Tecla 5 teclado no numerico
			// bloquear si el menú anotación está activado o las actividades abiertas
			numeroAnnotatorHide = $('.annotator-hide').length;
			if ((numeroAnnotatorHide > 1) && ($('#modalActividades').is(':visible')) === false) {
				existeRecurso = $('.menuEscritorio').find('ul').find('.primerNivel:eq(5)').length
				if (existeRecurso > 0) {
					$('.menuEscritorio').find('ul').find('.primerNivel:eq(5)').get(0).click();
				} else {
					console.log('No existe ese nivel');
				}
			}
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 54) {
			//keyCode 54 == Tecla 6 teclado no numerico
			// bloquear si el menú anotación está activado o las actividades abiertas
			numeroAnnotatorHide = $('.annotator-hide').length;
			if ((numeroAnnotatorHide > 1) && ($('#modalActividades').is(':visible')) === false) {
				existeRecurso = $('.menuEscritorio').find('ul').find('.primerNivel:eq(6)').length
				if (existeRecurso > 0) {
					$('.menuEscritorio').find('ul').find('.primerNivel:eq(6)').get(0).click();
				} else {
					console.log('No existe ese nivel');
				}
			}
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 55) {
			//keyCode 55 == Tecla 7 teclado no numerico	
			// bloquear si el menú anotación está activado o las actividades abiertas
			numeroAnnotatorHide = $('.annotator-hide').length;
			if ((numeroAnnotatorHide > 1) && ($('#modalActividades').is(':visible')) === false) {
				existeRecurso = $('.menuEscritorio').find('ul').find('.primerNivel:eq(7)').length
				if (existeRecurso > 0) {
					$('.menuEscritorio').find('ul').find('.primerNivel:eq(7)').get(0).click();
				} else {
					console.log('No existe ese nivel');
				}
			}
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 56) {
			//keyCode 56 == Tecla 8 teclado no numerico
			// bloquear si el menú anotación está activado o las actividades abiertas
			numeroAnnotatorHide = $('.annotator-hide').length;
			if ((numeroAnnotatorHide > 1) && ($('#modalActividades').is(':visible')) === false) {
				existeRecurso = $('.menuEscritorio').find('ul').find('.primerNivel:eq(8)').length
				if (existeRecurso > 0) {
					$('.menuEscritorio').find('ul').find('.primerNivel:eq(8)').get(0).click();
				} else {
					console.log('No existe ese nivel');
				}
			}
		};
	});
	$(document).keydown(function (e) {
		if (e.keyCode == 57) {
			//keyCode 57 == Tecla 9 teclado no numerico
			// bloquear si el menú anotación está activado o las actividades abiertas
			numeroAnnotatorHide = $('.annotator-hide').length;
			if ((numeroAnnotatorHide > 1) && ($('#modalActividades').is(':visible')) === false) {
				existeRecurso = $('.menuEscritorio').find('ul').find('.primerNivel:eq(9)').length
				if (existeRecurso > 0) {
					$('.menuEscritorio').find('ul').find('.primerNivel:eq(9)').get(0).click();
				} else {
					console.log('No existe ese nivel');
				}
			}
		};
	});
})
// PRELOADER
$(window).bind('load', function () {
	setTimeout(function(){
		$('.preloaderPagina').fadeOut('fast');
	}, 300)	
	$('body').css('overflow', 'visible');
	setTimeout(function () {
		$('.annotator-hl').each(function () {
			recogerDataAnnotationId = $(this).attr('data-annotation-id')
			busquedaIdLocalStorage = localStorage.getItem('annotator.offline/annotation.' + recogerDataAnnotationId + '')
			parsearDatosLocalStorage = JSON.parse(busquedaIdLocalStorage);
			textoLocalStorage = parsearDatosLocalStorage.text
			if (textoLocalStorage === "Subrayado") {
				$('[data-annotation-id="' + recogerDataAnnotationId + '"]').addClass('forzarSubrayado');
			}
		});
	}, 800);
	setTimeout(function () {
		$('.annotator-cancel').removeClass('annotator-button');
		$('.annotator-save').removeClass('annotator-button');
		$('img[alt="QR"]').hide();
	}, 300);
	$('.collapsible').find('.envoltorioComponenteFlotante').css('clear', 'none');
	//MODAL AYUDA
	$('#disparadorModalAyuda').click(function (e) {
		e.preventDefault();
		$('#modalAyuda').modal('open');
	});
	// FIN MODAL AYUDA
	recordarUltimaPaginaVisitada()

});
$(document).ready(function () {
	// AGRUPACION ACTIVIDADES ELECCION MÚLTIPLE
	$('.disparadorActividades').click(function () {
		numeroActividadesEleccionMultiple = $('.envoltorioActividadEleccionMultiple').length;
		if (numeroActividadesEleccionMultiple > 1) {
			$('.envoltorioActividadEleccionMultiple').each(function () {
				$(this).find('.identificadorActividadEleccionMultiple').wrap('<div class="envoltorioProvisionalEleccionMultiple"></div>').html();
				recogerHTML = $(this).find('.envoltorioProvisionalEleccionMultiple').html()
				arrayActividadesEleccionMultiple.push(recogerHTML)
			});
			obtenerCodigoCompletoEleccionMultiple = arrayActividadesEleccionMultiple.join('||||')
			regexLimpiezaEleccionMultiple = /\|\|\|\|/g;
			obtenerCodigoDepuradoEleccionMultiple = obtenerCodigoCompletoEleccionMultiple.replace(regexLimpiezaEleccionMultiple, '');
			$('#modalActividades').find('h4:first').after('<div class="envoltorioActividad"><p><strong>Actividad de elección múltiple</strong></p>' + obtenerCodigoDepuradoEleccionMultiple + '</div>')
			$('.envoltorioActividadEleccionMultiple').remove();
			$('.disparadorComprobarEleccion').each(function () {
				$(this).click(function () {
					debeSeleccionarse = $(this).parents('.identificadorActividadEleccionMultiple:first').find('input:checked').attr('data-debeseleccionarse')
					debeSeleccionarse = debeSeleccionarse.toUpperCase()
					if (debeSeleccionarse[0] === "S") {
						$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
						$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
						$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').show()
					} else {
						$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
						$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
						$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionIncorrecta:first').show()
					}
				});
			});
			$('.disparadorSolucionarEleccion').each(function () {
				$(this).click(function () {
					$(this).parents('.identificadorActividadEleccionMultiple:first').find('input').each(function () {
						var selector = $(this)
						debeSeleccionarse = $(this).attr('data-debeseleccionarse')
						debeSeleccionarse = debeSeleccionarse.toUpperCase()
						if (debeSeleccionarse[0] === "S") {
							$(this).get(0).click()
							$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
							$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
							$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').show()
						}
					});
				});
			});
			$('.disparadorBorrarEleccion').each(function () {
				$(this).click(function () {
					$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
					$(this).parents('.identificadorActividadEleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
					$(this).parents('.identificadorActividadEleccionMultiple:first').find('input:checked').prop('checked', false)
				});
			});
		}
		numeroActividadesSeleccionMultiple = $('.envoltorioActividadSeleccionMultiple').length;
		if (numeroActividadesSeleccionMultiple > 1) {
			$('.envoltorioActividadSeleccionMultiple').each(function () {
				$(this).find('.identificadorActividadSeleccionMultiple').wrap('<div class="envoltorioProvisionalSeleccionMultiple"></div>').html();
				recogerHTML = $(this).find('.envoltorioProvisionalSeleccionMultiple').html()
				arrayActividadesSeleccionMultiple.push(recogerHTML)
			});
			obtenerCodigoCompletoSeleccionMultiple = arrayActividadesSeleccionMultiple.join('||||')
			regexLimpiezaSeleccionMultiple = /\|\|\|\|/g;
			obtenerCodigoDepuradoSeleccionMultiple = obtenerCodigoCompletoSeleccionMultiple.replace(regexLimpiezaSeleccionMultiple, '');
			$('#modalActividades').find('h4:first').after('<div class="envoltorioActividad"><p><strong>Actividad de selección múltiple</strong></p>' + obtenerCodigoDepuradoSeleccionMultiple + '</div>')
			$('.envoltorioActividadSeleccionMultiple').remove();
			var presuponerAcierto = true;
			$('.disparadorComprobarSeleccion').each(function () {
				$(this).click(function () {
					presuponerAcierto = true;
					$(this).parents('.identificadorActividadSeleccionMultiple:first').find('input').each(function () {
						recogerSeleccion = $(this).is(':checked');
						recogerSeleccionAdecuada = $(this).attr('data-debeseleccionarse');
						recogerSeleccionAdecuada = recogerSeleccionAdecuada.toUpperCase();
						if (recogerSeleccion === true && recogerSeleccionAdecuada[0] === "S") { } else if (recogerSeleccion === false && recogerSeleccionAdecuada[0] === "N") { } else {
							presuponerAcierto = false;
						}
					});
					if (presuponerAcierto === true) {
						$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
						$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
						$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').show()
					} else {
						$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
						$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
						$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionIncorrecta:first').show()
					}
				});
			})
			$('.disparadorSolucionarSeleccion').each(function () {
				$(this).click(function () {
					$(this).parents('.identificadorActividadSeleccionMultiple:first').find('input').each(function () {
						recogerAttrRespuestaCorrecta = $(this).attr('data-debeseleccionarse');
						recogerAttrRespuestaCorrecta = recogerAttrRespuestaCorrecta.toUpperCase()
						recogerSeleccion = $(this).is(':checked');
						if (recogerAttrRespuestaCorrecta[0] === "S" && recogerSeleccion === true) { } else if (recogerAttrRespuestaCorrecta[0] === "S" && recogerSeleccion === false) {
							$(this).click()
						} else if (recogerAttrRespuestaCorrecta[0] === "N" && recogerSeleccion === true) {
							$(this).click()
						} else if (recogerAttrRespuestaCorrecta[0] === "N" && recogerSeleccion === false) { }
					});
					$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
					$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
					$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').show()
				});
			})
			$('.disparadorBorrarSeleccion').each(function () {
				$(this).click(function () {
					$(this).parents('.identificadorActividadSeleccionMultiple:first').find('input').each(function () {
						recogerSeleccion = $(this).is(':checked');
						if (recogerSeleccion === true) {
							$(this).click()
						}
					});
					$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionCorrecta:first').hide()
					$(this).parents('.identificadorActividadSeleccionMultiple:first').find('.retroalimentacionIncorrecta:first').hide()
				});
			})
		}
		// DISPARADOR TOOLTIP después de recarga DOM actividades
		$('.tooltipped').tooltip();
	});
	$('.disparadorActividades').one('click',function () {
		embeberVideosYoutube('envoltorioActividad')
	})
	// FIN AGRUPACION ACTIVIDADES ELECCION MÚLTIPLE
	// ICONOS DE ACTIVIDADES EN MENÚ
	$('.contenidoActividades').find('h5').each(function () {
		recogerTexto = $(this).text().replace(/\s+/g, '');
		regexPantallaMenuEscritorio = /.*\*pantalla\*.*/gi
		comprobarRegexPantallaMenuEscritorio = regexPantallaMenuEscritorio.test(recogerTexto)
		if (comprobarRegexPantallaMenuEscritorio) {
			obtenerNumeroPantallaMenuEscritorio = recogerTexto.replace(/.*\*pantalla\*([0-9]{1,3}).*/gi, '$1')
			obtenerNumeroPantallaMenuEscritorioNumero = parseInt(obtenerNumeroPantallaMenuEscritorio) + 1
			$('.menuEscritorio').find('ul:first').find('li:eq(' + obtenerNumeroPantallaMenuEscritorioNumero + ')').find('a').append('<i class="material-icons tiny" style="position:relative;top:2px;margin-left:5px;">touch_app</i>');
		}

		//MENU ESCRITORIO
		longitudMenu = $('.menuEscritorio ').find('ul').find('li').length;
		for (i = 0; i < longitudMenu; i++) {
			recogerTextoMenu = $('.menuEscritorio ').find('ul').find('li:eq(' + i + ')').text();
			recogerTextoMenuDepurado = recogerTextoMenu.replace(/\s+/g, '');
			if (recogerTexto === recogerTextoMenuDepurado) {
				$('.menuEscritorio ').find('ul').find('li:eq(' + i + ')').find('a').append('<i class="material-icons tiny" style="position:relative;top:2px;margin-left:5px;">touch_app</i>');
			}
		}
	});
	$('.menuEscritorio').find('ul:first').find('a').each(function () {
		numeroIconos = $(this).find('.tiny').length;
		if (numeroIconos > 1) {
			$(this).find('i').remove();
			$(this).append('<i class="material-icons tiny" style="position:relative;top:2px;margin-left:5px;">touch_app</i>');
		}
	})
	$('.contenidoActividades').find('h5').each(function () {
		recogerTextoMovil = $(this).text().replace(/\s+/g, '');
		regexPantallaMenuMovil = /.*\*pantalla\*.*/gi
		comprobarRegexPantallaMenuMovil = regexPantallaMenuMovil.test(recogerTextoMovil)
		if (comprobarRegexPantallaMenuMovil) {
			obtenerNumeroPantallaMenuMovil = recogerTexto.replace(/.*\*pantalla\*([0-9]{1,3}).*/gi, '$1')
			obtenerNumeroPantallaMenuMovil = parseInt(obtenerNumeroPantallaMenuMovil) + 1
			$('#menuLateralIzquierda').find('li:eq(' + obtenerNumeroPantallaMenuMovil + ')').find('a').append('<i class="material-icons tiny" style="position:relative;top:2px;margin-left:5px;">touch_app</i>');
		}
		//MENU MOVIL
		longitudMenuMovil = $('#menuLateralIzquierda').find('li').length;
		for (i = 0; i < longitudMenuMovil; i++) {
			recogerTextoMenuMovil = $('#menuLateralIzquierda').find('li:eq(' + i + ')').find('a').text();
			recogerTextoMenuDepuradoMovil = recogerTextoMenuMovil.replace(/\s+/g, '');
			if (recogerTextoMovil === recogerTextoMenuDepuradoMovil) {
				$('#menuLateralIzquierda').find('li:eq(' + i + ')').find('a').append('<i class="material-icons tiny" style="float:none;position:relative;top:2px;margin-left:5px;">touch_app</i>');
			}
		}
	});
	$('.menuLateralIzquierda').find('a').each(function () {
		numeroIconosMovil = $(this).find('.tiny').length;
		if (numeroIconosMovil > 1) {
			$(this).find('i').remove();
			$(this).append('<i class="material-icons tiny" style="position:relative;top:2px;margin-left:5px;">touch_app</i>');
		}
	})
	// FIN ICONOS DE ACTIVIDADES EN MENÚ
	// IMÁGENES ESCALA GRISES
	eleccionEscalaGrises = sessionStorage.getItem('preferenciasEscalaGrises')
	if (eleccionEscalaGrises === 'activarEscalaGrises') {
		$('img').addClass('escalaGrises');
	}
	// FIN IMÁGENES ESCALA DE GRISES	
	// SPAN EN TAG A Y DISPLAY EN LÍNEA
	$('.espacioContenido').find('a').each(function () {
		$(this).find('span').css('display', 'inline');
	});
	// INICIO CORRECCIÓN NOTAS AL PIE
	existenciaNotasPie = $('.footnote-ref').length
	if (existenciaNotasPie > 0) {
		busquedaNotas = $('.menuEscritorio').children('ul').children('li:last').text();
		regexNotasPie = /^Notas a.{0,2}pie/
		comprobarRegexNotasPie = regexNotasPie.test(busquedaNotas)
		if (comprobarRegexNotasPie === true) {
			direccionNotas = $('.menuEscritorio').children('ul').children('li:last').children('a').attr('href');
			$('.espacioContenido').append('<div id="envoltorioNotasPie"></div>')
			$("#envoltorioNotasPie").load(direccionNotas + ' .footnotes', function () {
				$('#envoltorioNotasPie').find('ol').hide()
				$('#envoltorioNotasPie').find('hr').attr('style', 'width: 33%;margin: 30px auto 30px auto;')
				arrayNotasPiePagina = [];
				$('.footnote-ref').each(function () {
					numeroNotaPie = $(this).children('sup').html();
					arrayNotasPiePagina.push(numeroNotaPie)
				})

				for (incrementadorNotas = 0; incrementadorNotas < arrayNotasPiePagina.length; incrementadorNotas++) {
					numeroBusqueda = parseInt(arrayNotasPiePagina[incrementadorNotas]) - 1;
					recuperarContenido = $('#envoltorioNotasPie').find('ol').find('li').eq(numeroBusqueda).html();
					recuperarContenido = recuperarContenido.replace(new RegExp("<p.*?>", "gm"), "")
					recuperarContenido = recuperarContenido.replace(new RegExp("</p>", "gm"), "")
					$('#envoltorioNotasPie').append('<p style="font-size:small"><sup>' + arrayNotasPiePagina[incrementadorNotas] + '</sup> ' + recuperarContenido + '</p>')
				}
			})
			$('.footnote-ref').each(function () {
				$(this).attr('href', '#envoltorioNotasPie').removeAttr('target');
			})
		}
	}
	// CORRECCIÓN AL PIE
	if ($('.menuEscritorio').children('ul').children('li:last').text() === 'Notas al pie') {
		$('.menuEscritorio').children('ul').children('li:last').find('a').text('Notas a pie');
	}
	primerEncabezado = $('.espacioContenido').find(':header').first().text()
	if (primerEncabezado === "5. Notas al pie") {
		$('.espacioContenido').find(':header').first().text('Notas a pie')
		document.title = '5. Notas a pie';
		$('#menuLateralIzquierda').children('li:last').find('a').text('Notas a pie')
	}
	var recogerTitulo = document.title
	regexApartadoRecursosBibliograficos = /.*?ecursos .ibliogr.ficos.*/
	comprobarRegexApartadoRecursosBibliograficos = regexApartadoRecursosBibliograficos.test(recogerTitulo)
	if (comprobarRegexApartadoRecursosBibliograficos) {
		$('head').append('<style>.espacioContenido a, .espacioContenido a span {word-break:break-all}</style>')
	}
	// ROMPER ENLACES BIBLIOGRAFÍA
	var recogerTitulo = document.title	
	regexApartadoRecursosBibliograficos = /.*?ecursos .ibliogr.ficos.*/
	comprobarRegexApartadoRecursosBibliograficos = regexApartadoRecursosBibliograficos.test(recogerTitulo)
	if (comprobarRegexApartadoRecursosBibliograficos) {	
		$('head').append('<style>.collapsible a {word-break:break-word !important}</style>')
	}
	// VIÑETAS Y COMPONENTES
	$('.componenteIzquierda').each(function(){
		averiguarPrevio = $(this).prev()[0].localName
		if ((averiguarPrevio === 'ul') || (averiguarPrevio === 'ol')) {
			$(this).prev().css('margin-left', '85px')
		}
	})
});

var speechSynthesisInstance;

function read(){
        var miAudio = document.getElementById("miAudio");

	if(miAudio && miAudio.readyState >=2){
		if (miAudio.paused) {
			miAudio.play();
		} else {
			miAudio.pause();
		}
	}else{
		if ('speechSynthesis' in window) {
			var textoCompleto = '';

			const elementosEspacioContenido = document.querySelectorAll('.annotator-wrapper');
			elementosEspacioContenido.forEach(elemento => {
					textoCompleto += elemento.textContent;
					});


			const synthesis = window.speechSynthesis;
			const utterance = new SpeechSynthesisUtterance();
			utterance.text = textoCompleto;
			utterance.lang = 'es-ES';
			utterance.rate = 1.0;
			utterance.volume = 1.0;
			synthesis.speak(utterance);
		} else {
			console.error('La API de síntesis de voz no está disponible en este navegador.');
		}
	}
}


let escuchandoTeclas = false;

function toggleEscuchaTeclas() {
	escuchandoTeclas = !escuchandoTeclas;
	actualizarIcono();
}

function buttons() {
	document.addEventListener('keydown', function(evento) {
		if (!escuchandoTeclas){
			if (evento.key === 'ArrowUp' || evento.key === 'ArrowDown') {
				evento.preventDefault();
			}
			return;
		}

		var paginador = document.getElementById('paginador');
		var botonesPagina = paginador.querySelectorAll('.page-btn');

		// Obtener el índice del botón seleccionado
		var indiceSeleccionado = Array.from(botonesPagina).findIndex(function(boton) {
			return boton.classList.contains('selected');
		});

		if (evento.key === 'ArrowRight') {
			if (indiceSeleccionado < botonesPagina.length - 1) {
				botonesPagina[indiceSeleccionado + 1].click();
			} else {
				document.getElementById('botonSiguiente').click();
			}
		} else if (evento.key === 'ArrowLeft') {
			// Ir a la página anterior
			if (indiceSeleccionado > 0) {
				botonesPagina[indiceSeleccionado - 1].click();
			}else {
				document.getElementById('botonAnterior').click();
			}
		}

	});
}

function actualizarIcono() {
	const icono = document.getElementById('iconoEstado');
	if (escuchandoTeclas) {
		icono.textContent = 'toggle_on';
		icono.setAttribute('aria-label', 'Funcionalidad activada');
		icono.classList.remove('icono-inactivo');
		icono.classList.add('icono-activo');
	} else {
		icono.textContent = 'toggle_off';
		icono.setAttribute('aria-label', 'Funcionalidad desactivada');
		icono.classList.remove('icono-activo');
		icono.classList.add('icono-inactivo');
	}
}

function cargarBotonPaginaTest() {
	var titulo = document.querySelector('h1').innerText;
	var respuestasGuardadas = JSON.parse(localStorage.getItem('respuestasGuardadas_' + titulo));
	if (respuestasGuardadas) {
		respuestasGuardadas.forEach(function(respuestaId) {
			var respuesta = document.getElementById(respuestaId);
			if (respuesta) {
				respuesta.checked = true;
			}
		});
	}
      var boton = document.getElementById('botonResponder');
      boton.style.display = 'block'; // Puedes usar 'inline-block' si prefieres ese estilo
}

function guardarRespuestas() {
	var titulo = document.querySelector('h1').innerText;
	var respuestasMarcadas = document.querySelectorAll('input[type="checkbox"]:checked');
	var respuestasGuardadas = [];
	respuestasMarcadas.forEach(function(respuesta) {
		respuestasGuardadas.push(respuesta.id);
	});
	localStorage.setItem('respuestasGuardadas_' + titulo, JSON.stringify(respuestasGuardadas));
}

function comprobarRespuestas() {
	var respuestasCorrectas = document.querySelectorAll('input[type="checkbox"].opcion_correcta');
	var respuestasIncorrectas = document.querySelectorAll('input[type="checkbox"].opcion_incorrecta:checked');
	var correctasNoSeleccionadas = [];

	respuestasCorrectas.forEach(function(respuesta) {
		if (!respuesta.checked) {
			correctasNoSeleccionadas.push(respuesta.id);
		}
	});

	if (respuestasIncorrectas.length > 0 || correctasNoSeleccionadas.length > 0) {
		alert("¡No es correcto!");
	} else {
		alert("¡Todas las respuestas seleccionadas son correctas!");
	}

	guardarRespuestas();
}

function changePage(pageNumber) {
	var pages = document.querySelectorAll('.page');
	pages.forEach(function(page) {
		page.classList.remove('active');
	});
	// Muestra la página seleccionada
	var pageId = 'page' + pageNumber;
	var selectedPage = document.getElementById(pageId);
	selectedPage.classList.add('active');

	var buttons = document.querySelectorAll('.page-btn');
	buttons.forEach(function(button) {
			if (button.textContent === pageNumber.toString()) {
			button.classList.add('selected');
			} else {
			button.classList.remove('selected');
			}
			});
}

function generarPaginacion() {
	var paginador = document.getElementById('paginador');
	paginador.innerHTML = ''; // Limpiar el contenido existente

	var pages = document.querySelectorAll('[class^="page"]');

	// Recorrer cada elemento y crear un botón de paginación para él
	pages.forEach(function(page, index) {
		var pageNumber = index + 1;
		var button = document.createElement('button');
		button.textContent = pageNumber;
		button.className = 'page-btn';
		button.onclick = function() {
			changePage(pageNumber);
		};
		paginador.appendChild(button);
	});

	// Mostrar el paginador
	paginador.style.display = 'block';

	var firstButton = document.querySelector('.page-btn');
	if (firstButton) {
		firstButton.classList.add('selected');
	}
}
	    

buttons()
	toggleEscuchaTeclas()
