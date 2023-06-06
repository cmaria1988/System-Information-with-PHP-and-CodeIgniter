$(document).ready(function(){
	//ambil no penjualan
	if($('#transaksiid').val()==''){
		$.getJSON(base_url+'/toko/Penjualan/getNoPenjualan', function(data) {
			$('#transaksiid').val(data.kode);
		});
	}
	//panggil datepicker
	$('#tanggal').datepicker({
	 format: 'yyyy-mm-dd',
	 autoclose:true,
	 endDate:'0d'
	});
});
function inputbarangx(){
	qty = $('#qty').val();
	kode = $('#produkid').val();
	if(kode==''){
		alert('barang belum dipilih');
	}else{
		if($.isNumeric(qty)){
			
			$.post(base_url+'/toko/Penjualan/getDataProduk',{'id':kode},function(data){
				//alert(data);
				kdbrg = data.produkid;
				nmbrg = data.nama;
				harga = parseInt(data.hargajual);
				stok = data.stok;
				if(parseInt(qty) > parseInt(stok)){
					alert('Stok Sisa '+stok);
				}else{
					subtotal = harga * qty;
					if($("#listbrg_"+kdbrg).length > 0) {
					//if exists remove first
						$("#listbrg_"+kdbrg).remove();
					}
					row = '<tr id="listbrg_'+kdbrg+'">';
					row += '<td>'+kdbrg+'<input type="hidden" name="kdbrgjual[]" id="kdbrgjual_'+kdbrg+'" value="'+kdbrg+'" readonly></td>';
					row += '<td>'+nmbrg+'</td>';
					row += '<td><input type="number" width="4" size="4" name="qtyjual[]" id="qtyjual_'+kdbrg+'" value="'+qty+'"</td>';
					row += '<td>'+harga+'<input type="hidden" name="hargajual[]" id="hargajual_'+kdbrg+'" value="'+harga+'" readonly></td>';
					row += '<td align="right"><span id="spantotaljual_'+kdbrg+'" class="totaljual">'+subtotal+'</span></td>';
					row += '<td><a href="#linkdata" onclick=hapuslist("'+kdbrg+'") title="hapus" alt="hapus"><i class="fas fa-trash"></i></a>&nbsp;&nbsp;<a href="#linkdata" onclick=savelist("'+kdbrg+'") title="simpan" alt="simpan"><i class="fas fa-save"></i></a></td>';
					row += '</tr>';
	
					$('#tabeldata tbody').append(row);
					hitungulang();
				}
					
			},'json');
		}else{
			alert('Qty harus berupa angka');
			$('#quantity').val('').focus();
		}
	}
} 
//hapus list penjualan berdasarkan barang
function hapuslist(id){
	if(confirm('Apakah anda yakin akan menghapus data?')){
		idrow = "listbrg_"+id;
		$('#'+idrow).hide().remove();
		hitungulang();
	}
}
//simpan list penjualan berdasarkan barang
function savelist(id){
	idrow = "listbrg_"+id;
	harga = $('#hargajual_'+id).val();
	kdbrg = $('#kdbrgjual_'+id).val();
	qty = parseInt($('#qtyjual_'+id).val());
	//cek dulu nih stok ada gak?
	$.post(base_url+'/toko/Penjualan/getDataBarang',{'id':kdbrg},function(data){
		kdbrg = data.kdbarang;
		nmbrg = data.nmbarang;
		harga = parseInt(data.harga);
		stok = data.stok;
		if(parseInt(qty) > parseInt(stok)){
			$('#qtyjual_'+id).val(parseInt(qty));
			alert('Stok Sisa '+stok);
		}else{
			totalharga = harga * qty;
			$('#spantotaljual_'+id).html(totalharga);
			hitungulang();
		}
	},'json');
	
}
//munculkan grand total
function hitungulang(){
	totaljual = 0;
	
	$('.totaljual').each(function(){
	subtotal = $(this).text()
		if($.isNumeric(subtotal)){
			totaljual = totaljual + parseInt(subtotal);
		 }
	});
	$('#grandtotal').html(totaljual);
	$('#hidgrandtotal').val(totaljual);
}
//popup penjualan
function carinopenjualan(){
	$('#divpopup').modal('show');
}
//saat dipilih salah satu no penjualan, pindah ke functin tampil
function pilihpenjualan(no){
	lokasi = base_url+'/toko/Penjualan/tampil/'+no;
	document.location = lokasi;
}
function backbutton(){
	lokasi = base_url+'/toko/Penjualan/'
	document.location = lokasi;
}
