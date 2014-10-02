jQuery(document).ready( function($) {
    /*
     *$('.field-mega-menu select').each(function() {
        $(this).change(function() {
           if ($(this).val() === 'mega') {
                $(this).parent().parent().parent().nextUntil('.menu-item-depth-0').find('span.item-type').text('Column');
                console.log('mega');
            } else {
                $(this).parent().parent().parent().nextUntil('.menu-item-depth-0').find('span.item-type').text('Custom');
            }
        });
        
    });
    */

$('.menu_icon_bt').on('click',function() {
    mid = "#edit-menu-item-micon-" + $(this).attr('data-id');
    prv = "#icon_prv_" + $(this).attr('data-id');
    $('#mom_menu_icon').on('click',function() {
        var icon = $('input[name="mom_menu_item_icon"]:checked').val();
        $(mid).val(icon);
        $(prv).removeClass().addClass('icon_prv '+icon);
        $(prv).find('.remove_icon').show();
            tb_remove();
            return false;
    });
});
$('.icon_prv').each(function() {
    $(this).addClass($(this).next('input').val());
});

$('.icon_prv .remove_icon').click(function () {
    $(this).hide();
   $(this).parent().removeClass().addClass('icon_prv');
   $(this).parent().next('input').val('');
   return false;
});
$('.edit-menu-item-micon').each(function() {
    if ($(this).val() === '') {
        $(this).prev('.icon_prv').find('.remove_icon').hide();
    }
});

$('.edit-menu-item-mtype').on('change', function() {
    var t = $(this);
    var id = $(this).attr('id');
    id = id.split('-');
    if ($(this).val() === 'cats') {
        $(this).parent().parent().parent().find('.field-mcats_layout').slideDown(250);
        $(this).parent().parent().parent().find('.field-mcustom').slideUp('fast');
    } else if ($(this).val() === 'custom') {
        $(this).parent().parent().parent().find('.field-mcustom').slideDown(250);
        $(this).parent().parent().parent().find('.field-mcats_layout').slideUp('fast');
    } else {
        $(this).parent().parent().parent().find('.field-mcustom').slideUp('fast');
        $(this).parent().parent().parent().find('.field-mcats_layout').slideUp('fast');
    }
});

$('.edit-menu-item-mtype').each(function() {
    if ($(this).val() === 'cats') {
        $(this).parent().parent().parent().find('.field-mcats_layout').slideDown(250);
        $(this).parent().parent().parent().find('.field-mcustom').slideUp('fast');
    } else if ($(this).val() === 'custom') {
        $(this).parent().parent().parent().find('.field-mcustom').slideDown(250);
        $(this).parent().parent().parent().find('.field-mcats_layout').slideUp('fast');
    } else {
        $(this).parent().parent().parent().find('.field-mcustom').slideUp('fast');
        $(this).parent().parent().parent().find('.field-mcats_layout').slideUp('fast');
    }
});

});