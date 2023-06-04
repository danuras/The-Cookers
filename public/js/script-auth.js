const showPassword = document.querySelector("#show-password");
const passwordField = document.querySelector("#password");

showPassword.addEventListener("click", function () {
  this.classList.toggle("fa-eye-slash");
  const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
  passwordField.setAttribute("type", type);
})

const showPasswordConfirm = document.querySelector("#show-password-confirm");
const paswordFieldConfirm = document.querySelector("#password-confirm");

showPasswordConfirm.addEventListener("click", function () {
  this.classList.toggle("fa-eye-slash");
  const type = paswordFieldConfirm.getAttribute("type") === "password" ? "text" : "password";
  paswordFieldConfirm.setAttribute("type", type);
})

function countCharacterInfo() {
    var input = document.getElementById("info");
    var countElement = document.getElementById("infoCount");
    var count = input.value.length;
    var maxLength = input.getAttribute("maxlength");
    countElement.textContent = count + "/" + maxLength;
}

function countCharacterBio() {
  var input = document.getElementById("bio");
  var countElement = document.getElementById("bioCount");
  var count = input.value.length;
  var maxLength = input.getAttribute("maxlength");
  countElement.textContent = count + "/" + maxLength;
}

function tampilkanGambar(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
          document.getElementById("gambar-preview").setAttribute("src", e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
  }
}