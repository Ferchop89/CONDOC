function showDate(nombre) {
	var hoy = new Date();
	var dd = hoy.getDate();
	var mm = hoy.getMonth()+1;
	var yyyy = hoy.getFullYear();

	if(dd<10) {
	    dd = '0'+dd
	} 
	if(mm<10) {
	    mm = '0'+mm
	} 

	fecha = dd + '/' + mm + '/' + yyyy;
	document.getElementById(nombre).value = fecha;
}