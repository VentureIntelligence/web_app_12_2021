// JavaScript Document

function Show(id) {
	$(id).style.display = 'block';
	$(id+'minus').style.display = 'block';
	$(id+'plus').style.display = 'none';
}
function Hide(id) {
	$(id).style.display = 'none';
	$(id+'plus').style.display = 'block';
	$(id+'minus').style.display = 'none';
}

