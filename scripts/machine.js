var hps = document.getElementById("hpstab");
hps.addEventListener(
	"click",
	function (e) {
		event = e.target;
		index = event.parentElement.rowIndex;
		if (hps.rows[index]) {
			id = hps.rows[index].id;
			if (id) {
				document.getElementById("hpi").value = id;
				p0 = hps.rows[index].cells[0].innerHTML;
				p1 = hps.rows[index].cells[0].getAttribute("data-gen");
				p2 = hps.rows[index].cells[0].getAttribute("data-sta");
				document.getElementById("hp0").value = p0;
				document.getElementById("hp1").value = p1;
				document.getElementById("hp2").value = p2;
			}
		}
	},
	false
);
