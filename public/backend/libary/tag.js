// Get the tags and input elements from the DOM
const tags = document.getElementById('tags');
const input = document.getElementById('input-tag');
console.log(tags, input);

// Function to handle adding a new tag
function addTag() {
    // Create a new list item element for the tag
    const tag = document.createElement('li');

    // Get the trimmed value of the input element
    const tagContent = input.value.trim();

    // If the trimmed value is not an empty string
    if (tagContent !== '') {
        // Set the text content of the tag to the trimmed value
        tag.innerText = tagContent;

        // Add a delete button to the tag
        tag.innerHTML += '<button class="delete-button">X</button>';

        // Append the tag to the tags list
        tags.appendChild(tag);

        // Clear the input element's value
        input.value = '';
    }
}

// Event listener for keydown event on input
input.addEventListener('keydown', function (event) {
    // If Enter key is pressed
    if (event.key === 'Enter') {
        // Prevent the default action of the keypress event (submitting the form)
        event.preventDefault();
        // Call the function to add a new tag
        addTag();
    }
});

// Event listener for click event on tags list
tags.addEventListener('click', function (event) {
    // If the clicked element has the class 'delete-button'
    if (event.target.classList.contains('delete-button')) {
        // Remove the parent element (the tag)
        event.target.parentNode.remove();
    }
});

// Event listener to clear input when clicked outside
document.addEventListener('click', function (event) {
    // If the click event did not occur inside the input element
    if (event.target !== input) {
        // Clear the input element's value
        input.value = '';
    }
});
