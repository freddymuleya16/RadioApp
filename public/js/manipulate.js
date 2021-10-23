$(document).ready(function(){

console.log("is");

$('#comments_tab').hide();
$('#playlist_tab').hide();

console.log($('button#tab1'));

$('#tab1').click(function(){
	console.log("act");
	$('#player_tab1').show();
	$('#player_tab2').show();
	$('#comments_tab').hide();
	$('#playlist_tab').hide();
});
$('#tab2').click(function(){
	//$('')
	console.log("acdt");
	$('#player_tab1').hide();
	$('#player_tab2').hide();
	$('#comments_tab').hide();
	$('#playlist_tab').show();
});
$('#tab3').click(function(){
	//$('')
	console.log("acst");
	$('#player_tab1').hide();
	$('#player_tab2').hide();
	$('#comments_tab').show();
	$('#playlist_tab').hide();
});

});