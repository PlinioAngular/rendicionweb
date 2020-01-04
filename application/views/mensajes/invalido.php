<body onload="openerror()">
</body>
<script>
var mensaje="<?= $mensaje;  ?>";
    function openerror(){
        swal('Falló',
			'Es una petición no válida.'+mensaje,
			'error')
.then((value) => {
    if(mensaje==""){
        window.history.back();
    }else{
        window.location.href = '<?= base_url(); ?>'
    }
    
});
	    
        
 }
 </script>