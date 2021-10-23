function validate(){
  var name = document.getElementById("name").value;
  var l_name = document.getElementById("l_name").value;
  var phone = document.getElementById("phone").value;
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  var c_password = document.getElementById("c_password").value;
  var error_message = document.getElementById("error_message");
  
  error_message.style.padding = "10px";
  
  var text;
  if(name.length < 5){
    text = "Please Enter valid Name";
    error_message.innerHTML = text;
    return false;
  }
  if(l_name.length < 5){
    text = "Please Enter valid Last Name";
    error_message.innerHTML = text;
    return false;
  }
  if(isNaN(phone) || phone.length != 10){
    text = "Please Enter valid Phone Number";
    error_message.innerHTML = text;
    return false;
  }
  if(email.indexOf("@") == -1 || email.length < 6){
    text = "Please Enter valid Email";
    error_message.innerHTML = text;
    return false;
  }
  if(password.length<6 || !password.match(/^[0-9a-zA-Z]+$/) ){
    text = "Password is not strong enough";
    error_message.innerHTML = text;
    return false;
  }
  if(password!=c_password){
    text = "password does not match";
    error_message.innerHTML = text;
    return false;
  }
  
  
  //return true;
}