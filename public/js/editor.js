$(()=>{
    var blockStyle1=$('.blockStyle--style1').eq(0);
    var blockStyle2=$('.blockStyle--style2').eq(0);
    var blockStyle3=$('.blockStyle--style3').eq(0);
    var blockStyle4=$('.blockStyle--style4').eq(0);
    var blockStyle5=$('.blockStyle--style5').eq(0);
    var blockStyle6=$('.blockStyle--style6').eq(0);
    var blockStyle7=$('.blockStyle--style7').eq(0);

    changeImg();
    deleteElementEvent();
    blockStyle__btnStyleEvent();
    blockStyle__btnClearHtmlEvent();
    increaseImage();
    decreaseImage();
    verifyBtnInputDisabled();

    $('#editorBlog__style1').on('click',function(){
        $('.editorModal').fadeOut();
        $('.editorModal').css('bottom','0px');
        $('.editorModal').css('rigth','0px');
        let blockStyle=$(blockStyle1).clone();
        $(blockStyle).css('display','flex');
        $('#editorBlog__content').append(blockStyle);
        deleteElementEvent();
        verifyBtnInputDisabled();
       
    })

    $('#editorBlog__style2').on('click',function(){
        $('.editorModal').fadeOut();
        let blockStyle=$(blockStyle2).clone();
        $(blockStyle).css('display','flex');
        $('#editorBlog__content').append(blockStyle);
        changeImg();
        deleteElementEvent();
        increaseImage();
        decreaseImage();
        leftImage();
        rightImage();
        centerImage();
        verifyBtnInputDisabled();
    })

    $('#editorBlog__style3').on('click',function(){
        $('.editorModal').fadeOut();
        let blockStyle=$(blockStyle3).clone();
        $(blockStyle).css('display','flex');
        $('#editorBlog__content').append(blockStyle);
        changeImg();
        deleteElementEvent();
        increaseImage();
        decreaseImage();
        verifyBtnInputDisabled();
    })

    $('#editorBlog__style4').on('click',function(){
        $('.editorModal').fadeOut();
        let blockStyle=$(blockStyle4).clone();
        $(blockStyle).css('display','flex');
        $(blockStyle).css('flex-direction','column');
        $('#editorBlog__content').append(blockStyle);
        changeImg();
        deleteElementEvent();
        increaseImage();
        verifyBtnInputDisabled();
    })

    $('#editorBlog__style5').on('click',function(){
        $('.editorModal').fadeOut();
        let blockStyle=$(blockStyle5).clone();
        $(blockStyle).css('display','flex');
        $(blockStyle).css('flex-direction','column');
        $('#editorBlog__content').append(blockStyle);
        changeImg();
        deleteElementEvent();
        increaseImage();
        decreaseImage();
        verifyBtnInputDisabled();
    })

    $('#editorBlog__style6').on('click',function(){
        $('.editorModal').fadeOut();
        let blockStyle=$(blockStyle6).clone();
        $(blockStyle).css('display','flex');
        $(blockStyle).css('flex-direction','column');
        $('#editorBlog__content').append(blockStyle);
        changeImg();
        deleteElementEvent();
        increaseImage();
        decreaseImage();
        verifyBtnInputDisabled();
    })

    $('#editorBlog__style7').on('click',function(){
        $('.editorModal').fadeOut();
        let blockStyle=$(blockStyle7).clone();
        $(blockStyle).css('display','flex');
        $(blockStyle).css('flex-direction','column');
        $('#editorBlog__content').append(blockStyle);
        changeImg();
        deleteElementEvent();
        increaseImage();
        decreaseImage();
        verifyBtnInputDisabled();
    })

    function verifyBtnInputDisabled(){
        if($('#editorBlog__content').html().length==66){
            $('#btnSubmit').prop('disabled',true);
        }else{
            $('#btnSubmit').prop('disabled',false);
        }
    }

   function increaseImage(){
        $('.increaseImage').each(function(){
            $(this).on('click',function(){
                let image=$(this).closest('.blockStyle__blockContent--image').find('.blockStyle__image');
                let width=$(image).width();
                $(image).css('width',width+4+"px");
            })
        })
   }

   function decreaseImage(){
        $('.decreaseImage').each(function(){
            $(this).on('click',function(){
                let image=$(this).closest('.blockStyle__blockContent--image').find('.blockStyle__image');
                let width=$(image).width();
                $(image).css('width',width-4+"px");
            })
        })
    }

    function leftImage(){
        $('.leftImage').each(function(){
            $(this).on('click',function(){
                let image=$(this).closest('.blockStyle__blockContent--image');
                $(image).css('align-items','flex-start');
            })
        })
    }

    function centerImage(){
        $('.centerImage').each(function(){
            $(this).on('click',function(){
                let image=$(this).closest('.blockStyle__blockContent--image');
                $(image).css('align-items','center');
            })
        })
    }

    function rightImage(){
        $('.rightImage').each(function(){
            $(this).on('click',function(){
                let image=$(this).closest('.blockStyle__blockContent--image');
                $(image).css('align-items','flex-end');
            })
        })
    }
    
    function changeImg(){
        $('.blockStyle__image').each(function(){
            $(this).on('click',function(e){
                e.preventDefault();
                let img=$(this);
                $(this).next().trigger('click');
                let inputFile=$(this).next();
                $(inputFile).on('change',function(e){
                    $(img).removeAttr('default');
                    uploadPicture($(this),img);
                });
            })
        })
    }
    
    function uploadPicture(picture,img){
        let form=ONLY_HTMLELEMENT('#formUpload');
        let pictureClone=$(picture).clone();
        $(form).append(pictureClone);        
        var form_data = new FormData(form);
        
        $.ajax({
            url: rotaEditorUpload, 
            type: 'POST',      
            data: form_data,
            processData:false,
            contentType:false,     
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(json){  
                $(img).attr('src',json.location);
            }, 
        });

        $(form).empty();
    }

    $('.editorModal').draggable();
    $('.editorBlog-header').draggable();
    $('.btnEditor').draggable();
    
    
    $('.editorModal__close').on('click',function(){
        $('.editorModal').fadeToggle();
    })

    $('.btnEditor').on('click',function(){
        $('.editorModal').fadeToggle();
        $('.editorModal').css('bottom','10px');
        $('.editorModal').css('right','100px');
        $('.blockStyle__btnStyle').css('display','block')
        blockStyle__btnStyleEvent();
    })

    $('#btnSubmit').on('click',function(event){
        event.preventDefault();
        let htmlEditor=document.getElementById('editorBlog__content').innerHTML;
        removeButtonsAndClose();
        let html=document.getElementById('editorBlog__content').innerHTML;
        $('#html').val(html);
        $('#htmlEditor').val(htmlEditor);
        $('#formEditorHtml').trigger('submit');
    })

    function removeButtonsAndClose(){
        $('#editorBlog__content').find('.close').remove();
        $('#editorBlog__content').find('button').remove();
        $('#editorBlog__content').find('.blockContent--image__header').remove();
        $('.blockStyle__image').each(function(){
            let defaultImage=$(this).attr('default');
            if(defaultImage!==undefined){
                $('#editorBlog__content').find($(this).remove());
            }
        })

    }
     
    function blockStyle__btnClearHtmlEvent(){
        let blockContent=$('#editorBlog__content').find('.htmlSlot');
        $(blockContent).each(function(){
            let blockActual=$(this);
            $(this).find('.blockStyle__btnClearHtml').on('click',function(key,event){
                $(this).closest('.htmlSlot').empty();
                $(blockActual).append('<button style="display:block;" class="blockStyle__btnStyle blockStyle__btnAddHtml">html</button>');
                blockStyle__btnStyleEvent();
            })
        })
        
    }

    function blockStyle__btnStyleEvent(){
        $('.blockStyle__btnAddHtml').each(function(){
            $(this).on('click',function(){
                let html=tinyMCE.activeEditor.getContent();
                let blockContent=$(this).closest('.htmlSlot');
                $(blockContent).empty();
                $(blockContent).html(html);
                $(blockContent).append('<button style="display:block;" class="blockStyle__btnStyle blockStyle__btnClearHtml">limpar</button>');
                
                $('.blockStyle__btnClearHtml').on('click',function(){
                    $(blockContent).empty();
                    $(blockContent).append('<button style="display:block;" class="blockStyle__btnStyle blockStyle__btnAddHtml">html</button>');
                    blockStyle__btnStyleEvent();
                })
            })
        })
        
    }

    function deleteElementEvent(){
        $('.blockStyle__close').each(function(){
            $(this).on('click',function(){
                $(this).closest('.blockStyle').remove();
                verifyBtnInputDisabled();
                changeImg();
            })
        })
    }

    tinymce.init({
        selector: '.editor',  // change this value according to your HTML
        plugins: 'fullpage',
        fullpage_default_doctype: '<!DOCTYPE html>'
    });
  
    
})