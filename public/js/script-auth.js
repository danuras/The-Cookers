document.addEventListener('DOMContentLoaded', function () {
  const loginText = document.querySelector(".title-text .login");
  const loginForm = document.querySelector("form.login");
  const signupForm = document.querySelector("form.signup");
  const loginBtn = document.querySelector("label.login");
  const signupBtn = document.querySelector("label.signup");
  const signupLink = document.querySelector("form.login .signup-link a");

  const urlParams = new URLSearchParams(window.location.search);
  const action = urlParams.get('action');

  const loginRadio = document.getElementById('login');
  const signupRadio = document.getElementById('signup');

  if (action === 'masuk') {
    loginRadio.checked = true;
    showLoginForm();
  } else if (action === 'daftar') {
    signupRadio.checked = true;
    showSignupForm();
  }

  function showLoginForm() {
    loginForm.style.transform = 'translateX(0%)';
    signupForm.style.transform = 'translateX(100%)';
  }

  function showSignupForm() {
    loginForm.style.transform = 'translateX(-100%)';
    signupForm.style.transform = 'translateX(-100%)';
  }

  loginRadio.addEventListener('click', showLoginForm);
  signupRadio.addEventListener('click', showSignupForm);

  signupLink.addEventListener('click', function (event) {
    signupRadio.checked = true;
    showSignupForm();
    event.preventDefault();
  });
});
