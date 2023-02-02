// Get the form element
const form = document.getElementById('login.html');

// Get the form's submit button
const submitButton = form.querySelector('button[type="submit"]');

// Add a submit event listener to the form
form.addEventListener('submit', function(event) {
  // Prevent the default form submission behavior
  event.preventDefault();

  // You can also disable the submit button to prevent multiple submissions
  submitButton.disabled = true;

  // You can get the form data using the FormData API
  const formData = new FormData(form);

  // You can use the fetch API to submit the form data to the server
  fetch('/submit-form', {
    method: 'POST',
    body: formData
  }).then(function(response) {
    // You can handle the response here
  }).catch(function(error) {
    // You can handle any errors here
  }).finally(function() {
    // You can re-enable the submit button here
    submitButton.disabled = false;
  });
});
