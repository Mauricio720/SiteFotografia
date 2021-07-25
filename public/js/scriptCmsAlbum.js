ONLY_HTMLELEMENT('#fotoAlbumFile').style.display='none';

ONLY_HTMLELEMENT('#fotoAlbum').addEventListener('click',(e)=>{
	e.preventDefault();
	$('#fotoAlbumFile').trigger('click');

	$('#fotoAlbumFile').change(function(e){
   		if($(e.target).val()){
     	 	var img = e.target.files[0];
    	 	var f = new FileReader(); 
   		    f.onload = function(e){ 
         	$("#fotoAlbum img").attr("src",e.target.result); // altera o src da imagem
      	}
      	f.readAsDataURL(img);
 		}
 	});
});

tinymce.init({
    selector:'#fichaTecnica',
	menubar:false,
    plugins:['link', 'table', 'autoresize', 'lists'],
    toolbar:'undo redo | formatselect | bold italic backcolor | '
            +'alignleft alignright aligncenter alignjustify | table |'
            +'link image | bullist numlist | media',
});
      

