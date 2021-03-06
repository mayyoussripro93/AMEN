! function(a) {
	"use strict";

	function b(a) {
		this.local = this.regionalOptions[a || ""] || this.regionalOptions[""]
	}
	b.prototype = new a.calendars.baseCalendar, a.extend(b.prototype, {
		name: "Islamic",
		jdEpoch: 1948439.5,
		daysPerMonth: [30, 29, 30, 29, 30, 29, 30, 29, 30, 29, 30, 29],
		hasYearZero: !1,
		minMonth: 1,
		firstMonth: 1,
		minDay: 1,
		regionalOptions: {
			"": {
				name: "Islamic",
				epochs: ["BH", "AH"],
				monthNames: ["محرم", "صفر", "ربيع الاول", "ربيع التانى", "جماد الاول", "جماد التانى", "رجب", "شعبان", "رمضان", "شوال", "ذو القعدة", "ذو الحجة"],
				monthNamesShort: ["Muh", "Saf", "Rab1", "Rab2", "Jum1", "Jum2", "Raj", "Sha'", "Ram", "Shaw", "DhuQ", "DhuH"],
				dayNames: ["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"],
				dayNamesShort:["الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"],
				dayNamesMin:["أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت"],
				digits: null,
				dateFormat: "yyyy/mm/dd",
				firstDay: 6,
				isRTL: !1
			}
		},
		leapYear: function(b) {
			var c = this._validate(b, this.minMonth, this.minDay, a.calendars.local.invalidYear);
			return (11 * c.year() + 14) % 30 < 11
		},
		weekOfYear: function(a, b, c) {
			var d = this.newDate(a, b, c);
			return d.add(-d.dayOfWeek(), "d"), Math.floor((d.dayOfYear() - 1) / 7) + 1
		},
		daysInYear: function(a) {
			return this.leapYear(a) ? 355 : 354
		},
		daysInMonth: function(b, c) {
			var d = this._validate(b, c, this.minDay, a.calendars.local.invalidMonth);
			return this.daysPerMonth[d.month() - 1] + (12 === d.month() && this.leapYear(d.year()) ? 1 : 0)
		},
		weekDay: function(a, b, c) {
			return 5 !== this.dayOfWeek(a, b, c)
		},
		toJD: function(b, c, d) {
			var e = this._validate(b, c, d, a.calendars.local.invalidDate);
			return b = e.year(), c = e.month(), d = e.day(), b = b <= 0 ? b + 1 : b, d + Math.ceil(29.5 * (c - 1)) + 354 * (b - 1) + Math.floor((3 + 11 * b) / 30) + this.jdEpoch - 1
		},
		fromJD: function(a) {
			a = Math.floor(a) + .5;
			var b = Math.floor((30 * (a - this.jdEpoch) + 10646) / 10631);
			b = b <= 0 ? b - 1 : b;
			var c = Math.min(12, Math.ceil((a - 29 - this.toJD(b, 1, 1)) / 29.5) + 1),
				d = a - this.toJD(b, c, 1) + 1;
			return this.newDate(b, c, d)
		}
	}), a.calendars.calendars.islamic = b
}(jQuery);
//# sourceMappingURL=jquery.calendars.islamic.min.map