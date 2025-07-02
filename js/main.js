document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("addClientForm");
  const alertBox = document.getElementById("successAlert");

  // Detect if form was submitted with success (using PHP flag passed to JS)
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get("client") === "added") {
    showSuccessAlert();
  }

  function showSuccessAlert() {
    alertBox.style.display = "block";
    setTimeout(() => {
      alertBox.style.display = "none";
    }, 5000); // Auto-hide after 5 sec
  }
});
