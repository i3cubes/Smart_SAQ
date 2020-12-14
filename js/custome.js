function checkUser(uid){
    if(uid==""){
        window.location='/Fentons/ICT/index';
    }
    else if(uid==null){
        window.location='/Fentons/ICT/index';
    }
}
function checkUserPopUp(uid){
	if(uid==""){
		//window.opener.location="./index.php";
		window.parent.location="./Fentons/ICT/index";
		window.close();
	}
}
function checkUserPopUpL3(uid){
	if(uid==""){
		//window.opener.location="./index.php";
		window.parent.opener.location="/Fentons/ICT/index";
		window.parent.close();
		window.close();
	}
}
function checkUserPopUpBlank(uid){
	if(uid==""){
		window.opener.location="/Fentons/ICT/index";
		//window.parent.location="./index.php";
		window.close();
	}
}