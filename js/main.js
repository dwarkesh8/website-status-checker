$(document).ready(function(){
  $('#btnSubmit').on('click',function(){
    var url = $('#url').val();
    if (url != '' && url != null && url.length > 0) {
      $.post('server/api.php',{cmd:'add',url:url},function(resp){
        console.log(resp);
      });
    }
  })
  $('#dynamicTbody').on('click','tr td:nth-child(3) button',function(){
    var id = $(this).attr('id');
    if (id != '' && id != null && id.length > 0) {
      $.post('server/api.php',{cmd:'delete',id:id},function(resp){
        console.log(resp);
      });
    }
  });
  function checkStatus() {
    $.post('server/api.php',{cmd:'checkWebsiteStatus'},function(resp){
      if (resp !== null && resp !== '') {
        $('#dynamicTbody').html(resp);
      }
      else {
        var table = '<tr class="text-center"><td colspan="3">No URLs found!</td></tr>';
        $('#dynamicTbody').html(table);
      }
    });
  }
  checkStatus();
  setInterval(function(){
    checkStatus();
  },10000);
});