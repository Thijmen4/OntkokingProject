const chips = document.querySelectorAll('.chip');
chips.forEach(chip => {
    chip.addEventListener('click', () => {
        chips.forEach(c => c.classList.remove('selected'));
        chip.classList.add('selected');
    });
});

const photoUploadBox = document.getElementById('photoUploadBox');
const fileInput = document.getElementById('fileInput');
const imagePreview = document.getElementById('imagePreview');

photoUploadBox.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

const addIngredientBtn = document.getElementById('addIngredientBtn');
const ingredientList = document.getElementById('ingredientList');

addIngredientBtn.addEventListener('click', () => {
    const newRow = document.createElement('div');
    newRow.className = 'ingredient-row';
    newRow.innerHTML = `
        <input type="text" placeholder="Ingrediënt">
        <input type="text" placeholder="Hoeveelheid">
    `;
    ingredientList.insertBefore(newRow, addIngredientBtn);
});

const addStepBtn = document.getElementById('addStepBtn');
const stepsList = document.getElementById('stepsList');

addStepBtn.addEventListener('click', () => {
    const stepCount = stepsList.querySelectorAll('.step-row').length + 1;
    const formattedNum = stepCount < 10 ? '0' + stepCount : stepCount;

    const newStep = document.createElement('div');
    newStep.className = 'step-row';
    newStep.innerHTML = `
        <div class="step-number">${formattedNum}</div>
        <textarea placeholder="Beschrijf deze stap..."></textarea>
    `;
    stepsList.insertBefore(newStep, addStepBtn);
});

const recipeForm = document.getElementById('recipeForm');
recipeForm.addEventListener('submit', (e) => {
    e.preventDefault();
    alert('Recept succesvol opgeslagen! (Dummy actie)');
});