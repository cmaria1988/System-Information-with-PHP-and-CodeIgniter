$(document).ready(function(){
	$('input[type="checkbox"]').change(function(){ 
		pilih = 0;
		a= this.name;
		if(this.checked == true){
			pilih = 1;
		}
		level = $('select[name="idlevel"]').val();
	   $.ajax({
			url: base_url + '/toko/Levelmenu/simpan/',
			type: "POST",
			data: {name:this.name,value:this.value,pilih:pilih,level:level},
			dataType: 'json'
		});
	});
});	
