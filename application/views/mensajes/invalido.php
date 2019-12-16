<body onload="openerror()">
</body>
<script>
    function openerror(){
        swal('Falló',
			'Es una petición no válida.',
			'error')
.then((value) => {
    window.history.back();
});
	    
        
 }
 </script>