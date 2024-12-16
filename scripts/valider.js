function validerSearch() {
	var a = document.getElementById("search").value;
	if (a.length < 2) {
		alert("2 Caractères minimum, majuscules non prises en compte.");
		return false;
	} else return true;
}
