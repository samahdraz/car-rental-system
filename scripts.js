// const loginUserName = document.getElementById("submit");
// const userNameGetter = document.getElementById("name");
// const passwordGetter = document.getElementById("Password");
// const userAlertMessage = document.getElementById("nameFady");
// const passwordAlertMessage = document.getElementById("passwordFady");
// const userName = "admin";
// const checkPassword = "admin";
// console.log(userNameGetter.getAttribute("placeholder"))
// const required = (fun) => {
//     // console.log(fun)
//     // debugger
//     fun.classList.add("is-invalid");
//     fun.getAttribute("placeholder") == "Username" ? userAlertMessage.innerText = "You should fill this field" : "";
//     fun.getAttribute("placeholder") == "Password" ? passwordAlertMessage.innerText = "You should fill this field" : "";
// }
// const isValid=(fun)=>{
//     fun.classList.add("is-valid");  
// }
// // console.log(userNameGetter,"\n",passwordGetter)
// function validity() {
    
//     userAlertMessage.innerText="";
//     passwordAlertMessage.innerText="";
//     userNameGetter.classList.remove("is-invalid");
//     passwordGetter.classList.remove("is-invalid");
//     let name = userNameGetter.value;
//     let password = passwordGetter.value;
//     name = name.trim();
//     console.log(name);
//     password = password.trim();
//     name === "" ? required(userNameGetter) : isValid(userNameGetter);
//     password == "" ? required(passwordGetter) : isValid(passwordGetter);
//     // console.log(name)
//     // console.log(password)
// }
// loginUserName.addEventListener('click', validity);


const loginUserName = document.getElementById("submit");
const userNameGetter = document.getElementById("name");
const passwordGetter = document.getElementById("Password");
const userAlertMessage = document.getElementById("nameFady");
const passwordAlertMessage = document.getElementById("passwordFady");
const searchPlate= document.getElementById("search");
const userName = "admin";
const checkPassword = "admin";


localStorage.setItem("username", userName);
localStorage.setItem("password", checkPassword);

const Searching=e=>{
  console.log(e);

}
const required = (fun) => {
  fun.classList.add("is-invalid");
  if (fun.getAttribute("placeholder") === "Username") {
    userAlertMessage.innerText = "Incorrect";
  }
  if (fun.getAttribute("placeholder") === "Password") {
    passwordAlertMessage.innerText = "Incorrect";
  }
};

const isValid = (fun1, fun2) => {
  fun1.classList.add("is-valid");
  fun2.classList.add("is-valid");
  window.location.href = "admin.html";
};

function validity() {
  userAlertMessage.innerText = "";
  passwordAlertMessage.innerText = "";
  userNameGetter.classList.remove("is-invalid");
  passwordGetter.classList.remove("is-invalid");
  let name = userNameGetter.value.trim();
  let password = passwordGetter.value.trim();

  if (name === "") {
    required(userNameGetter);
  }
  if (password === "") {
    required(passwordGetter);
  }

  if (name === localStorage.getItem("username") && password === localStorage.getItem("password")) {
    isValid(userNameGetter, passwordGetter);
    console.log(userNameGetter.innerText, "blabal");
  } else {
    required(userNameGetter);
    required(passwordGetter);
  }
}

loginUserName.addEventListener('click', validity);