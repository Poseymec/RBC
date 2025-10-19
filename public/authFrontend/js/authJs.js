/*function togglePasswordVisibility() {
    let passwordField = document.getElementById("password");
    let toggleIcon = document.getElementById("togglePassword");
    
    if (passwordField.type === "password") {
      passwordField.type = "text";
      toggleIcon.style.backgroundImage = "url('fas fa-eye')";
    } else {
      passwordField.type = "password";
      toggleIcon.style.backgroundImage = "url('eye-icon.png')";
    }
  }*/
  function togglePasswordVisibility() {
    let passwordField = document.getElementById("password");
    let eyeIcon = document.getElementById("eyeIcon");
    
    if (passwordField.type === "password") {
      passwordField.type = "text";
      eyeIcon.classList.remove("fa-eye");
      eyeIcon.classList.add("fa-eye-slash");
    } else {
      passwordField.type = "password";
      eyeIcon.classList.remove("fa-eye-slash");
      eyeIcon.classList.add("fa-eye");
    }
  }
  