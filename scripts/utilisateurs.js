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
				p5 = hps.rows[index].cells[1].innerHTML;
				p2 = hps.rows[index].cells[2].getAttribute("data-sta");
				p3 = hps.rows[index].cells[3].getAttribute("data-gra");
				p4 = hps.rows[index].cells[6].getAttribute("data-ema");
				document.getElementById("hp0").value = p0;
				document.getElementById("hp2").value = p2;
				document.getElementById("hp3").value = p3;
				document.getElementById("hp4").value = p4;
				document.getElementById("hp5").value = p5;
			}
		}
	},
	false
);

function gmdp() {
	document.getElementById("hp1").value = (Math.random(1) * 65535) & 65535;
}
