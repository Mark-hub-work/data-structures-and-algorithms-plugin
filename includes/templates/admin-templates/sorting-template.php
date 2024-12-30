<?php?>

<div id="sort-settings-wrapper">

  <div id="sort-number-list-wrapper">
    <p id="sort-number-list"><p>
  </div>

  <div id="sort-selection-settings">
    <select name="sorting-type" class="sorting-type-selector">
      <option value="Bubble Sort">Bubble Sort</option>
      <option value="Selection Sort">Selection Sort</option>
      <option value="Insertion Sort">Insertion Sort</option>
    </select>

    <label for="custom-data">Custom Data</label>
    <input type="radio" id="custom-data" name="custom_or_random_data" value="CustomData">
    <label for="random-data">Random Data</label>
    <input type="radio" id="random-data" name="custom_or_random_data" value="RandomData">
  </div>

  <div id="data-input-wrapper"></div>

  <div id="start-sorting-btn-wrapper">
    <button id='start-sorting-btn'>Start Sorting!</button>
  </div>
</div>
<?php

