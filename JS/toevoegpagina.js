document.querySelectorAll('.chip').forEach(chip => {
    chip.onclick = () => {
        document.querySelectorAll('.chip').forEach(c => c.classList.remove('selected'));
        chip.classList.add('selected');
    };
});

const photoBox = document.getElementById('photoUploadBox');
const fileInput = document.getElementById('fileInput');
const preview = document.getElementById('imagePreview');

photoBox.onclick = () => fileInput.click();
fileInput.onchange = (e) => {
    if (e.target.files[0]) {
        preview.src = URL.createObjectURL(e.target.files[0]);
        preview.style.display = 'block';
    }
};

document.getElementById('addIngredientBtn').onclick = (e) => {
    const row = document.createElement('div');
    row.className = 'ingredient-row';
    row.innerHTML = `<input type="text" placeholder="Ingrediënt"><input type="text" placeholder="Hoeveelheid">`;
    document.getElementById('ingredientList').insertBefore(row, e.target);
};

document.getElementById('addStepBtn').onclick = (e) => {
    const count = document.querySelectorAll('.step-row').length + 1;
    const num = count < 10 ? '0' + count : count;
    const step = document.createElement('div');
    step.className = 'step-row';
    step.innerHTML = `<div class="step-number">${num}</div><textarea placeholder="Beschrijf deze stap..."></textarea>`;
    document.getElementById('stepsList').insertBefore(step, e.target);
};

document.getElementById('recipeForm').onsubmit = (e) => {
    e.preventDefault();
    alert('Recept opgeslagen!');
};