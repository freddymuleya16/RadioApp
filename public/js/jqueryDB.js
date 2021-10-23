$(document).ready(function () {
  var commentsCount = 2;
  $("#load").click(function () {
    commentsCount = commentsCount + 2;
    $("#commentOld").load(URLROOT + "home/load_comments/" + commentsCount);
  });

	$("#commentbtn").click(function () {
		debugger;
    var comment = $("#comment").val();
    var author = $("#author").val();

    if (comment.length > 5) {
      $("#submitComment").load(URLROOT + "home/submitComment", {
        comment: comment,
        author: author,
      });
	} else {
		alert("Comment too short");
	}
  });

  /********************************************************************************************************/
  $("#likeBtn").click(function () {
    var songId = $("#audio-player .ide").text();
    $("#numLikes").load(URLROOT + "home/addLike/" + songId);
  });

  $("#unlikeBtn").click(function () {
    var songId = $("#audio-player .ide").text();
    $("#numDislikes").load(URLROOT + "home/addDislike/" + songId);
  });

  /********************************************************************************************************/
});
function loadLikes(songId) {
  $("#numLikes").load(URLROOT + "home/loadLike/" + songId);
}

function loadDislikes(songId) {
  //var songId = $('#audio-player .ide').text();
  //$("#numDislikes").text(null);
  $("#numDislikes").load(URLROOT + "home/loadDislike/" + songId);
}
