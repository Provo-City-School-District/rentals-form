const spacesByLocation = {
  38: ["Conference Room A", "Conference Room B", "Auditorium"],
  100: ["Gym", "Library", "Cafeteria"],
  101: ["Classroom 1", "Classroom 2", "Playground"],
  // Add more locations and their corresponding spaces here...
};

function updateSpaces() {
  const locationSelect = document.getElementById("location_request");
  const spaceContainer = document.getElementById("space_request_container");
  const spaceSelect = document.getElementById("space_request");

  const selectedLocation = locationSelect.value;

  // Clear existing options
  spaceSelect.innerHTML = '<option value="">Select a space</option>';

  if (spacesByLocation[selectedLocation]) {
    // Populate new options
    spacesByLocation[selectedLocation].forEach((space) => {
      const option = document.createElement("option");
      option.value = space;
      option.textContent = space;
      spaceSelect.appendChild(option);
    });

    // Show the space dropdown
    spaceContainer.style.display = "block";
  } else {
    // Hide the space dropdown if no spaces are available
    spaceContainer.style.display = "none";
  }
}

function toggleNonprofitAttachment(isNonprofit) {
  const attachmentContainer = document.getElementById(
    "nonprofit-attachment-container"
  );
  const attachmentInput = document.getElementById("nonprofit-document");

  if (isNonprofit) {
    attachmentContainer.style.display = "block";
    attachmentInput.setAttribute("required", "required");
  } else {
    attachmentContainer.style.display = "none";
    attachmentInput.removeAttribute("required");
  }
}

document.getElementById("date").addEventListener("change", function () {
  const dateInput = document.getElementById("date");
  const selectedDate = new Date(dateInput.value);
  const today = new Date();
  const sevenDaysFromNow = new Date();
  sevenDaysFromNow.setDate(today.getDate() + 7);
  const threeMonthsFromNow = new Date();
  threeMonthsFromNow.setMonth(today.getMonth() + 3);

  // Clear any previous error message
  const errorMessage = document.getElementById("date-error");
  if (errorMessage) {
    errorMessage.remove();
  }

  // Validate the selected date
  if (selectedDate < sevenDaysFromNow) {
    showError(dateInput, "You cannot request a date fewer than 7 days away.");
  } else if (selectedDate > threeMonthsFromNow) {
    showError(dateInput, "You cannot request a date more than 3 months out.");
  } else {
    dateInput.setCustomValidity(""); // Clear any custom validity
  }
});

function showError(inputElement, message) {
  inputElement.setCustomValidity(message);
  inputElement.reportValidity();

  // Display error message below the input
  const errorElement = document.createElement("div");
  errorElement.id = "date-error";
  errorElement.className = "error";
  errorElement.textContent = message;
  inputElement.parentNode.insertBefore(errorElement, inputElement.nextSibling);
}
