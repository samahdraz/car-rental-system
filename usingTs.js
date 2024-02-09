var loginUserName = document.getElementById("submit");
var userNameGetter = document.getElementById("name");
var passwordGetter = document.getElementById("Password");
var userAlertMessage = document.getElementById("nameFady");
var passwordAlertMessage = document.getElementById("passwordFady");
var userName = "admin";
var checkPassword = "admin";
localStorage.setItem("username", userName);
localStorage.setItem("password", checkPassword);
// console.log(userNameGetter.getAttribute("placeholder"))
var required = function (fun) {
    // console.log(fun)
    // debugger
    fun.classList.add("is-invalid");
    fun.getAttribute("placeholder") == "Username" ? userAlertMessage.innerText = "Incorrect" : "";
    fun.getAttribute("placeholder") == "Password" ? passwordAlertMessage.innerText = "Incorrect" : "";
};
var isValid = function (fun1, fun2) {
    fun1.classList.add("is-valid");
    fun2.classList.add("is-valid");
    // console.log(window.location.href);
    window.location.href = "index.html";
};
// console.log(userNameGetter,"\n",passwordGetter)
function validity() {
    userAlertMessage.innerText = "";
    passwordAlertMessage.innerText = "";
    userNameGetter.classList.remove("is-invalid");
    passwordGetter.classList.remove("is-invalid");
    var name = userNameGetter.value;
    var password = passwordGetter.value;
    name = name.trim();
    console.log(name);
    password = password.trim();
    console.log(password);
    name == "" ? required(userNameGetter) : "";
    password == "" ? required(passwordGetter) : "";
    // console.log(localStorage.getItem("username"))
    if (name === localStorage.getItem("username") && password === localStorage.getItem("password")) {
        isValid(userNameGetter, passwordGetter);
        console.log(userNameGetter.innerText, "blabal");
    }
    else {
        required(userNameGetter);
        required(passwordGetter);
    }
    // if()
    // isValid(passwordGetter);
    // else
    //     required(passwordGetter)
    // name==localStorage.getItem("username")?isValid(userNameGetter):required(userNameGetter);
    // password==localStorage.getItem("password")?isValid(passwordGetter):required(passwordGetter);
    // console.log(name)
    // console.log(password)
}
loginUserName.addEventListener('click', validity);
