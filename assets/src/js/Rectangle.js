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
    this.element.style.color = "blue"
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
