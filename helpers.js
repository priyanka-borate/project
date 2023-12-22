function flash(message = "", color = "info") {
    let flash = document.getElementById("flash");
    //create a div (or whatever wrapper we want)
    let outerDiv = document.createElement("div");
    outerDiv.className = "row justify-content-center";
    let innerDiv = document.createElement("div");

    //apply the CSS (these are bootstrap classes which we'll learn later)
    innerDiv.className = `alert alert-${color}`;
    //set the content
    innerDiv.innerText = message;

    outerDiv.appendChild(innerDiv);
    //add the element to the DOM (if we don't it merely exists in memory)
    flash.appendChild(outerDiv);
}
function isValidUsername(username){
    const reUser = new RegExp('^[a-z0-9_-]{3,16}$');
    return reUser.test(username);
}
function isValidPassword(password){
    //const rePass = new RegExp('^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$');
    //return rePass.test(password);
    return password.length >= 8;
}
function isValidEmail(email){
    const reEmail = new RegExp('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$');
    return reEmail.test(email);
}
function isEqual(a,b){
    return a === b;
}
/*function toUsd(a){
    var a = (total).toLocaleString('en');
    return a;
    }*/