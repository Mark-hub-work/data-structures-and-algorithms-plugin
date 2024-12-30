// dataType = document.querySelector('input[name="custom_or_random_data"]:checked.value');

document.getElementById("custom-data").addEventListener("click", addCustomDataInputFields)
document.getElementById("random-data").addEventListener("click", addRandomDataInputFields)

function addCustomDataInputFields() {

  // remove random data input fields
  if(document.getElementById("random-data-input") !== null) {
    let randomDataInput = document.getElementById("random-data-input")
    let randomDataLabel = document.getElementById("random-data-input-label")
    document.getElementById('data-input-wrapper').removeChild(randomDataInput)
    document.getElementById('data-input-wrapper').removeChild(randomDataLabel)
  }

  if(document.getElementById("custom-data-input") === null) {
    console.log('does not exist')
    let customDataInput = document.createElement('input')
    customDataInput.setAttribute('id', 'custom-data-input')
    let customDataLabel = document.createElement('label')
    customDataLabel.setAttribute('id', 'custom-data-input-label')
    customDataLabel.setAttribute('for', 'custom-data-input')

    customDataLabel.innerText = "Add a comma separated list of 1-25 numbers.";
    document.getElementById('data-input-wrapper').appendChild(customDataInput)
    document.getElementById('data-input-wrapper').appendChild(customDataLabel)


  } else {
    console.log(document.getElementById("custom-data-input"))
    console.log('does exist')
  }

  return;
}

function addRandomDataInputFields() {
  // remove custom data input field
  if(document.getElementById("custom-data-input") !== null) {
    let customDataInput = document.getElementById("custom-data-input")
    let customDataLabel = document.getElementById("custom-data-input-label")
    document.getElementById('data-input-wrapper').removeChild(customDataInput)
    document.getElementById('data-input-wrapper').removeChild(customDataLabel)
  }

  // add random data input field
  if(document.getElementById('random-data-input') === null) {
    // create the new elements
    let randomDataInput = document.createElement('input')
    randomDataInput.setAttribute('id', 'random-data-input')
    randomDataInput.setAttribute('type', 'number')
    let  randomDataLabel = document.createElement('label')
    randomDataLabel.setAttribute('id', 'random-data-input-label')
    randomDataLabel.setAttribute('for', 'random-data-input')
    randomDataLabel.innerText = 'Choose how many numbers you want generated. (1-25)'

    // add the new elements
    document.getElementById('data-input-wrapper').appendChild(randomDataInput)
    document.getElementById('data-input-wrapper').appendChild(randomDataLabel)
  }
}
