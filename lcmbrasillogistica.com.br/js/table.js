$(document).ready(function(){
	$(".data-table").dataTable({
		"oLanguage": {
			"sSearch": "Pesquisar:",
			"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
			"Show": "Mostrar:"
		},
		//"sScrollY": "200px",
		//"sScrollX": "100%",
		//"sScrollXInner": "100%",
		"bPaginate": true,
		"aaSorting": [[0,"asc"]],
		"sPaginationType": "two_button"
	});
	$(".dataTables_filter").addClass('row');
	$(".dataTables_filter label").first().focus().addClass('four columns');
});