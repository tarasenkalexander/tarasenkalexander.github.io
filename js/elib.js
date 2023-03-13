$(document).ready(function () {

$('[data-toggle="tooltip"]').tooltip();

$('select').change(function() {
  $('#mainform').submit();
});

$('#search-box').keypress(function(eObject) {
  if(eObject.keyCode==13) {
    $('#query').val($('#search-box').val());
    $('#mode').val('search');
    $('#mainform').submit();
  }
});

$('#btn-clear').click(function(event) {
  event.preventDefault();  
  window.location = '/';
});


$('#back-btn').click(function() {
  history.back(1);
});

$('#btn-closewindow').click(function() {
  window.close();
});

$('#btn-first').click(function(event) {
  event.preventDefault();
  $('#page-nav').val('0');
  $('#mode').val('page');
  $('#mainform').submit();
});

$('#btn-prev').click(function(event) {
  event.preventDefault();
  page = $('#page-nav').val();
  page--;
  $('#page-nav').val(page);
  $('#mode').val('page');
  $('#mainform').submit();
});

$('#btn-next').click(function(event) {
  event.preventDefault();
  page = $('#page-nav').val();
  page++;
  $('#page-nav').val(page);
  $('#mode').val('page');
  $('#mainform').submit();
});

$('#btn-last').click(function(event) {
  event.preventDefault();
  $('#page-nav').val($(this).attr('data-page'));
  $('#mode').val('page');
  $('#mainform').submit();
});

$('#wmsg').click(function(event) {
  event.preventDefault();
	$(this).parent().hide(300);
	$.post( '', { wmsg: 0 } );
});

$('a').click(function(event) {
  if($(this).attr('id')=='chr'){
    event.preventDefault();
    $('#char').val($(this).html());
    $('#mode').val('char');
    $('#mainform').submit();
  }
});

$('#booklist>tbody>tr').click(function(event) {
  event.preventDefault();
  book = $(this).attr('book-id');
  if(book!=null) {
    $('#booklist').hide();
    $('#book').hide();
    var loadbook = $.post( '', { bookid: book } );
    loadbook.done(function(data) {
      $('#book').html(data);
      $('#book').show(200);
    });
  }
});


});