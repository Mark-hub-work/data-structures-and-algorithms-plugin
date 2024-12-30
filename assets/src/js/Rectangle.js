export class Rectangle {

  static tallest = 0
  height = 0
  width = 0
  element = null

  constructor(height, width) {
    this.height = height;
    this.width = width;
    this.element = document.createElement('div')
    this.element.innerText = height
    this.element.style.height = height + "em"
    this.element.style.width = width + "em"
    this.element.style.color = "white"
    this.element.style.background = "blue"
    this.element.style.bottom = "0"
    this.element.style.margin = "0.5em"
    this.element.style.display = "flex"
    this.element.style.alignItems = "center"
    this.element.style.justifyContent = "center"
  }

  static set tallest(newTallest) {
    this.tallest = newTallest
  }

  set height(newHeight) {
    this.height = newHeight
  }

  set width(newWidth) {
    this.width = newWidth
  }


  static get tallest() {
    return this.tallest
  }

  get height() {
    return this.height
  }

  get width() {
    return this.width
  }

  get element() {
    return this.element;
  }

}
