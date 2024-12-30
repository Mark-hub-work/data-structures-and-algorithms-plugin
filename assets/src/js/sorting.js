import { Rectangle } from './Rectangle.js'

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

  // add custom data input field
  if(document.getElementById("custom-data-input") === null) {
    // create the new elements
    let customDataInput = document.createElement('input')
    customDataInput.setAttribute('id', 'custom-data-input')
    let customDataLabel = document.createElement('label')
    customDataLabel.setAttribute('id', 'custom-data-input-label')
    customDataLabel.setAttribute('for', 'custom-data-input')

    // add the new elements
    customDataLabel.innerText = "Add a comma separated list of 1-25 numbers.";
    document.getElementById('data-input-wrapper').appendChild(customDataInput)
    document.getElementById('data-input-wrapper').appendChild(customDataLabel)

    // add an event listener to visualize the requested data
    document.getElementById("custom-data-input").addEventListener("focusout", visualizeData)
    
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

    // add an event listener to visualize the requested data
    document.getElementById("random-data-input").addEventListener("focusout", visualizeData)
  }

  return
  
}

function visualizeData() {

  // custom data
  if(document.getElementById("custom-data-input") !== null) {
    let customData = document.getElementById('custom-data-input').value
    let customDataArray = validateCustomData(customData)

    if(customDataArray) {
      clearRectangles()
      customDataArray.forEach(number => {
        generateRectangle(number)
      })
    }
  }
  

  // random data
  if(document.getElementById("random-data-input") !== null) {
    let numOfRandData = document.getElementById('random-data-input').value
    console.log(numOfRandData)
  }

  return
}

function validateCustomData(data) {
  let dataArray = data.split(',')
  if(!dataArray.some(isNaN)) {
    return dataArray
  } else {
    return false
  }
}

function generateRectangle(number) {
  let rectangle = new Rectangle(number, 2)
  document.getElementById('sorting-visualization-area').appendChild(rectangle.element)
  
  return;
}

function clearRectangles() {
  document.getElementById('sorting-visualization-area').innerHTML = '';
}