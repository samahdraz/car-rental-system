const loginUserName = document.getElementById("submit")! as HTMLButtonElement;
const userNameGetter = document.getElementById("name")! as HTMLInputElement;
const passwordGetter = document.getElementById("Password")! as HTMLInputElement;
const userAlertMessage = document.getElementById("nameFady")! as HTMLOutputElement;
const passwordAlertMessage = document.getElementById("passwordFady")! as HTMLOutputElement;
const userName = "admin";
const checkPassword = "admin";
localStorage.setItem("username", userName);
localStorage.setItem("password", checkPassword);
// console.log(userNameGetter.getAttribute("placeholder"))
const required = (fun: HTMLElement) => {
    // console.log(fun)
    // debugger
    fun.classList.add("is-invalid");
    fun.getAttribute("placeholder") == "Username" ? userAlertMessage.innerText = "Incorrect" : "";
    fun.getAttribute("placeholder") == "Password" ? passwordAlertMessage.innerText = "Incorrect" : "";
}
const isValid = (fun1: HTMLElement,fun2: HTMLElement) => {
    fun1.classList.add("is-valid");
    fun2.classList.add("is-valid");
    // console.log(window.location.href);
    window.location.href="index.html";
}
// console.log(userNameGetter,"\n",passwordGetter)
function validity() {

    userAlertMessage.innerText = "";
    passwordAlertMessage.innerText = "";
    userNameGetter.classList.remove("is-invalid");
    passwordGetter.classList.remove("is-invalid");
    let name = userNameGetter.value;
    let password = passwordGetter.value;
    name = name.trim();
    console.log(name);
    password = password.trim();
    console.log(password);
    name==""?required(userNameGetter):"";
    password==""?required(passwordGetter):"";
    // console.log(localStorage.getItem("username"))
    if(name===localStorage.getItem("username")&&password===localStorage.getItem("password")){

        isValid(userNameGetter,passwordGetter);
        console.log(userNameGetter.innerText ,"blabal");
    }
    else{

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


