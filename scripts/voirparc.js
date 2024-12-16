var hps = document.getElementById("hpstab");
hps.addEventListener(
	"click",
	function (e) {
		tr = e.target.closest("tr");
		if (tr) {
			index = tr.rowIndex;
			if (hps.rows[index]) {
				id = hps.rows[index].id;
				if (id) {
					window.location.href = "?voirmachine/" + id;
				}
			}
		}
	},
	false
);
